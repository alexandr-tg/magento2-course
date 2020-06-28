<?php

namespace Vendor\Voucher\Block\Adminhtml\VoucherStatus\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class BackButton extends GenericButton implements ButtonProviderInterface
{
    protected $redirect;

    public function __construct(
        Context $context,
        Registry $registry,
        RedirectInterface $redirect
    ) {
        $this->redirect = $redirect;
        parent::__construct($context, $registry);
    }

    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    public function getBackUrl()
    {
        return $this->redirect->getRefererUrl();
    }
}
