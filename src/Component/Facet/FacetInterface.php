<?php

namespace Solarium\Component\Facet;

/**
 * Facet base class.
 *
 * @see http://wiki.apache.org/solr/SimpleFacetParameters
 */
interface FacetInterface
{
    /**
     * Must be implemented by the facet types and return one of the constants.
     *
     * @abstract
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Get key.
     *
     * @return string|null
     */
    public function getKey(): ?string;

    /**
     * Set key.
     *
     * @param string $key
     *
     * @return FacetInterface
     */
    public function setKey(string $key): FacetInterface;
}
