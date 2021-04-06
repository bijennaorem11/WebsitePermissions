<?php

namespace BoostMyShop\WebsitePermissions\Plugin\Controller\Adminhtml\Product;

use Magento\Catalog\Controller\Adminhtml\Product\Edit as ProductEdit;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Model\ResourceModel\Product as ResourceModelProduct;
use BoostMyShop\WebsitePermissions\Model\Block\Source\Websites;

class Edit
{
    protected $authSession;
    /**
     * @var Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;
    /**
     * @var RedirectFactory
     */
    private $redirectFactory;
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var ResourceModelProduct
     */
    private $product;

    /**
     * Edit constructor.
     * @param Session $authSession
     * @param ManagerInterface $messageManager
     * @param RedirectFactory $redirectFactory
     * @param RequestInterface $request
     * @param ResourceModelProduct $product
     */
    public function __construct(
        Session $authSession,
        ManagerInterface $messageManager,
        RedirectFactory $redirectFactory,
        RequestInterface $request,
        ResourceModelProduct $product
    ) {
        $this->authSession = $authSession;
        $this->messageManager = $messageManager;
        $this->redirectFactory = $redirectFactory;
        $this->request = $request;
        $this->product = $product;
    }

    public function afterExecute(ProductEdit $subject, $result)
    {
        $adminLoginUser = $this->authSession->getUser();
        $productId = $this->request->getParam('id');
        $productWebsites = $this->product->getWebsiteIdsByProductIds($productId);
        if(is_array($productWebsites)
            && $adminLoginUser->getData('website_id')!= null
            && $adminLoginUser->getData('getCode') != Websites::ADMIN
        ){
            if(!in_array($adminLoginUser->getData('website_id'), $productWebsites[$productId])){
                $this->messageManager->addErrorMessage(__("User doesn't have premission to view this product."));
                $resultRedirect = $this->redirectFactory->create();
                return $resultRedirect->setPath('catalog/*/');
            }
        }
        return $result;
    }
}
