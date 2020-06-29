<?php

namespace Vendor\Voucher\Model\VoucherForm;

use Magento\Framework\Data\OptionSourceInterface;
use Vendor\Voucher\Model\ResourceModel\VoucherStatus\CollectionFactory as VoucherStatusCollection;
use Vendor\Voucher\Model\VoucherStatusFactory as VoucherStatus;

class OpinionStatusProvider implements OptionSourceInterface
{
    protected $voucherStatus;

    protected $voucherStatusCollection;

    public function __construct(
        VoucherStatus $voucherStatus,
        VoucherStatusCollection $voucherStatusCollection
    ) {
        $this->voucherStatus = $voucherStatus;
        $this->voucherStatusCollection = $voucherStatusCollection;
    }

    public function toOptionArray()
    {
        $opinion = [];
        if (empty($opinion)) {
            $statuses = $this->voucherStatusCollection->create();

            foreach ($statuses as $item) {
                $opinion[] = ['value' => $item->getId(), 'label' => $item->getStatusCode()];
            }

            return $opinion;
        }
    }
}
