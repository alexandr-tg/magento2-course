<?php

namespace Vendor\Voucher\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface VoucherInterface extends ExtensibleDataInterface
{
    /**
     * @return \Vendor\Voucher\Api\Data\VoucherExtensionInterface
     */
    public function getExtensionAttributes();

    /**
     * @param VoucherExtensionInterface $extensionAttributes
     * @return mixed
     */
    public function setExtensionAttributes(
        VoucherExtensionInterface $extensionAttributes
    );
}
