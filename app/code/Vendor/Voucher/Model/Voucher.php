<?php


namespace Vendor\Voucher\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Vendor\Voucher\Model\ResourceModel\Voucher as ResourceModel;

class Voucher extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'voucher';

    protected $_cacheTag = 'voucher';

    protected $_eventPrefix = 'voucher';

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        return [];
    }


    public function setCustomerId($customer_id)
    {
        return $this->setData('customer_id', $customer_id);
    }

    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    public function setStatusId($status_id)
    {
        return $this->setData('status_id', $status_id);
    }

    public function getStatusId()
    {
        return $this->getData('status_id');
    }

    public function setVoucherCode($voucher_code)
    {
        return $this->setData('voucher_code', $voucher_code);
    }

    public function getVoucherCode()
    {
        return $this->getData('voucher_code');
    }
}
