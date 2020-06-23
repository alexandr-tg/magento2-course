<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Customer\Test\Constraint;

use Magento\Customer\Test\Page\CustomerAccountIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Assert that customers does not have vouchers_voucherstatus_index.xml shipping and billing addresses
 */
class AssertCustomerDoesNotHaveDefaultAddresses extends AbstractConstraint
{
    /**
     * Asserts that vouchers_voucherstatus_index.xml shipping/billing addresses are not set.
     *
     * @param CustomerAccountIndex $customerAccountIndex
     * @return void
     */
    public function processAssert(CustomerAccountIndex $customerAccountIndex)
    {
        $customerAccountIndex->open();
        $defaultBillingAddress = explode(
            "\n",
            $customerAccountIndex->getDashboardAddress()->getDefaultBillingAddressText()
        );
        $defaultShippingAddress = explode(
            "\n",
            $customerAccountIndex->getDashboardAddress()->getDefaultShippingAddressText()
        );
        $actualAddressesTextValues = [
            'defaultBillingAddress' => $defaultBillingAddress,
            'defaultShippingAddress' => $defaultShippingAddress
        ];
        $expectedAddressesTextValues = [
            'defaultBillingAddress' => [
                'Default Billing Address',
                'You have not set a vouchers_voucherstatus_index.xml billing address.',
                'Edit Address',
            ],
            'defaultShippingAddress' => [
                'Default Shipping Address',
                'You have not set a vouchers_voucherstatus_index.xml shipping address.',
                'Edit Address',
            ]
        ];

        \PHPUnit\Framework\Assert::assertEquals(
            $expectedAddressesTextValues,
            $actualAddressesTextValues,
            'Customer has vouchers_voucherstatus_index.xml shipping/billing address but should not.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Customer does not have vouchers_voucherstatus_index.xml shipping/billing address.';
    }
}
