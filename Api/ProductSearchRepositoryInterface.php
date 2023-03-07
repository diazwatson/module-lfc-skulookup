<?php

declare(strict_types=1);

namespace LFC\SkuLookUp\Api;

interface ProductSearchRepositoryInterface
{
    /**
     * Save ProductSearch
     * @param \LFC\SkuLookUp\Api\Data\ProductSearchInterface $productSearch
     * @return \LFC\SkuLookUp\Api\Data\ProductSearchInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \LFC\SkuLookUp\Api\Data\ProductSearchInterface $productSearch
    );

    /**
     * Retrieve ProductSearch
     * @param string $id
     * @return \LFC\SkuLookUp\Api\Data\ProductSearchInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($id);

    /**
     * Retrieve ProductSearch By SKU
     * @param string $sku
     * @return \LFC\SkuLookUp\Api\Data\ProductSearchInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBySKU($sku);

    /**
     * Retrieve ProductSearch matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \LFC\SkuLookUp\Api\Data\ProductSearchSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete ProductSearch
     * @param \LFC\SkuLookUp\Api\Data\ProductSearchInterface $productSearch
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \LFC\SkuLookUp\Api\Data\ProductSearchInterface $productSearch
    );

    /**
     * Delete ProductSearch by ID
     * @param string $productsearchId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($productsearchId);
}
