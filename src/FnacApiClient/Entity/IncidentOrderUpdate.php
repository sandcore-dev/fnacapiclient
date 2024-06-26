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
 * IncidentOrderUpdate definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */

class IncidentOrderUpdate extends Entity
{
    /** Get Var **/
    private $status;
    private $incident_id;
    private $incident_status;
    private $order_id;
    private $state;
    private $order_details;
    private $errors;

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
        $this->status = $data['status'];

        if (isset($data['incident_id'])) {
            $this->incident_id = $data['incident_id'];
        }

        if (isset($data['incident_status'])) {
            $this->incident_status = $data['incident_status'];
        }

        $this->order_id = $data['order_id'];

        if (isset($data['state'])) {
            $this->state = $data['state'];
        }

        $this->errors = new ArrayObject();

        if (isset($data['error'])) {
            if (isset($data['error'][0])) {
                foreach ($data['error'] as $error) {
                    $tmpObj = new Error();
                    $tmpObj->denormalize($denormalizer, $error, $format);
                    $this->errors[] = $tmpObj;
                }
            } else {
                $tmpObj = new Error();
                $tmpObj->denormalize($denormalizer, $data['error'], $format);
                $this->errors[] = $tmpObj;
            }
        }

        $this->order_details = new ArrayObject();

        if (isset($data['order_detail'])) {
            if (isset($data['order_detail'][0])) {
                foreach ($data['order_detail'] as $order_detail) {
                    $tmpObj = new IncidentOrderDetailUpdate();
                    $tmpObj->denormalize($denormalizer, $order_detail, $format);
                    $this->order_details[] = $tmpObj;
                }
            } else {
                $tmpObj = new IncidentOrderDetailUpdate();
                $tmpObj->denormalize($denormalizer, $data['order_detail'], $format);
                $this->order_details[] = $tmpObj;
            }
        }
    }

    /**
     * Order's unique identifier
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Incident's unique identifier
     *
     * @return string
     */
    public function getIncidentId()
    {
        return $this->incident_id;
    }

    /**
     * Incident's status
     *
     * @see StatusType
     * @return string
     */
    public function getIncidentStatus()
    {
        return $this->incident_status;
    }

    /**
     * Status of update
     *
     * @see ResponseStatusType
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Incident's State
     *
     * @see OrderStateType
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Errors that happens during update
     *
     * @see IncidentOrderDetailUpdate
     *
     * @return ArrayObject<IncidentOrderDetailUpdate>
     */
    public function getOrderDetails()
    {
        return $this->order_details;
    }

    /**
     * Errors that happens during update
     *
     * @see Error
     *
     * @return ArrayObject<Error>
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
