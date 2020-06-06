<?php

namespace Vendor\Voucher\Model\ResourceModel\VoucherStatus;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vendor\Voucher\Model\VoucherStatus as Model;
use Vendor\Voucher\Model\ResourceModel\VoucherStatus as ResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'voucher_status_collection';
    protected $_eventObject = 'voucher_status_collection';

    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
