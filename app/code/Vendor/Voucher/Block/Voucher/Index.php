<?php

namespace Vendor\Voucher\Block\Voucher;

use Magento\Customer\Model\SessionFactory as Session;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Vendor\Voucher\Model\ResourceModel\Voucher\CollectionFactory as VoucherCollection;
use Vendor\Voucher\Model\VoucherStatusFactory as VoucherStatus;

class Index extends Template
{

    /**
     * @var VoucherStatus
     */
    private $voucherStatus;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var VoucherCollection
     */
    private $voucherCollection;

    /**
     * Index constructor.
     * @param Context $context
     * @param VoucherStatus $voucherStatus
     * @param Session $session
     * @param VoucherCollection $voucherCollection
     */
    public function __construct(
        Context $context,
        VoucherStatus $voucherStatus,
        Session $session,
        VoucherCollection $voucherCollection
    ) {
        parent::__construct($context);
        $this->voucherStatus = $voucherStatus;
        $this->session = $session;
        $this->voucherCollection = $voucherCollection;
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     */
    public function getResult()
    {
        return $this->voucherCollection->create()->filterByCustomerId($this->session->create()->getCustomerId());
    }

    /**
     * @return string
     */
    public function getInsertAction()
    {
        return $this->getUrl('vouchers/voucher/create');
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     */
    public function getVoucherStatuses()
    {
        $voucher_statuses = $this->voucherStatus->create();
        return $voucher_statuses->getCollection();
    }
}
