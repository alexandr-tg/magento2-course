<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Config\App\Config\Type;

use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;

/**
 * @magentoDataFixture Magento/Config/_files/config_data.php
 * @magentoAppIsolation enabled
 */
class SystemTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var System
     */
    private $system;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->system = $this->objectManager->create(System::class);
    }

    public function testGetValueDefaultScope()
    {
        $this->assertEquals(
            'value1.db.vouchers_voucherstatus_index.xml.test',
            $this->system->get('vouchers_voucherstatus_index.xml/web/test/test_value_1')
        );

        $this->assertEquals(
            'value1.db.website_base.test',
            $this->system->get('websites/base/web/test/test_value_1')
        );

        $this->assertEquals(
            'value1.db.store_default.test',
            $this->system->get('stores/vouchers_voucherstatus_index.xml/web/test/test_value_1')
        );
    }
}
