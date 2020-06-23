<?php

namespace Vendor\Voucher\Controller\Voucher;

use Magento\Customer\Model\SessionFactory as Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Vendor\Voucher\Api\VoucherManagementInterface as VoucherManagement;
use Vendor\Voucher\Model\ResourceModel\Voucher as VoucherResource;
use Vendor\Voucher\Model\VoucherFactory as Voucher;

class Create extends Action
{
    /**
     * @var VoucherManagement
     */
    private $voucherManagement;

    /**
     * @var VoucherResource
     */
    private $voucherResource;

    /**
     * @var Voucher
     */
    private $voucher;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * Create constructor.
     * @param Context $context
     * @param VoucherManagement $voucherManagement
     * @param VoucherResource $voucherResource
     * @param Voucher $voucher
     * @param Session $session
     * @param Validator $validator
     */
    public function __construct(
        Context $context,
        VoucherManagement $voucherManagement,
        VoucherResource $voucherResource,
        Voucher $voucher,
        Session $session,
        Validator $validator
    ) {
        parent::__construct($context);
        $this->voucherManagement = $voucherManagement;
        $this->voucherResource = $voucherResource;
        $this->voucher = $voucher;
        $this->session = $session;
        $this->validator = $validator;
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        if ($this->validator->validate($this->getRequest()) && $this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPostValue();

            if (!isset($post['entity_id'])) {
                $customer_id = $this->session->create()->getCustomerId();
                $status_id = $post['status_id'];
                $voucher_code = $post['voucher_code'];
                $this->voucherManagement->createVoucher($customer_id, $status_id, $voucher_code);
                $this->messageManager->addSuccessMessage('Voucher Status successfully created');
            }

            if (isset($post['entity_id'])) {
                $voucher = $this->voucher->create();
                $this->voucherResource->load($voucher, $post['entity_id']);
                $voucher->addData($post);
                $voucher->setEntityId($post['entity_id']);
                $this->voucherResource->save($voucher);
                $this->messageManager->addSuccessMessage('Voucher Status successfully updated');
            }

            $this->_redirect('vouchers/voucher/index');
        }
    }
}
