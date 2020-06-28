<?php

namespace Vendor\Voucher\Model\VoucherForm;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollection;

class OpinionCustomerProvider implements OptionSourceInterface
{
    protected $customer;

    public function __construct(
        CustomerCollection $customer
    ) {
        $this->customer = $customer;
    }

    public function toOptionArray()
    {
        $opinion = [];
        if (empty($opinion)) {
            $customers = $this->customer->create();

            foreach ($customers as $item) {
                $opinion[] = ['value' => $item->getId(), 'label' => $item->getName()];
            }

            return $opinion;
        }
    }
}
