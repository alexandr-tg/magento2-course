<?php

namespace Vendor\Voucher\Controller\Adminhtml\VoucherForm;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vendor\Voucher\Api\VoucherManagementInterface as VoucherManagement;
use Vendor\Voucher\Model\ResourceModel\Voucher as VoucherResource;
use Vendor\Voucher\Model\VoucherFactory;
use Magento\Framework\App\Response\RedirectInterface;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $voucher;
    protected $voucherResource;
    protected $voucherManagement;
    protected $redirect;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        VoucherFactory $voucher,
        VoucherManagement $voucherManagement,
        VoucherResource $voucherResource,
        RedirectInterface $redirect
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->voucher = $voucher;
        $this->voucherManagement = $voucherManagement;
        $this->voucherResource = $voucherResource;
        $this->redirect = $redirect;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $post = $this->getRequest()->getPostValue();

        if ($post) {
            if (empty($post['entity_id'])) {
                $customer_id = $post['customer_id'];
                $status_id = $post['status_id'];
                $voucher_code = $post['voucher_code'];
                $this->voucherManagement->createVoucher($customer_id, $status_id, $voucher_code);
                $this->messageManager->addSuccess('Successfully saved the item.');
            }

            if (isset($post['entity_id'])) {
                $voucher = $this->voucher->create();
                $this->voucherResource->load($voucher, $post['entity_id']);
                $voucher->addData($post);
                $voucher->setEntityId($post['entity_id']);
                $this->voucherResource->save($voucher);
                $this->messageManager->addSuccess('Item successfully edited');
            }

            return $resultRedirect->setPath($this->redirect->getRefererUrl());
        }
    }
}
