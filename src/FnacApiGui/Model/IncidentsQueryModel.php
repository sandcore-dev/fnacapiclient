<?php
/***
 *
 * This file is part of the fnacMarketPlace API Client GUI.
 * (c) 2013 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * --------------------------
 * Fnac Api Gui : Incident Model
 *
 * @desc Class used to retrieve Incident query response
 * @author Armelle Lutz
 *
 */

namespace FnacApiGui\Model;

use FnacApiClient\Client\SimpleClient;
use FnacApiClient\Exception\ErrorResponseException;
use FnacApiClient\Service\Request\IncidentQuery;
use FnacApiClient\Service\Response\ResponseService;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class IncidentsQueryModel extends Model
{
    public function __construct()
    {
        $this->template = __DIR__ . "/../templates/incidents_query.tpl.php"; // Set default template
    }

    /**
     * Retrieves Incident query response
     *
     * @param SimpleClient $client
     * @param array $options
     * @return ResponseService
     * @throws ErrorResponseException
     * @throws ExceptionInterface
     */
    public function retrieveIncidentsResponse($client, $options = array())
    {
        $defaults = array(
            'status' => null,
            'sort_by' => 'DESC'
        );
        $options = array_merge($defaults, $options);

        $incidentQuery = new IncidentQuery();
        $incidentQuery->setSortBy($options['sort_by']);
        if (isset($status)) {
            $incidentQuery->setStatus($status);
        }

        return $client->callService($incidentQuery);
    }

}

