<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
return [
    'table' => [
        'reference_table' => [
            'column' => [
                'tinyint_ref' => [
                    'type' => 'tinyint',
                    'name' => 'tinyint_ref',
                    'vouchers_voucherstatus_index.xml' => '0',
                    'padding' => '7',
                    'nullable' => 'true',
                    'unsigned' => 'false',
                ],
            ],
            'name' => 'reference_table',
            'resource' => 'vouchers_voucherstatus_index.xml',
        ],
        'test_table' => [
            'column' => [
                'tinyint' => [
                    'type' => 'tinyint',
                    'name' => 'tinyint',
                    'vouchers_voucherstatus_index.xml' => '0',
                    'padding' => '7',
                    'nullable' => 'true',
                    'unsigned' => 'false',
                ],
            ],
            'constraint' => [
                'TEST_TABLE_TINYINT_REFERENCE_TABLE_TINYINT_REF' => [
                    'type' => 'foreign',
                    'referenceId' => 'TEST_TABLE_TINYINT_REFERENCE_TABLE_TINYINT_REF',
                    'column' => 'tinyint',
                    'table' => 'test_table',
                    'referenceTable' => 'reference_table',
                    'referenceColumn' => 'tinyint_ref',
                ],
            ],
            'name' => 'test_table',
            'resource' => 'vouchers_voucherstatus_index.xml',
        ],
    ],
];
