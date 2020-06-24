<?php

namespace Vendor\Voucher\Controller\VoucherStatus;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Vendor\Voucher\Api\VoucherManagementInterface as VoucherManagement;
use Vendor\Voucher\Model\ResourceModel\VoucherStatus as VoucherStatusResource;
use Vendor\Voucher\Model\VoucherStatusFactory as VoucherStatus;

class Create extends \Magento\Framework\App\Action\Action
{
    /**
     * @var VoucherManagement
     */
    private $voucherManagement;

    /**
     * @var VoucherStatus
     */
    private $voucherStatus;

    /**
     * @var VoucherStatusResource
     */
    private $voucherStatusResource;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * Create constructor.
     * @param Context $context
     * @param VoucherManagement $voucherManagement
     * @param VoucherStatus $voucherStatus
     * @param VoucherStatusResource $voucherStatusResource
     * @param Validator $validator
     */
    public function __construct(
        Context $context,
        VoucherManagement $voucherManagement,
        VoucherStatus $voucherStatus,
        VoucherStatusResource $voucherStatusResource,
        Validator $validator
    ) {
        parent::__construct($context);
        $this->voucherManagement = $voucherManagement;
        $this->voucherStatus = $voucherStatus;
        $this->voucherStatusResource = $voucherStatusResource;
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

            if (!empty($post)) {
                $status = $this->voucherStatus->create();

                if (!isset($post['entity_id'])) {
                    $this->voucherManagement->createVoucherStatus($post['status_code']);
                    $this->messageManager->addSuccessMessage('Voucher Status successfully created');
                }

                if (isset($post['entity_id'])) {
                    $this->voucherStatusResource->load($status, $post['entity_id']);
                    $status->addData($post);
                    $status->setEntityId($post['entity_id']);
                    $this->voucherStatusResource->save($status);
                    $this->messageManager->addSuccessMessage('Voucher Status successfully updated');
                }

                $this->_redirect('vouchers/voucherstatus/index');
            }
        }
    }
}
