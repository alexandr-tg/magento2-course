<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/** @var \Magento\Framework\App\ResourceConnection $resource */
$resource = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()
    ->get(\Magento\Framework\App\ResourceConnection::class);

$connection = $resource->getConnection('vouchers_voucherstatus_index.xml');
$connection->truncateTable($resource->getTableName('search_synonyms'));
