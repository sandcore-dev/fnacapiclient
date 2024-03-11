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
 * ProductReference definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */

class ProductReference extends Entity
{
    private $type;
    private $value;

    /**
     * {@inheritDoc}
     */
    public function normalize(
        NormalizerInterface $normalizer,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|\ArrayObject|null {
        return array(
            '@type' => $this->type, '#' => $this->value
        );
    }

    /**
     * {@inheritDoc}
     * @noinspection PhpUnusedParameterInspection
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        $this->type = $data['@type'];
        $this->value = $data['#'];
    }

    /**
     * Set product reference type
     *
     * @see ProductType
     *
     * @param string $type : Type of reference
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Set product reference value
     *
     * @param string $value : Value of reference
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get product reference type
     *
     * @see ProductType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get product reference value
     */
    public function getValue()
    {
        return $this->value;
    }
}
