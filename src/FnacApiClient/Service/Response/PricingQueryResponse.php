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
use FnacApiClient\Entity\PricingProduct;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * PricingQueryResponse service base definition for response when using message query.
 *
 * @author     Fnac
 * @version    1.0.0
 */
class PricingQueryResponse extends ResponseService
{
    private $pricing_products;

    /**
     * {@inheritdoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, string $format = null, array $context = array())
    {
        parent::denormalize($denormalizer, $data, $format);

        $this->pricing_products = new ArrayObject();

        if (isset($data['pricing_product'])) {
            if (isset($data['pricing_product'][0])) {
                foreach ($data['pricing_product'] as $pricing_product) {
                    $tmpObj = new PricingProduct();
                    $tmpObj->denormalize($denormalizer, $pricing_product, $format);
                    $this->pricing_products[] = $tmpObj;
                }
            } elseif (!empty($data['pricing_product'])) {
                $tmpObj = new PricingProduct();
                $tmpObj->denormalize($denormalizer, $data['pricing_product'], $format);
                $this->pricing_products[] = $tmpObj;
            }
        }
    }

    /**
     * Pricing product list
     *
     * @see PricingProduct
     *
     * @return array|ArrayObject<PricingProduct>
     */
    public function getPricingProducts()
    {
        return $this->pricing_products;
    }
}
