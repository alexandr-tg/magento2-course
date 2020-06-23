<?php

namespace Vendor\Voucher\Block;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Vendor\Voucher\Model\VoucherStatusFactory as VoucherStatus;

class Update extends Template
{
    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @var VoucherStatus
     */
    private $voucherStatus;

    /**
     * Update constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param VoucherStatus $voucherStatus
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        VoucherStatus $voucherStatus,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->coreRegistry = $coreRegistry;
        $this->voucherStatus = $voucherStatus;
    }

    /**
     * @return string
     */
    public function getInsertAction()
    {
        return $this->getUrl('vouchers/voucherstatus/create');
    }

    /**
     * @return array|null
     */
    public function getEditRecord()
    {
        $id = $this->coreRegistry->registry('editRecordId');
        $voucher_status = $this->voucherStatus->create();
        $result = $voucher_status->load($id);
        return $result->getData();
    }
}
