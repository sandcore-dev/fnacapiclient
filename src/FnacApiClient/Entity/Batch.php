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
 * Represent a batch
 *
 * @author     Fnac
 * @version    1.0.0
 */

class Batch extends Entity
{
    private $status;
    private $nb_lines;
    private $batch_id;
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
        $this->status = $data['@status'];
        $this->batch_id = $data['batch_id'];
        $this->nb_lines = (int) $data['nb_lines'];
        $this->created_at = $data['created_at'];
    }

    /**
     * Get the batch status
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
     * Batch unique identifier from fnac
     *
     * @return string
     */
    public function getBatchId()
    {
        return $this->batch_id;
    }

    /**
     * Number of lines to update
     *
     * @return integer
     */
    public function getNbLines()
    {
        return $this->nb_lines;
    }

    /**
     * Creation date of batch
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
