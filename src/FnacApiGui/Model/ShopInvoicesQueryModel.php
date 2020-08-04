<?php
/***
 *
 * This file is part of the fnacMarketPlace API Client GUI.
 * (c) 2014 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * --------------------------
 * Fnac Api Gui : Shop Invoice Model
 *
 * @desc Class used to retrieve Shop Invoice query response
 * @author Somaninn Prok
 *
 */

namespace FnacApiGui\Model;

// Load required classes
use FnacApiClient\Client\SimpleClient;
use FnacApiClient\Exception\ErrorResponseException;
use FnacApiClient\Service\Request\ShopInvoiceQuery;
use FnacApiClient\Service\Response\ResponseService;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ShopInvoicesQueryModel extends Model
{
    public function __construct()
    {
        $this->template = __DIR__ . "/../templates/shop_invoices_query.tpl.php"; // Set default template
    }

    /**
     * Retrieves Shop Invoice query response
     *
     * @param SimpleClient $client
     * @param array $options
     * @return ResponseService
     * @throws ErrorResponseException
     * @throws ExceptionInterface
     */
    public function retrieveShopInvoicesResponse($client, $options = array())
    {
        $defaults = array(
            'page' => 1,
            'results_per_page' => 10,
        );
        $options = array_merge($defaults, $options);

        $shopInvoiceQuery = new ShopInvoiceQuery();

        $shopInvoiceQuery->setPaging($options['page']);
        $shopInvoiceQuery->setResultsCount($options['results_per_page']);

        return $client->callService($shopInvoiceQuery);
    }

}

