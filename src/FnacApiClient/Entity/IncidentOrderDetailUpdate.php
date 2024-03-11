<?php

/*
 * This file is part of the fnacMarketPlace APi Client.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Entity;

use ArrayObject;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * OrderDetailIncident definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */
class IncidentOrderDetailUpdate extends Entity
{
    private $order_detail_id;
    private $status;
    private $state;
    private $errors;
    private $type;
    private $created_at;

    /**
     * {@inheritDoc}
     */
    public function normalize(
        NormalizerInterface $normalizer,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|\ArrayObject|null {
        return null;
    }

    /**
     * {@inheritDoc}
     * @noinspection PhpUnusedParameterInspection
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        $this->type = $data['order_detail_id'];
        $this->status = $data['status'];
        $this->created_at = isset($data['state']) ? $data['state'] : null;

        $this->errors = new ArrayObject();

        if (isset($data['error'][0])) {
            foreach ($data['error'] as $error) {
                $tmpObj = new Error();
                $tmpObj->denormalize($denormalizer, $error, $format);
                $this->errors[] = $tmpObj;
            }
        } elseif (!empty($data['error'])) {
            $tmpObj = new Error();
            $tmpObj->denormalize($denormalizer, $data['error'], $format);
            $this->errors[] = $tmpObj;
        }
    }

    /**
     * @return integer OrderDetail's unique identifier given by fnac
     */
    public function getOrderDetailId()
    {
        return $this->order_detail_id;
    }

    /**
     * @return string state of the orderDetail
     * @see  OrderDetailStateType
     *
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed Status of the OrderDetail reponse
     * @see  ResponseStatusType
     *
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @return array|ArrayObject<Error>
     * @see  \FnacApiClient\Entity\Error
     *
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
