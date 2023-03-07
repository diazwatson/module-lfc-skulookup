<?php

declare(strict_types=1);

namespace LFC\SkuLookUp\Api\Data;

interface ProductSearchSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get ProductSearch list.
     * @return \LFC\SkuLookUp\Api\Data\ProductSearchInterface[]
     */
    public function getItems(): array;

    /**
     * Set id list.
     * @param \LFC\SkuLookUp\Api\Data\ProductSearchInterface[] $items
     * @return $this
     */
    public function setItems(array $items): ProductSearchSearchResultsInterface;
}

