<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\SalesRule\Model\ResourceModel\Rule;

use Magento\Config\Model\Config\Backend\Admin\Custom as AdminBackendConfig;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Api\WebsiteRepositoryInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class CollectionTest extends TestCase
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var string
     */
    private $defaultTimezone;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $scopeConfig = Bootstrap::getObjectManager()->get(ScopeConfigInterface::class);
        $this->defaultTimezone = $scopeConfig->getValue(AdminBackendConfig::XML_PATH_GENERAL_LOCALE_TIMEZONE);

        $this->collection = Bootstrap::getObjectManager()->create(Collection::class);
    }

    /**
     * @magentoDataFixture Magento/SalesRule/_files/rules.php
     * @magentoDataFixture Magento/SalesRule/_files/coupons.php
     * @dataProvider setValidationFilterDataProvider()
     * @param string $couponCode
     * @param array $expectedItems
     * @magentoDbIsolation disabled
     */
    public function testSetValidationFilter($couponCode, $expectedItems)
    {
        /** @var \Magento\SalesRule\Model\Rule[] $items */
        $items = array_values($this->collection->setValidationFilter(1, 0, $couponCode)->getItems());

        $this->assertEquals(
            count($expectedItems),
            count($items),
            'Invalid number of items in the result collection'
        );

        $ids = [];
        foreach ($items as $key => $item) {
            $this->assertEquals($expectedItems[$key], $item->getName());
            $this->assertFalse(
                in_array($item->getId(), $ids),
                'Item should be unique in result collection'
            );
            $ids[] = $item->getId();
        }
    }

    /**
     * data provider for testSetValidationFilter
     * @return array
     */
    public function setValidationFilterDataProvider()
    {
        return [
            'Check type COUPON' => ['coupon_code', ['#1', '#2', '#5']],
            'Check type NO_COUPON' => ['', ['#2', '#5']],
            'Check type COUPON_AUTO' => ['coupon_code_auto', ['#2', '#4', '#5']],
            'Check result with auto generated coupon' => ['autogenerated_3_1', ['#2', '#3', '#5']],
            'Check result with non actual previously generated coupon' => [
                'autogenerated_2_1',
                ['#2', '#5'],
            ],
            'Check result with wrong code' => ['wrong_code', ['#2', '#5']]
        ];
    }

    /**
     * @magentoDbIsolation disabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture Magento/Checkout/_files/quote_with_shipping_method_and_items_categories.php
     * @magentoDataFixture Magento/SalesRule/_files/rules_group_any_categories.php
     */
    public function testSetValidationFilterWithGroup()
    {
        $objectManager = Bootstrap::getObjectManager();

        /** @var \Magento\SalesRule\Model\Rule $rule */
        $rule = $objectManager->get(\Magento\Framework\Registry::class)
            ->registry('_fixture/Magento_SalesRule_Group_Multiple_Categories');

        /** @var \Magento\Quote\Model\Quote  $quote */
        $quote = $objectManager->create(\Magento\Quote\Model\Quote::class);
        $quote->load('test_order_item_with_items', 'reserved_order_id');

        //gather only the existing rules that obey the validation filter
        $appliedRulesArray = array_keys(
            $this->collection->setValidationFilter(
                $quote->getStore()->getWebsiteId(),
                0,
                '',
                null,
                $quote->getShippingAddress()
            )->getItems()
        );

        $this->assertEquals([$rule->getRuleId()], $appliedRulesArray);
    }

    /**
     * @magentoDbIsolation disabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture Magento/Checkout/_files/quote_with_shipping_method_and_items_categories.php
     * @magentoDataFixture Magento/SalesRule/_files/rules_group_any_categories.php
     */
    public function testSetValidationFilterAnyCategory()
    {
        $objectManager = Bootstrap::getObjectManager();

        /** @var \Magento\SalesRule\Model\Rule $rule */
        $rule = $objectManager->get(\Magento\Framework\Registry::class)
            ->registry('_fixture/Magento_SalesRule_Group_Multiple_Categories');

        /** @var \Magento\Quote\Model\Quote  $quote */
        $quote = $objectManager->create(\Magento\Quote\Model\Quote::class);
        $quote->load('test_order_item_with_items', 'reserved_order_id');

        //gather only the existing rules that obey the validation filter
        $appliedRulesArray = array_keys(
            $this->collection->setValidationFilter(
                $quote->getStore()->getWebsiteId(),
                0,
                '',
                null,
                $quote->getShippingAddress()
            )->getItems()
        );
        $this->assertEquals([$rule->getRuleId()], $appliedRulesArray);
    }

    /**
     * @magentoDbIsolation disabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture Magento/Checkout/_files/quote_with_shipping_method_and_items_categories.php
     * @magentoDataFixture Magento/SalesRule/_files/rules_group_not_categories_sku_attr.php
     * @magentoDataFixture Magento/SalesRule/_files/rules_group_any_categories.php
     * @magentoDataFixture Magento/SalesRule/_files/rules_group_any_categories_price_attr_set_any.php
     */
    public function testSetValidationFilterOther()
    {
        $objectManager = Bootstrap::getObjectManager();

        /** @var \Magento\Quote\Model\Quote  $quote */
        $quote = $objectManager->create(\Magento\Quote\Model\Quote::class);
        $quote->load('test_order_item_with_items', 'reserved_order_id');

        //gather only the existing rules that obey the validation filter
        $appliedRulesArray = array_keys(
            $this->collection->setValidationFilter(
                $quote->getStore()->getWebsiteId(),
                0,
                '',
                null,
                $quote->getShippingAddress()
            )->getItems()
        );
        $this->assertEquals(3, count($appliedRulesArray));
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture Magento/SalesRule/_files/rules.php
     * @magentoDataFixture Magento/SalesRule/_files/coupons.php
     * @magentoDataFixture Magento/SalesRule/_files/rule_specific_date.php
     * @magentoConfigFixture general/locale/timezone Europe/Kiev
     */
    public function testMultiRulesWithTimezone()
    {
        $this->setSpecificTimezone('Europe/Kiev');
        $this->collection->addWebsiteGroupDateFilter(1, 0);
        $items = array_values($this->collection->getItems());
        $this->assertNotEmpty($items);
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture Magento/SalesRule/_files/rules.php
     * @magentoDataFixture Magento/SalesRule/_files/coupons.php
     * @magentoDataFixture Magento/SalesRule/_files/rule_specific_date.php
     * @magentoConfigFixture general/locale/timezone Australia/Sydney
     */
    public function testMultiRulesWithDifferentTimezone()
    {
        $this->setSpecificTimezone('Australia/Sydney');
        $this->collection->addWebsiteGroupDateFilter(1, 0);
        $items = array_values($this->collection->getItems());
        $this->assertNotEmpty($items);
    }

    protected function setSpecificTimezone($timezone)
    {
        $localeData = [
            'section' => 'general',
            'website' => null,
            'store' => null,
            'groups' => [
                'locale' => [
                    'fields' => [
                        'timezone' => [
                            'value' => $timezone
                        ]
                    ]
                ]
            ]
        ];
        Bootstrap::getObjectManager()->get(\Magento\Config\Model\Config\Factory::class)
            ->create()
            ->addData($localeData)
            ->save();
    }

    /**
     * Check that it's possible to find previously created rule by attribute.
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture Magento/SalesRule/_files/rule_custom_product_attribute.php
     */
    public function testAddAttributeInConditionFilterPositive()
    {
        $this->collection->addAttributeInConditionFilter('attribute_for_sales_rule_1');
        /** @var \Magento\SalesRule\Model\Rule $item */
        $item = $this->collection->getFirstItem();
        $this->assertEquals('50% Off on some attribute', $item->getName());
    }

    /**
     * Check that it's not possible to find previously created rule by wrong attribute.
     *
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture Magento/SalesRule/_files/rule_custom_product_attribute.php
     */
    public function testAddAttributeInConditionFilterNegative()
    {
        $this->collection->addAttributeInConditionFilter('attribute_for_sales_rule_2');
        $this->assertEquals(0, $this->collection->count());
    }

    /**
     * @magentoAppIsolation disabled
     * @magentoDataFixture Magento/SalesRule/_files/multi_websites_rules.php
     * @dataProvider addWebsiteFilterDataProvider
     * @param string[] $websiteCodes
     * @param int $count
     */
    public function testAddWebsiteFilter(array $websiteCodes, int $count)
    {
        $websiteRepository = Bootstrap::getObjectManager()->get(WebsiteRepositoryInterface::class);
        $websiteIds = [];
        foreach ($websiteCodes as $websiteCode) {
            $websiteIds[] = (int) $websiteRepository->get($websiteCode)->getId();
        }

        $this->collection->addWebsiteFilter($websiteIds);
        $this->assertEquals($count, $this->collection->getSize());
        $this->assertCount($count, $this->collection->getItems());
    }

    /**
     * @return array
     */
    public function addWebsiteFilterDataProvider(): array
    {
        return [
            [
                ['base'],
                4,
            ],
            [
                ['test'],
                2,
            ],
            [
                ['base', 'test'],
                5,
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        // restore vouchers_voucherstatus_index.xml timezone
        $this->setSpecificTimezone($this->defaultTimezone);
    }
}
