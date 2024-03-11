<?php
/*
 * This file is part of the fnacApi.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Response;

use BadMethodCallException;
use FnacApiClient\Service\AbstractService;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * ResponseService service base definition for response.
 *
 * @author     Fnac
 * @version    1.0.0
 */
abstract class ResponseService extends AbstractService
{
    private $status = null;

    /**
     * {@inheritdoc}
     */
    public function normalize(
        NormalizerInterface $normalizer,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|\ArrayObject|null {
        throw new BadMethodCallException("Can't normalize a Response Service");
    }

    public function denormalize(
        DenormalizerInterface $denormalizer,
        float|array|bool|int|string $data,
        ?string $format = null,
        array $context = []
    ) {
        $this->status = $data['@status'];
    }

    /**
     * Return the status of response
     *
     * @see ResponseStatusType
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
