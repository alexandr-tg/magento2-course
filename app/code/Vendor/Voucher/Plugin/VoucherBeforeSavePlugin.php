<?php

namespace Vendor\Voucher\Plugin;

use Magento\Customer\Model\CustomerFactory as CustomerModel;
use Vendor\Voucher\Model\Voucher as Subject;

class VoucherBeforeSavePlugin
{
    /**
     * @var CustomerModel
     */
    private $customerModel;

    /**
     * VoucherAfterSetCustomerIdPlugin constructor.
     * @param CustomerModel $customerModel
     */
    public function __construct(CustomerModel $customerModel)
    {
        $this->customerModel = $customerModel;
    }

    /**
     * @param Subject $subject
     */
    public function beforeSave(Subject $subject)
    {
        $customer = $this->customerModel->create()->getId();
        $subject->setData('customer_id', $subject->getExtensionAttributes()->getCustomer()->getId());
    }
}
