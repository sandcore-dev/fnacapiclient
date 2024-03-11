<?php

/*
 * This file is part of the FnacApiClient.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Client;

use FnacApiClient\Service\Request\PricesQuery;
use FnacApiClient\Service\Response\ResponseService;
use Monolog\Logger;
use FnacApiClient\Service\Request\RequestService;
use FnacApiClient\Toolbox\StringObject;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Laminas\Http\Client as LaminasClient;
use Laminas\Http\Client\Adapter\Curl;

/**
 * Client connect to Fnac API Services.
 *
 * This Client is useful if you want to use your own serializer, client or logger
 *
 * @author     Fnac
 * @version    1.0.0
 */
class Client
{
    const METHOD = 'POST';
    const ENCTYPE = 'text/xml';
    const ADAPTER = Curl::class;

    /**
     * Serializer to convert xml to object and object to xml
     *
     * @var Serializer
     */
    private $serializer = null;

    /**
     * Client to communicate with a REST WebService
     *
     * @var LaminasClient
     */
    private $streamClient = null;

    /**
     * Log object to output information, debug and error
     *
     * @var Logger
     */
    protected $logger = null;

    /**
     * Uri of REST WebService
     *
     * @var string
     */
    protected $uri;

    /**
     * REST WebService sent request
     *
     * @var string
     */
    public $xml_request;

    /**
     * REST WebService response
     *
     * @var string
     */
    public $xml_response;

    /**
     * Create a new Client
     *
     * @param Serializer $serializer
     * @param LaminasClient $streamClient : A client to send and receive from a rest webservice
     * @param Logger|null $logger : A logger to log request and response, useful for debugging
     */
    public function __construct(Serializer $serializer, LaminasClient $streamClient, Logger $logger = null)
    {
        $this->streamClient = $streamClient;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    public function getClient()
    {
        return $this->streamClient;
    }

    /**
     * Set the uri of the rest webservice
     *
     * @param string $uri : Uri of rest webservice
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Return the rest webservice uri currently use
     *
     * @return string $uri Rest webservice uri
     */
    public function getUri()
    {
        return rtrim($this->uri, '/');
    }

    /**
     * Return the rest webservice request that has been sent
     *
     * @return string $xml_request
     */
    public function getXmlRequest()
    {
        return $this->xml_request;
    }

    /**
     * Return the rest webservice response
     *
     * @return $xml_response
     */
    public function getXmlResponse()
    {
        return $this->xml_response;
    }


    /**
     * Wrapper for log
     *
     * @param string $level Level of message (Warning, Information, Error, etc...)
     * @param string $message Content of message
     */
    public function log($message, $level)
    {
        if (!is_null($this->logger)) {
            $this->logger->addRecord($level, $message);
        }
    }

    /**
     * Set logger to client
     *
     * @param Logger $logger
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Call a service on Fnac REST WebServices
     *
     * @param RequestService $service The service to call
     * @param bool $checkXML
     * @return ResponseService The service we expect to receive
     * @throws ExceptionInterface
     */
    public function callService(RequestService $service, $checkXML = false)
    {
        $this->log(sprintf("Call Service : %s", $service->getServiceName()), Logger::INFO);

        $request = $this->buildRequest($service);

        $this->xml_request = $request;

        if ($checkXML) {
            $service->checkXML($request);
        }

        $response = $this->sendRequest($service, $request);

        $this->log(sprintf(" Service Request Response HEADER :\n%s", print_r($response->getHeaders(), true)), Logger::DEBUG);
        if ($response->isClientError()) {
            $this->log(sprintf(" Service Request Response ERROR : %s", $response->renderStatusLine()), Logger::ERROR);
            //throw new ErrorResponseException($response);
        }

        $this->log(sprintf(" Service Request Response BODY :\n%s", StringObject::prettyXml($response->getBody())), Logger::INFO);

        $classResponse = $service->getClassResponse();
        $this->log(sprintf(" Service Response Class  : %s", $classResponse), Logger::DEBUG);

        if (str_ends_with($classResponse, "PricesQueryResponse")) {
            $response_body = preg_replace('/(<\?xml[^?]+?)utf-16/i', '$1utf-8', $response->getBody());
        } else {
            $response_body = $response->getBody();
        }

        $data = $this->serializer->decode($response_body, 'xml');
        $this->xml_response = $response->getBody();

        $this->log(sprintf(" Service Response Data  :\n %s", serialize($data)), Logger::DEBUG);

        return $this->serializer->denormalize($data, $classResponse);
    }

    private function buildRequest($service)
    {
        $encoder = new XmlEncoder([
            XmlEncoder::ROOT_NODE_NAME => $service->getServiceName(),
        ]);

        $encoders = array('xml' => $encoder);
        $normalizers = array(new CustomNormalizer());

        $this->serializer = new Serializer($normalizers, $encoders);

        $request = $this->serializer->serialize($service, 'xml');

        $request .= "<!-- generated with Fnac API Client -->";

        return $request;
    }

    private function sendRequest($service, $request)
    {
        $this->log(sprintf(" Service Request Data  : \n%s", StringObject::prettyXml($request)), Logger::INFO);

        //Define uri
        if ($service->getClassName() === "PricesQuery") { //Override pricing service name
            $this->streamClient->setUri($this->getUri() . '/' . PricesQuery::URL_NAME);
        } else {
            $this->streamClient->setUri($this->getUri() . '/' . $service->getServiceName());
        }
        $this->log(sprintf(" Service Request URI  : %s", $this->getUri()), Logger::INFO);

        $this->streamClient->setRawBody($request);
        $this->streamClient->setMethod(self::METHOD);
        $this->streamClient->setEncType(self::ENCTYPE);
        $this->streamClient->setAdapter(self::ADAPTER);

        return $this->streamClient->send();
    }
}
