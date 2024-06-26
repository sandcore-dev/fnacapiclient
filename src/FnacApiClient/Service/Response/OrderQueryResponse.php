<?php

/*
 * This file is part of the fnacApi.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Response;

use ArrayObject;
use FnacApiClient\Entity\Order;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * OrderQueryResponse service base definition for order query response
 *
 * @author     Fnac
 * @version    1.0.0
 */
class OrderQueryResponse extends QueryResponse
{
    private $orders = array();

    /**
     * {@inheritdoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, string $format = null, array $context = array())
    {
        parent::denormalize($denormalizer, $data, $format);

        $this->orders = new ArrayObject();

        if (isset($data['order'])) {
            if (isset($data['order'][0])) {
                foreach ($data['order'] as $order) {
                    $tmpObj = new Order();
                    $tmpObj->denormalize($denormalizer, $order, $format);
                    $this->orders[] = $tmpObj;
                }
            } else {
                $tmpObj = new Order();
                $tmpObj->denormalize($denormalizer, $data['order'], $format);
                $this->orders[] = $tmpObj;
            }
        }
    }

    /**
     * Order list
     *
     * @see Order
     *
     * @return array|ArrayObject<Order>
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
