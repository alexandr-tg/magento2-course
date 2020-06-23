<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/** @var Value $config */
use Magento\Framework\App\Config\Value;

$config = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(Value::class);
$config->setPath('catalog/review/allow_guest');
$config->setScope('vouchers_voucherstatus_index.xml');
$config->setScopeId(0);
$config->setValue(0);
$config->save();
