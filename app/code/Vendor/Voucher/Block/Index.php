<?php

namespace Vendor\Voucher\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Vendor\Voucher\Model\VoucherStatusFactory as VoucherStatus;

class Index extends Template
{
    /**
     * @var VoucherStatus
     */
    private $voucherStatus;

    /**
     * Index constructor.
     * @param Context $context
     * @param VoucherStatus $voucherStatus
     */
    public function __construct(
        Context $context,
        VoucherStatus $voucherStatus
    ) {
        parent::__construct($context);
        $this->voucherStatus = $voucherStatus;
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     */
    public function getResult()
    {
        $voucher_statuses = $this->voucherStatus->create();
        return $voucher_statuses->getCollection();
    }

    /**
     * @return string
     */
    public function getInsertAction()
    {
        return $this->getUrl('vouchers/voucherstatus/create');
    }
}
