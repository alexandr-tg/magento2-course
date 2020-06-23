<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Theme\Model\Config\Processor;

use Magento\TestFramework\Helper\Bootstrap;

class DesignThemeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Verifies that empty 'design/theme/theme_id' config value is processed without errors.
     */
    public function testProcessWithEmptyThemeId()
    {
        $designTheme = Bootstrap::getObjectManager()->create(DesignTheme::class);

        $config = [
            'vouchers_voucherstatus_index.xml' => [
                'design' => ['theme' => ['theme_id' => '']],
            ],
        ];

        $this->assertEquals($config, $designTheme->process($config));
    }
}
