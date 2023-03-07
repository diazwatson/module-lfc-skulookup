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
use Magento\Framework\Event\ManagerInterface as EventManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

class Search implements HttpPostActionInterface
{
    private ResultFactory $resultFactory;
    private RequestInterface $request;
    private ProductRepositoryInterface $productRepository;
    private ManagerInterface $messageManager;
    private EventManagerInterface $eventManager;

    public function __construct(
        RequestInterface $request,
        ResultFactory $resultFactory,
        ProductRepositoryInterface $productRepository,
        ManagerInterface $messageManager,
        EventManagerInterface $eventManager
    ) {
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
        $this->eventManager = $eventManager;
    }

    /**
     * @return ResponseInterface|Redirect|(Redirect&ResultInterface)|ResultInterface
     */
    public function execute()
    {
        $searchDetails = [];
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $params = $this->request->getParams();

        try {
            $searchDetails['sku'] = $params['sku'];
            $product = $this->productRepository->get($params['sku']);

            if ((int)$product->getVisibility() !== Visibility::VISIBILITY_NOT_VISIBLE) {
                $redirect->setUrl($product->getProductUrl());
                $searchDetails['result'] = 'Success';
            } else {
                throw new LocalizedException(__('The requested product is not visible individually'));
            }
        } catch (NoSuchEntityException|LocalizedException $e) {
            $searchDetails['result'] = 'Error: ' . $e->getMessage();
            $this->messageManager->addNoticeMessage($e->getMessage());
            $redirect->setUrl('/lfcretail/m2test');
        }

        $this->eventManager->dispatch('sku_lookup_search_after', $searchDetails);

        return $redirect;
    }
}
