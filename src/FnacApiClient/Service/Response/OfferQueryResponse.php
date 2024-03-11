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
use FnacApiClient\Entity\Offer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * OfferQueryResponse service base definition for offer query response
 *
 * @author     Fnac
 * @version    1.0.0
 */
class OfferQueryResponse extends QueryResponse
{
    private $offers = array();

    /**
     * {@inheritdoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, string $format = null, array $context = array())
    {
        parent::denormalize($denormalizer, $data, $format);

        $this->offers = new ArrayObject();
        if (isset($data['offer'])) {
            if (isset($data['offer'][0])) {
                foreach ($data['offer'] as $offer) {
                    $tmpObj = new Offer();
                    $tmpObj->denormalize($denormalizer, $offer, $format);
                    $this->offers[] = $tmpObj;
                }
            } else {
                $tmpObj = new Offer();
                $tmpObj->denormalize($denormalizer, $data['offer'], $format);
                $this->offers[] = $tmpObj;
            }
        }
    }

    /**
     * Offer list
     *
     * @see Offer
     *
     * @return array|ArrayObject<Offer>
     */
    public function getOffers()
    {
        return $this->offers;
    }
}
