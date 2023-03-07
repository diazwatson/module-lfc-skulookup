<?php

declare(strict_types=1);

namespace LFC\SkuLookUp\Api\Data;

interface ProductSearchInterface
{
    const ID = 'id';
    const SKU = 'sku';
    const RESULT = 'result';
    const CREATED_AT = 'created_at';

    /**
     * Get id
     * @return string|null
     */
    public function getId();

    /**
     * Set id
     * @param string $id
     * @return \LFC\SkuLookUp\ProductSearch\Api\Data\ProductSearchInterface
     */
    public function setId($id);

    /**
     * Get SKU
     * @return string|null
     */
    public function getSku();

    /**
     * Set SKU
     * @param string $sku
     * @return \LFC\SkuLookUp\ProductSearch\Api\Data\ProductSearchInterface
     */
    public function setSku($sku);


    /**
     * Get id
     * @return string|null
     */
    public function getResult();

    /**
     * Set result
     * @param string $result
     * @return \LFC\SkuLookUp\ProductSearch\Api\Data\ProductSearchInterface
     */
    public function setResult($result);

    /**
     * Get Created At
     * @return string|null
     */
    public function getCreatedAt();
}

