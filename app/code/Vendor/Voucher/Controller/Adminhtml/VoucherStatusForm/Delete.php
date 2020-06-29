<?php

namespace Vendor\Voucher\Controller\Adminhtml\VoucherStatusForm;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vendor\Voucher\Model\VoucherStatusFactory;
use Vendor\Voucher\Model\ResourceModel\VoucherStatus as VoucherResource;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $statusFactory;
    protected $voucherStatusResource;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        VoucherStatusFactory $statusFactory,
        VoucherResource $voucherStatusResource
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->statusFactory = $statusFactory;
        $this->voucherStatusResource = $voucherStatusResource;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $voucher = $this->statusFactory->create()->setEntityId($id);


        try {
            $this->voucherStatusResource->delete($voucher);
            $this->messageManager->addSuccess(__('Voucher Status has been deleted !'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete voucher status'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
