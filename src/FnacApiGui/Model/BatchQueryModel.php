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
 * Fnac Api Gui : Batch Model
 *
 * @desc Class used to retrieve Batch query response
 * @author Somaninn Prok <sprok@fnac.com>
 *
 */

namespace FnacApiGui\Model;

use FnacApiClient\Client\SimpleClient;
use FnacApiClient\Exception\ErrorResponseException;
use FnacApiClient\Service\Request\BatchQuery;
use FnacApiClient\Service\Request\BatchStatus;
use FnacApiClient\Service\Response\ResponseService;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class BatchQueryModel extends Model
{

    public function __construct()
    {
        $this->template = __DIR__ . "/../templates/batch_query.tpl.php"; // Set default template
    }

    /**
     * Retrieves Batch query response
     *
     * @param SimpleClient $client
     * @return ResponseService
     */
    public function retrieveBatchResponse($client)
    {
        $batchQuery = new BatchQuery();

        return $client->callService($batchQuery);
    }

    /**
     * Retrieves Batch query response for recent batches
     *
     * @param SimpleClient $client
     * @param int $delay : nb days to retrieve
     * @return ResponseService
     * @throws ErrorResponseException
     * @throws ExceptionInterface
     */
    public function retrieveRecentBatchResponse($client, $delay)
    {
        $batchQuery = new BatchQuery();

        $date = date_create();
        $max_date = date_format($date, "Y-m-d\TH:i:s+02:00");
        $min_date = date_sub($date, date_interval_create_from_date_string("$delay days"));
        $min_date = date_format($min_date, "Y-m-d\TH:i:s+02:00");
        $batchQuery->setDate(array('type' => 'Created', 'min' => $min_date, 'max' => $max_date));

        return $client->callService($batchQuery);
    }

    /**
     * Retrieves Batch status response
     *
     * @param SimpleClient $client
     * @param string $batch_id
     * @return ResponseService
     * @throws ErrorResponseException
     * @throws ExceptionInterface
     */
    public function retrieveBatchStatus($client, $batch_id)
    {
        $batchStatusQuery = new BatchStatus();
        $batchStatusQuery->setBatchId($batch_id);

        return $client->callService($batchStatusQuery);
    }
}

