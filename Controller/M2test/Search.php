<?php

declare(strict_types=1);

namespace LFC\SkuLookUp\Controller\M2test;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

class Search implements HttpPostActionInterface
{
    private ResultFactory $resultFactory;
    private RequestInterface $request;
    private ProductRepositoryInterface $productRepository;
    private ManagerInterface $messageManager;
    private \LFC\SkuLookUp\Api\ProductSearchRepositoryInterface $productSearchRepository;
    private \LFC\SkuLookUp\Api\Data\ProductSearchInterfaceFactory $productSearchFactory;

    public function __construct(
        RequestInterface $request,
        ResultFactory $resultFactory,
        ProductRepositoryInterface $productRepository,
        ManagerInterface $messageManager,
        \LFC\SkuLookUp\Api\ProductSearchRepositoryInterface $productSearchRepository,
        \LFC\SkuLookUp\Api\Data\ProductSearchInterfaceFactory $productSearchFactory
    ) {
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
        $this->productSearchRepository = $productSearchRepository;
        $this->productSearchFactory = $productSearchFactory;
    }

    /**
     * @return ResponseInterface|Redirect|(Redirect&ResultInterface)|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        /** @var \LFC\SkuLookUp\Model\ProductSearch $productSearch */
        $productSearch = $this->productSearchFactory->create();

        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $params = $this->request->getParams();

        try {
            $productSearch->setSku($params['sku']);
            $product = $this->productRepository->get($params['sku']);

            if ((int)$product->getVisibility() !== Visibility::VISIBILITY_NOT_VISIBLE) {
                $redirect->setUrl($product->getProductUrl());
                $productSearch->setResult('Success');
            } else {
                throw new LocalizedException(__('The requested product is not visible individually'));
            }
        } catch (NoSuchEntityException|LocalizedException $e) {
            $productSearch->setResult('Error: ' . $e->getMessage());
            $this->messageManager->addNoticeMessage($e->getMessage());
            $redirect->setUrl('/lfcretail/m2test');
        }

        $this->productSearchRepository->save($productSearch);

        return $redirect;
    }
}
