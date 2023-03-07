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

    public function __construct(
        RequestInterface $request,
        ResultFactory $resultFactory,
        ProductRepositoryInterface $productRepository,
        ManagerInterface $messageManager
    ) {
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
    }

    /**
     * @return ResponseInterface|Redirect|(Redirect&ResultInterface)|ResultInterface
     */
    public function execute()
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $params = $this->request->getParams();
        try {
            $product = $this->productRepository->get($params['sku']);
            if ((int)$product->getVisibility() !== Visibility::VISIBILITY_NOT_VISIBLE) {
                $redirect->setUrl($product->getProductUrl());
            } else {
                throw new LocalizedException(__('The requested product is not visible individually'));
            }
        } catch (NoSuchEntityException|LocalizedException $e) {
            $this->messageManager->addNoticeMessage($e->getMessage());
            $redirect->setUrl('/lfcretail/m2test');
        }

        return $redirect;
    }
}
