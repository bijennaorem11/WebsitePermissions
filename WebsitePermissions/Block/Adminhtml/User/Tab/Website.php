<?php

namespace BoostMyShop\WebsitePermissions\Block\Adminhtml\User\Tab;
use BoostMyShop\WebsitePermissions\Model\Block\Source\Websites;

class Website extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Magento\Config\Model\Config\Source\Yesno
     */
    private $optionList;

    /**
     * @var \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory
     */
    private $fieldFactory;
    /**
     * @var Websites
     */
    private $websites;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Config\Model\Config\Source\Yesno $optionList,
        \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory $fieldFactory,
        Websites $websites,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->optionList = $optionList;
        $this->fieldFactory = $fieldFactory;
        $this->websites = $websites;
        parent::__construct($context, $registry, $formFactory, $data);

    }

    /**
     * Get tab label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Website Permission');
    }

    /**
     * Get tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Whether tab is available
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Whether tab is visible
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }


    /**
     * @return \Magento\Backend\Block\Widget\Form\Generic
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function _beforeToHtml()
    {
        $this->_initForm();
        return parent::_beforeToHtml();
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _initForm()
    {
        /** @var $model \Magento\User\Model\User */
        $model = $this->_coreRegistry->registry('permissions_user');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset('website_fieldset', ['legend' => __('User Website Information')]);
        if ($model->getUserId()) {
            $fieldset->addField('user_id', 'hidden', ['name' => 'user_id']);
        } else {
            if (!$model->hasData('is_active')) {
                $model->setIsActive(1);
            }
        }

        $fieldset->addField(
            'website_id',
            'select',
            [
                'name' => 'website_id',
                'label' => __('Select Website'),
                'title' => __('Select Website'),
                'values' => $this->websites->toOptionArray(),
                'class' => 'select'
            ]
        );

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);
    }
}
