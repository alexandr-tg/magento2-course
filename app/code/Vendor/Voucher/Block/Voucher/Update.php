<?php

namespace Vendor\Voucher\Block\Voucher;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Vendor\Voucher\Model\ResourceModel\Voucher as VoucherResource;
use Vendor\Voucher\Model\VoucherFactory;
use Vendor\Voucher\Model\ResourceModel\Voucher\CollectionFactory;
use Vendor\Voucher\Model\VoucherStatusFactory as VoucherStatus;

class Update extends Template
{
    private $coreRegistry;

    private $voucher;

    private $voucherResource;

    private $collectionFactory;

    private $voucherStatus;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        VoucherFactory $voucher,
        VoucherResource $voucherResource,
        CollectionFactory $collectionFactory,
        VoucherStatus $voucherStatus,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->coreRegistry = $coreRegistry;
        $this->voucher = $voucher;
        $this->voucherResource = $voucherResource;
        $this->collectionFactory = $collectionFactory;
        $this->voucherStatus = $voucherStatus;
    }

    public function getInsertAction()
    {
        return $this->getUrl('vouchers/voucher/create');
    }

    public function getEditRecord()
    {
        $id = $this->coreRegistry->registry('editRecordId');
        $voucher = $this->voucher->create();
        $this->voucherResource->load($voucher, $id);
        return $voucher;
    }

    public function getAvailableStatuses()
    {
        return $this->voucherStatus->create()->getCollection();
    }
}
