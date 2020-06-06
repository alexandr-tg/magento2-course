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
     * @param $customer_id
     * @param $status_id
     * @param $voucher_code
     * @return Voucher
     */
    public function setVoucherCode($customer_id, $status_id, $voucher_code)
    {
        return $this->setData(['customer_id' => $customer_id, 'status_id' => $status_id, 'voucher_code' =>$voucher_code]);
    }

    /**
     * @return string[]
     */
    public function getVoucherCode()
    {
        return $this->getData('voucher_code');
    }
}
