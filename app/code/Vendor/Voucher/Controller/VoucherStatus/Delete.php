<?php

namespace Vendor\Voucher\Controller\VoucherStatus;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Vendor\Voucher\Model\VoucherStatusFactory as VoucherStatus;
use Vendor\Voucher\Model\ResourceModel\VoucherStatus as VoucherStatusResource;

class Delete extends Action
{
    /**
     * @var Http
     */
    private $request;

    /**
     * @var VoucherStatus
     */
    private $voucherStatus;

    /**
     * @var VoucherStatusResource
     */
    private $voucherStatusResource;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Http $request
     * @param VoucherStatus $voucherStatus
     * @param VoucherStatusResource $voucherStatusResource
     */
    public function __construct(
        Context $context,
        Http $request,
        VoucherStatus $voucherStatus,
        VoucherStatusResource $voucherStatusResource
    ) {
        $this->request = $request;
        $this->voucherStatus = $voucherStatus;
        $this->voucherStatusResource = $voucherStatusResource;
        return parent::__construct($context);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function execute()
    {
        $id = $this->request->getParam('id');
        $voucherStatus = $this->voucherStatus->create()->setEntityId($id);
        $this->voucherStatusResource->delete($voucherStatus);
        $this->messageManager->addSuccessMessage('Voucher status successfully deleted');
        $this->_redirect('vouchers/voucherstatus/index');
    }
}
