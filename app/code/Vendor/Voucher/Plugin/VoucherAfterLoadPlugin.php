<?php

namespace Vendor\Voucher\Plugin;

use Magento\Customer\Model\CustomerFactory as CustomerModel;
use Magento\Framework\Exception\LocalizedException;
use Vendor\Voucher\Model\Voucher as Subject;

class VoucherAfterLoadPlugin
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
     * @throws LocalizedException
     */
    public function afterLoad(Subject $subject)
    {
        $customer = $this->customerModel->create()->load($subject->getData('customer_id'));
        $voucher = $subject->getExtensionAttributes();

        if ($voucher == null) {
            throw new LocalizedException(__('GetExtensionAttributes return Null'));
        }

        $voucher->setCustomer($customer);
    }
}
