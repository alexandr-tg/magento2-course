<?php

namespace Vendor\Voucher\Plugin;

use Magento\Customer\Model\CustomerFactory as CustomerModelFactory;
use Magento\Framework\Exception\LocalizedException;
use Vendor\Voucher\Model\VoucherManagement as Subject;

class VoucherBeforeCreateVoucherPlugin
{
    /**
     * @var CustomerModelFactory
     */
    private $customerModel;

    /**
     * VoucherAfterSetCustomerIdPlugin constructor.
     * @param CustomerModelFactory $customerModel
     */
    public function __construct(CustomerModelFactory $customerModel)
    {
        $this->customerModel = $customerModel;
    }

    /**
     * @param Subject $subject
     * @param $customer_id
     * @throws LocalizedException
     */
    public function beforeCreateVoucher(Subject $subject, $customer_id)
    {
        $customer = $this->customerModel->create()->load($customer_id);

        if ($customer->getGroupId() != 9) {
            throw new LocalizedException(__('Customer isn\'t in a privileged group'));
        }
    }
}
