<?php
/***
 *
 * This file is part of the fnacMarketPlace API Client GUI.
 * (c) 2013 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * ---------------------------------
 * Fnac Api Gui : Offers query Model
 *
 * @desc Class used to retrieve Batch query response
 * @author Somaninn Prok <sprok@fnac.com>
 *
 */

namespace FnacApiGui\Model;

use FnacApiClient\Client\SimpleClient;
use FnacApiClient\Entity\Offer;
use FnacApiClient\Exception\ErrorResponseException;
use FnacApiClient\Service\Request\OfferQuery;
use FnacApiClient\Service\Request\OfferUpdate;
use FnacApiClient\Service\Response\ResponseService;
use FnacApiClient\Type\OfferReferenceType;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class OffersQueryModel extends Model
{
    public function __construct()
    {
        $this->template = __DIR__ . "/../templates/offers_query.tpl.php";
    }

    /**
     * Retrieves Offers query response
     *
     * @param SimpleClient $client
     * @param array $options Request parameters
     * @return ResponseService
     */
    public function retrieveOffersResponse($client, $options = array())
    {
        $defaults = array(
            'page' => 1,
            'results_per_page' => 10,
        );
        $options = array_merge($defaults, $options);

        $offerQuery = new OfferQuery();

        $offerQuery->setPaging($options['page']);
        $offerQuery->setResultsCount($options['results_per_page']);

        return $client->callService($offerQuery);
    }

    /**
     * Update the quantity and the price an offer by its sku
     *
     * @param SimpleClient $client
     * @param array $options
     * @return ResponseService
     * @throws ErrorResponseException
     * @throws ExceptionInterface
     */
    public function updateOffer($client, $options)
    {
        $offer = new Offer();
        $offer->setOfferReferenceType(OfferReferenceType::SELLER_SKU);
        $offer->setOfferReference($options['offer_sku']);
        $offer->setQuantity($options['quantity']);
        $offer->setPrice($options['price']);
        $offer->setDescription($options['description']);

        $offerUpdate = new OfferUpdate();
        $offerUpdate->addOffer($offer);

        return $client->callService($offerUpdate);
    }

    /**
     * Delete an offer selected by its sku
     *
     * @param SimpleClient $client
     * @param string $sku
     * @return ResponseService
     * @throws ErrorResponseException
     * @throws ExceptionInterface
     */
    public function deleteOffer($client, $sku)
    {
        $offer = new Offer();
        $offer->setOfferReferenceType(OfferReferenceType::SELLER_SKU);
        $offer->setOfferReference($sku);
        $offer->setTreatment('delete');

        $offerUpdate = new OfferUpdate();
        $offerUpdate->addOffer($offer);

        return $client->callService($offerUpdate);
    }

}

