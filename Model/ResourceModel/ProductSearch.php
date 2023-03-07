<?php

declare(strict_types=1);

namespace LFC\SkuLookUp\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductSearch extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('lfc_skulookup_productsearch', 'id');
    }
}
