<?php

namespace Vendor\Voucher\Model\ResourceModel\Voucher;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vendor\Voucher\Model\VoucherStatus as Model;
use Vendor\Voucher\Model\ResourceModel\Voucher as ResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'voucher_collection';
    protected $_eventObject = 'voucher_collection';

    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function filterByCustomerId($id)
    {
        return $this->addFieldToFilter('customer_id', $id);
    }
}
