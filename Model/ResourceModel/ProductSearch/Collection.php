<?php

declare(strict_types=1);

namespace LFC\SkuLookUp\Model\ResourceModel\ProductSearch;

use LFC\SkuLookUp\Model\ProductSearch;
use LFC\SkuLookUp\Model\ResourceModel\ProductSearch as ProductSearchResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            ProductSearch::class,
            ProductSearchResource::class
        );
    }
}
