<?php

namespace Vendor\Voucher\Controller\Adminhtml\VoucherForm;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vendor\Voucher\Api\VoucherManagementInterface as VoucherManagement;
use Vendor\Voucher\Model\VoucherFactory;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $voucherFactory;
    protected $voucherManagement;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        VoucherFactory $voucherFactory,
        VoucherManagement $voucherManagement
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->voucherFactory = $voucherFactory;
        $this->voucherManagement = $voucherManagement;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $contact = $this->voucherFactory->create()->load($data['entity_id']);

                $data = array_filter($data, function ($value) {
                    return $value !== '';
                });

                $this->voucherManagement->createVoucher($data['customer_id'], $data['status_id'], $data['voucher_code']);

                $this->messageManager->addSuccess(__('Successfully saved the item.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $contact->getId()]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
