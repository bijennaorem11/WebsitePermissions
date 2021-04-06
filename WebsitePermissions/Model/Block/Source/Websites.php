<?php
namespace BoostMyShop\WebsitePermissions\Model\Block\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Store\Api\WebsiteRepositoryInterface;

/**
 * Class Websites
 * @package BoostMyShop\WebsitePermissions\Model\Source
 */
class Websites implements OptionSourceInterface
{
    const ADMIN = 'admin';

    /**
     * @var WebsiteRepositoryInterface
     */
    private $websiteRepository;

    /**
     * Websites constructor.
     * @param WebsiteRepositoryInterface $websiteRepository
     */
    public function __construct(WebsiteRepositoryInterface $websiteRepository)
    {
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->websiteRepository->getList();
        $options[] = [
            'label' => __('All'),
            'value' => null,
        ];
        foreach ($availableOptions as $key => $value) {
            if($value->getCode() == self::ADMIN){
                continue;
            }
            $options[] = [
                'label' => $value->getName(),
                'value' => $value->getId(),
            ];
        }
        return $options;
    }
}
