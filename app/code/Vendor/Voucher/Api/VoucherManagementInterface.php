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
     * @param mixed $status
     * @return mixed
     */
    public function createVoucherStatus($status);

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
     * @param int $customer_id
     * @param int $status_id
     * @param string $voucher_code
     * @return mixed
     */
    public function createVoucher($customer_id, $status_id, $voucher_code);

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

    /**
     * @return string[]
     */
    public function getCurrentCustomerVouchers();

}
