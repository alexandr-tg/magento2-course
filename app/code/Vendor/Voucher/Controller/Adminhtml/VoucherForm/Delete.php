<?php

namespace Vendor\Voucher\Controller\Adminhtml\VoucherForm;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vendor\Voucher\Model\VoucherFactory;
use Vendor\Voucher\Model\ResourceModel\Voucher as VoucherResource;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $voucher;
    protected $voucherResource;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        VoucherFactory $voucher,
        VoucherResource $voucherResource
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->voucher = $voucher;
        $this->voucherResource = $voucherResource;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $voucher = $this->voucher->create()->setEntityId($id);


        try {
            $this->voucherResource->delete($voucher);
            $this->messageManager->addSuccess(__('Voucher has been deleted !'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete voucher'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
