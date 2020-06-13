<?php

namespace Vendor\Voucher\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Vendor\Voucher\Model\ResourceModel\Voucher\CollectionFactory as VoucherCollection;
use Vendor\Voucher\Model\Voucher as VoucherModel;

class ChangeCustomerGroupIdAfter implements ObserverInterface
{
    private $voucherCollection;

    private $voucherModel;

    public function __construct(
        VoucherCollection $voucherCollection,
        VoucherModel $voucherModel
    ) {
        $this->voucherCollection = $voucherCollection;
        $this->voucherModel = $voucherModel;
    }

    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getData('customer_data_object');
        $id = $customer->getId();

        $vouchers = $this->voucherCollection->create()->filterByCustomerId($id);

        if (is_object($vouchers) && count($vouchers) != 0) {
            $group_id = $customer->getGroupId();

            $data = '';
            if ($group_id != 10) {
                foreach ($vouchers as $value) {
                    $this->voucherModel->setEntityId($value->getEntityId())->delete();
                }
            }
        }
    }
}
