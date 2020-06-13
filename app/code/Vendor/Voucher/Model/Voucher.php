<?php

namespace Vendor\Voucher\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use Vendor\Voucher\Api\Data\VoucherExtensionInterface;
use Vendor\Voucher\Api\Data\VoucherInterface;
use Vendor\Voucher\Model\ResourceModel\Voucher as ResourceModel;

class Voucher extends AbstractExtensibleModel implements IdentityInterface, VoucherInterface
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

    /**
     * @param $customer_id
     * @return Voucher
     */
    public function setCustomerId($customer_id)
    {
        return $this->setData('customer_id', $customer_id);
    }

    /**
     * @return int|string
     */
    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    /**
     * @param $status_id
     * @return Voucher
     */
    public function setStatusId($status_id)
    {
        return $this->setData('status_id', $status_id);
    }

    /**
     * @return int|string
     */
    public function getStatusId()
    {
        return $this->getData('status_id');
    }

    /**
     * @param $voucher_code
     * @return Voucher
     */
    public function setVoucherCode($voucher_code)
    {
        return $this->setData('voucher_code', $voucher_code);
    }

    /**
     * @return int|string
     */
    public function getVoucherCode()
    {
        return $this->getData('voucher_code');
    }

    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(VoucherExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
