<?php

namespace Vendor\Voucher\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class CustomerGroupPatch implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * CustomerGroupPatch constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $setup = $this->moduleDataSetup->getConnection()->startSetup();

        $setup->insert('customer_group', ['customer_group_code' =>'Privileged Customers', 'tax_class_id' => 3]);

        $setup->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function revert()
    {
    }

    public function getAliases()
    {
        return [];
    }
}
