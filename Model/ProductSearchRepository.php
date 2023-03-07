<?php

declare(strict_types=1);

namespace LFC\SkuLookUp\Model;

use Exception;
use LFC\SkuLookUp\Api\Data\ProductSearchInterface;
use LFC\SkuLookUp\Api\Data\ProductSearchInterfaceFactory;
use LFC\SkuLookUp\Api\Data\ProductSearchSearchResultsInterfaceFactory;
use LFC\SkuLookUp\Api\ProductSearchRepositoryInterface;
use LFC\SkuLookUp\Model\ResourceModel\ProductSearch as ResourceProductSearch;
use LFC\SkuLookUp\Model\ResourceModel\ProductSearch\CollectionFactory as ProductSearchCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductSearchRepository implements ProductSearchRepositoryInterface
{
    /**
     * @var ResourceProductSearch
     */
    protected $resource;

    /**
     * @var ProductSearchInterfaceFactory
     */
    protected $productSearchFactory;

    /**
     * @var ProductSearchCollectionFactory
     */
    protected $productSearchCollectionFactory;

    /**
     * @var ProductSearch
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @param ResourceProductSearch                      $resource
     * @param ProductSearchInterfaceFactory              $productSearchFactory
     * @param ProductSearchCollectionFactory             $productSearchCollectionFactory
     * @param ProductSearchSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface               $collectionProcessor
     */
    public function __construct(
        ResourceProductSearch $resource,
        ProductSearchInterfaceFactory $productSearchFactory,
        ProductSearchCollectionFactory $productSearchCollectionFactory,
        ProductSearchSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->productSearchFactory = $productSearchFactory;
        $this->productSearchCollectionFactory = $productSearchCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(ProductSearchInterface $productSearch): ProductSearchInterface
    {
        try {
            $this->resource->save($productSearch);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the search: %1',
                $exception->getMessage()
            ));
        }
        return $productSearch;
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        $productSearch = $this->productSearchFactory->create();
        $this->resource->load($productSearch, $id);
        if (!$productSearch->getId()) {
            throw new NoSuchEntityException(__('Search with id "%1" does not exist.', $id));
        }
        return $productSearch;
    }

    /**
     * @inheritDoc
     */
    public function getBySKU($sku)
    {
        $productSearch = $this->productSearchFactory->create();
        $this->resource->load($productSearch, $sku, 'sku');
        if (!$productSearch->getId()) {
            throw new NoSuchEntityException(__('Search with SKU "%1" does not exist.', $sku));
        }
        return $productSearch;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->productSearchCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(ProductSearchInterface $productSearch): bool
    {
        try {
            $productSearchModel = $this->productSearchFactory->create();
            $this->resource->load($productSearchModel, $productSearch->getId());
            $this->resource->delete($productSearchModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the ProductSearch: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id): bool
    {
        return $this->delete($this->get($id));
    }
}
