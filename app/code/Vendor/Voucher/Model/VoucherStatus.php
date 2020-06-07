<?php


namespace Vendor\Voucher\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Vendor\Voucher\Model\ResourceModel\VoucherStatus as ResourceModel;

class VoucherStatus extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'voucher_status';

    protected $_cacheTag = 'voucher_status';

    protected $_eventPrefix = 'voucher_status';

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
     * @param $status
     */
    public function setStatusCode($status)
    {
        $this->setData(['status_code' => $status]);
    }

    /**
     * @return string[]
     */
    public function getStatusCode()
    {
        return $this->getData('status_code');
    }
}
