<?php

/*
 * This file is part of the fnacMarketPlace APi Client.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Request;

use FnacApiClient\Service\Response\BatchStatusResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * BatchStatus Service's definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */

class BatchStatus extends Authentified
{
    const ROOT_NAME = "batch_status";
    const XSD_FILE = "BatchStatusService.xsd";
    const CLASS_RESPONSE = BatchStatusResponse::class;

    private $batch_id;

    /**
     * {@inheritdoc}
     */
    public function normalize(
        NormalizerInterface $normalizer,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|\ArrayObject|null {
        return array_merge(parent::normalize($normalizer, $format), array(
            'batch_id' => $this->batch_id
        ));
    }

    /**
     * Set batch id
     *
     * @param integer $batch_id : The batch identifier to see
     */
    public function setBatchId($batch_id)
    {
        $this->batch_id = $batch_id;
    }
}
