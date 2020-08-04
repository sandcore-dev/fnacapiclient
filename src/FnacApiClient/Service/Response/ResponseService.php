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
    final public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = array())
    {
        throw new BadMethodCallException("Can't normalize a Response Service");
    }

    public function denormalize(DenormalizerInterface $denormalizer, $data, string $format = null, array $context = array())
    {
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
