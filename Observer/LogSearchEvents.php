<?php

declare(strict_types=1);

namespace LFC\SkuLookUp\Observer;


use LFC\SkuLookUp\Api\Data\ProductSearchInterfaceFactory;
use LFC\SkuLookUp\Api\ProductSearchRepositoryInterface;
use LFC\SkuLookUp\Model\ProductSearch;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class LogSearchEvents implements ObserverInterface
{
    private ProductSearchRepositoryInterface $productSearchRepository;
    private ProductSearchInterfaceFactory $productSearchFactory;
    private LoggerInterface $logger;

    public function __construct(
        ProductSearchRepositoryInterface $productSearchRepository,
        ProductSearchInterfaceFactory $productSearchFactory,
        LoggerInterface $logger
    ) {
        $this->productSearchRepository = $productSearchRepository;
        $this->productSearchFactory = $productSearchFactory;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        try {
            $data = $observer->getData();
            /** @var ProductSearch $productSearch */
            $productSearch = $this->productSearchFactory->create();
            $productSearch->setSku($data['sku']);
            $productSearch->setResult($data['result']);
            $this->productSearchRepository->save($productSearch);
        } catch (LocalizedException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
