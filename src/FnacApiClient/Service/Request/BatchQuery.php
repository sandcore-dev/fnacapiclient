<?php

/*
 * This file is part of the fnacMarketPlace APi Client.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Request;

use FnacApiClient\Service\Response\BatchQueryResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * BatchQuery Service's definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */

class BatchQuery extends Query
{
    const ROOT_NAME = "batch_query";
    const XSD_FILE = "BatchQueryService.xsd";
    const CLASS_RESPONSE = BatchQueryResponse::class;

    /**
     * {@inheritdoc}
     */
    public function normalize(
        NormalizerInterface $normalizer,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|\ArrayObject|null {
        return parent::normalize($normalizer, $format);
    }
}
