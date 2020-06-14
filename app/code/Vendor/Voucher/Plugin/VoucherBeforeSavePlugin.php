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
        $subject->setCustomerId($subject->getExtensionAttributes()->getCustomer()->getId());
    }
}
