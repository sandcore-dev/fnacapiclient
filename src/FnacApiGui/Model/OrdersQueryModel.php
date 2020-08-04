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
 * Fnac Api Gui : Orders query Model
 *
 * @desc Class used to retrieve Orders query response
 * @author Somaninn Prok <sprok@fnac.com>
 *
 */

namespace FnacApiGui\Model;

use FnacApiClient\Client\SimpleClient;
use FnacApiClient\Entity\Order;

use FnacApiClient\Exception\ErrorResponseException;
use FnacApiClient\Service\Request\OrderQuery;
use FnacApiClient\Service\Request\OrderUpdate;
use FnacApiClient\Entity\OrderDetail;
use FnacApiClient\Service\Response\ResponseService;
use FnacApiClient\Type\OrderDetailActionType;
use FnacApiClient\Type\OrderActionType;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class OrdersQueryModel extends Model
{
    public function __construct()
    {
        $this->template = __DIR__ . "/../templates/orders_query.tpl.php";
    }

    /**
     * Retrieves Orders query response
     *
     * @param SimpleClient $client
     * @param array $options Request parameters
     * @return ResponseService
     * @throws ErrorResponseException
     * @throws ExceptionInterface
     */
    public function retrieveOrdersResponse($client, $options = array())
    {
        $defaults = array(
            'page' => 1,
            'results_per_page' => 10,
            'states' => null,
            'sort_by_type' => 'DESC',
            'date_type' => 'CreatedAt'
        );
        $options = array_merge($defaults, $options);

        $orderQuery = new OrderQuery();

        $orderQuery->setPaging($options['page']);
        $orderQuery->setResultsCount($options['results_per_page']);
        if (isset($states)) {
            $orderQuery->setStates($states);
        }

        return $client->callService($orderQuery);
    }

    /**
     * Update an order with a given action
     *
     * CAUTION : This method updates all the orders details of an order by using "mass actions" (accept_all_orders, confirm_all_to_send).
     *
     * @param SimpleClient $client
     * @param string $action
     * @param string $order_id
     * @return ResponseService
     * @throws ErrorResponseException
     * @throws ExceptionInterface
     */
    public function updateOrder($client, $action, $order_id)
    {

        $order = new Order();
        $order->setOrderId($order_id);
        $order->setOrderAction(OrderActionType::ACCEPT_ALL_ORDERS);

        $orderDetail = new OrderDetail();

        if ($action == 'accept') {
            $orderDetail->setAction(OrderDetailActionType::ACCEPTED);
        } elseif ($action == 'refuse') {
            $orderDetail->setAction(OrderDetailActionType::REFUSED);
        } elseif ($action == 'ship') {
            $order->setOrderAction(OrderActionType::CONFIRM_ALL_TO_SEND);
            $orderDetail->setAction(OrderDetailActionType::SHIPPED);
        }

        $order->addOrderDetail($orderDetail);

        $orderUpdateService = new OrderUpdate();
        $orderUpdateService->addOrder($order);

        return $client->callService($orderUpdateService);
    }

}

