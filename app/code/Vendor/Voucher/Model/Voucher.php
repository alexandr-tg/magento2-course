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

    /**
     * @return string[]
     */
    public function getVoucherCode()
    {
        return $this->getData('voucher_code');
    }
}
