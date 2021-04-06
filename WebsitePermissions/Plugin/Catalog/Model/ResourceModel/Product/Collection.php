<?php
namespace BoostMyShop\WebsitePermissions\Plugin\Catalog\Model\ResourceModel\Product;

use Magento\Backend\Model\Auth\Session;
use BoostMyShop\WebsitePermissions\Model\Block\Source\Websites;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
class Collection
{
    protected $authSession;

    /**
     * Collection constructor.
     * @param Session $authSession
     */
    public function __construct(
        Session $authSession
    ) {
        $this->authSession = $authSession;
    }

    /**
     * @param ProductCollection $subject
     * @param bool $printQuery
     * @param bool $logQuery
     * @return array
     */
    public function beforeLoad(ProductCollection $subject, $printQuery = false, $logQuery = false)
    {
        $adminLoginUser = $this->authSession->getUser();
        if (!$subject->isLoaded() && $adminLoginUser->getData('website_id')!= null
            && $adminLoginUser->getData('getCode') != Websites::ADMIN) {
            $subject->addWebsiteFilter($adminLoginUser->getData('website_id'));
        }
        return [$printQuery, $logQuery];
    }
}
