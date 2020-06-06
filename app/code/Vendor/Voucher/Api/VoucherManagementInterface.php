<?php

namespace Vendor\Voucher\Api;

/**
 * @Api
 * Interface VoucherManagementInterface
 * @package Vendor\Voucher\Api
 */
interface VoucherManagementInterface
{
    /**
     * @return string[]
     */
    public function createVoucherStatus();

    /**
     * @param int $id
     * @return string[]
     */
    public function deleteVoucherStatus($id);

    /**
     * @return string[]
     */
    public function getAllVoucherStatuses();

    /**
     * @return mixed
     */
    public function createVoucher();

    /**
     * @param int $id
     * @return bool
     */
    public function deleteVoucher($id);

    /**
     * @return string[]
     */
    public function getAllVouchers();

    /**
     * @param int $id
     * @return string[]
     */
    public function getAllVouchersByCustomerId($id);
}
