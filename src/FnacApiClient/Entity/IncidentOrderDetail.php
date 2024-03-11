<?php
/*
 * This file is part of the fnacMarketPlace APi Client.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Entity;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * IncidentOrderDetail definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */
class IncidentOrderDetail extends Entity
{
    private $order_detail_id;
    private $refund_reason;

    /**
     * {@inheritDoc}
     */
    public function normalize(
        NormalizerInterface $normalizer,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|\ArrayObject|null {
        $data = array();
        $data['order_detail_id'] = $this->order_detail_id;
        $data['refund_reason'] = $this->refund_reason;

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, string $format = null, array $context = array())
    {
    }

    /**
     * @param string $order_detail_id : Unique OrderDetail identifier given by fnac
     */
    public function setOrderDetailId($order_detail_id)
    {
        $this->order_detail_id = $order_detail_id;
    }

    /**
     * Set action to do on message
     *
     * @see IncidentRefundReasonType
     *
     * @param string $refund_reason : refund reason to an order
     */
    public function setRefundReason($refund_reason)
    {
        $this->refund_reason = $refund_reason;
    }

}
