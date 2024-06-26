<?php

/*
 * This file is part of the fnacMarketPlace APi Client.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Request;

use ArrayObject;
use FnacApiClient\Service\Response\OrderQueryResponse;
use FnacApiClient\Type\ProductStateType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * OrderQuery Service's definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */
class OrderQuery extends Query
{
    const ROOT_NAME = "orders_query";
    const XSD_FILE = "OrdersQueryService.xsd";
    const CLASS_RESPONSE = OrderQueryResponse::class;

    private $sort_by_type = null;
    private $product_fnac_id = null;
    private $orders_fnac_id = null;
    private $states = null;
    private $offer_fnac_id = null;
    private $offer_seller_id = null;


    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct(array $orderQueryParameters = null)
    {
        if (!empty($orderQueryParameters)) {
            $this->initParameters($orderQueryParameters);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(
        NormalizerInterface $normalizer,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|\ArrayObject|null {
        $data = parent::normalize($normalizer, $format);

        if (!is_null($this->sort_by_type)) {
            $data['sort_by'] = $this->sort_by_type;
        }

        if (!is_null($this->product_fnac_id)) {
            $data['product_fnac_id'] = $this->product_fnac_id;
        }

        if (!is_null($this->orders_fnac_id)) {
            $data['orders_fnac_id'] = array();
            $data['orders_fnac_id']['order_fnac_id'] = array();
            foreach ($this->orders_fnac_id as $order_fnac_id) {
                $data['orders_fnac_id']['order_fnac_id'][] = $order_fnac_id;
            }
        }

        if (!is_null($this->states)) {
            $data['states'] = array();
            $data['states']['state'] = array();
            foreach ($this->states as $state) {
                $data['states']['state'][] = $state;
            }
        }

        if (!is_null($this->offer_fnac_id)) {
            $data['offer_fnac_id'] = $this->offer_fnac_id;
        }

        if (!is_null($this->offer_seller_id)) {
            $data['offer_seller_id'] = $this->offer_seller_id;
        }

        return $data;
    }

    /**
     * Set order to sort
     *
     * @see SortOrderType
     *
     * @param string $sort_by_type : Order to sort
     */
    public function setSortByType($sort_by_type)
    {
        $this->sort_by_type = $sort_by_type;
    }

    /**
     * Set product unique identifier from fnac
     *
     * @param string $product_fnac_id : Product fnac id
     */
    public function setProductFnacId($product_fnac_id)
    {
        $this->product_fnac_id = $product_fnac_id;
    }

    /**
     * Set orders unique identifier from fnac
     *
     * @param array $orders_fnac_id : Lits of id to fetch
     */
    public function setOrdersFnacId($orders_fnac_id)
    {
        $this->orders_fnac_id = $orders_fnac_id;
    }

    /**
     * Set orders states
     *
     * @see ProductStateType
     *
     * @param ArrayObject<ProductStateType> $states : Offer states
     */
    public function setStates($states)
    {
        $this->states = $states;
    }

    /**
     * Set offer unique identifier from fnac
     *
     * @param string $offer_fnac_id : Offer fnac uid
     */
    public function setOfferFnacId($offer_fnac_id)
    {
        $this->offer_fnac_id = $offer_fnac_id;
    }

    /**
     * Set offer unique identifier from seller
     *
     * @param string $offer_seller_id : Offer seller uid
     */
    public function setOfferSellerId($offer_seller_id)
    {
        $this->offer_seller_id = $offer_seller_id;
    }
}
