<?php

declare(strict_types=1);

namespace LFC\SkuLookUp\Model;

use LFC\SkuLookUp\Api\Data\ProductSearchInterface;
use Magento\Framework\Model\AbstractModel;

class ProductSearch extends AbstractModel implements ProductSearchInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\LFC\SkuLookUp\Model\ResourceModel\ProductSearch::class);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    /**
     * @inheritDoc
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * @inheritDoc
     */
    public function getResult()
    {
        return $this->getData(self::RESULT);
    }

    /**
     * @inheritDoc
     */
    public function setResult($result)
    {
        return $this->setData(self::RESULT, $result);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }
}
