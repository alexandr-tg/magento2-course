<?php

namespace Vendor\Voucher\Controller\Adminhtml\Voucher;

use Magento\Backend\App\Action;

class Index extends Action
{
    private $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
