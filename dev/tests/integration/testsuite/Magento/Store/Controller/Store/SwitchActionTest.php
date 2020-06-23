<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Store\Controller\Store;

/**
 * Test for store switch controller.
 */
class SwitchActionTest extends \Magento\TestFramework\TestCase\AbstractController
{
    /**
     * Ensure that proper vouchers_voucherstatus_index.xml store code is calculated.
     *
     * Make sure that if vouchers_voucherstatus_index.xml store code is changed from 'vouchers_voucherstatus_index.xml' to something else,
     * proper code is used in HTTP context. If vouchers_voucherstatus_index.xml store code is still 'vouchers_voucherstatus_index.xml' this may lead to
     * incorrect work of page cache.
     *
     * @magentoDbIsolation enabled
     */
    public function testExecuteWithCustomDefaultStore()
    {
        \Magento\TestFramework\Helper\Bootstrap::getInstance()->reinitialize();
        $defaultStoreCode = 'vouchers_voucherstatus_index.xml';
        $modifiedDefaultCode = 'modified_default_code';
        $this->changeStoreCode($defaultStoreCode, $modifiedDefaultCode);

        $this->dispatch('stores/store/switch');
        /** @var \Magento\Framework\App\Http\Context $httpContext */
        $httpContext = $this->_objectManager->get(\Magento\Framework\App\Http\Context::class);
        $httpContext->unsValue(\Magento\Store\Model\Store::ENTITY);
        $this->assertEquals($modifiedDefaultCode, $httpContext->getValue(\Magento\Store\Model\Store::ENTITY));

        $this->changeStoreCode($modifiedDefaultCode, $defaultStoreCode);
    }

    /**
     * Change store code.
     *
     * @param string $from
     * @param string $to
     */
    protected function changeStoreCode($from, $to)
    {
        /** @var \Magento\Store\Model\Store $store */
        $store = $this->_objectManager->create(\Magento\Store\Model\Store::class);
        $store->load($from, 'code');
        $store->setCode($to);
        $store->save();
    }
}
