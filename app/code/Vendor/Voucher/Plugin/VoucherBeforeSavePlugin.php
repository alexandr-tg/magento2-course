<?php

namespace Vendor\Voucher\Plugin;

use Vendor\Voucher\Model\Voucher as Subject;

class VoucherBeforeSavePlugin
{
    /**
     * @param Subject $subject
     */
    public function beforeSave(Subject $subject)
    {
        $subject->setData('customer_id', $subject->getExtensionAttributes()->getCustomer()->getId());
    }
}
