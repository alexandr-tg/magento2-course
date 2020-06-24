<?php

namespace Vendor\Voucher\Controller\Voucher;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Vendor\Voucher\Model\ResourceModel\Voucher as VoucherResource;
use Vendor\Voucher\Model\VoucherFactory as Voucher;

class Delete extends Action
{
    /**
     * @var Http
     */
    private $request;

    /**
     * @var Voucher
     */
    private $voucher;

    /**
     * @var VoucherResource
     */
    private $voucherResource;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Http $request
     * @param Voucher $voucher
     * @param VoucherResource $voucherResource
     */
    public function __construct(
        Context $context,
        Http $request,
        Voucher $voucher,
        VoucherResource $voucherResource
    ) {
        $this->request = $request;
        $this->voucher = $voucher;
        $this->voucherResource = $voucherResource;
        return parent::__construct($context);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function execute()
    {
        $id = $this->request->getParam('id');
        $voucher = $this->voucher->create()->setEntityId($id);
        $this->voucherResource->delete($voucher);
        $this->messageManager->addSuccessMessage('Voucher status successfully deleted');
        $this->_redirect('vouchers/voucher/index');
    }
}
