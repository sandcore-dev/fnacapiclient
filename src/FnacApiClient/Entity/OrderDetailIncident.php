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
class OrderDetailIncident extends Entity
{
    private $type;
    private $status;
    private $created_at;
    private $updated_at;

    private $refunds = array();

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
        $this->type = $data['type'];
        $this->status = $data['status'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];

        $this->refunds = new ArrayObject();

        if (isset($data['refunds']['refund'][0])) {
            foreach ($data['refunds']['refund'] as $refund) {
                $tmpObj = new Refund();
                $tmpObj->denormalize($denormalizer, $refund, $format);
                $this->refunds[] = $tmpObj;
            }
        } elseif (!empty($data['refunds']['refund'])) {
            $tmpObj = new Refund();
            $tmpObj->denormalize($denormalizer, $data['refunds']['refund'], $format);
            $this->refunds[] = $tmpObj;
        }
    }

    /**
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return array|ArrayObject<Refund>
     */
    public function getRefunds()
    {
        return $this->refunds;
    }
}
