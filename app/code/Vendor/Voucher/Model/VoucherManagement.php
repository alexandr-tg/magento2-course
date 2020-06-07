<?php

namespace Vendor\Voucher\Model;

use Magento\Customer\Model\CustomerFactory as CustomerModelFactory;
use Vendor\Voucher\Api\VoucherManagementInterface;
use Vendor\Voucher\Model\ResourceModel\Voucher as VoucherResource;
use Vendor\Voucher\Model\ResourceModel\Voucher\CollectionFactory as VoucherCollectionFactory;
use Vendor\Voucher\Model\ResourceModel\VoucherStatus as VoucherStatusResourceModel;
use Vendor\Voucher\Model\ResourceModel\VoucherStatus\CollectionFactory as VoucherStatusCollectionFactory;
use Vendor\Voucher\Model\VoucherFactory as VoucherModelFactory;
use Vendor\Voucher\Model\VoucherStatusFactory as VoucherStatusModelFactory;

class VoucherManagement implements VoucherManagementInterface
{
    /**
     * @var VoucherStatusModelFactory
     */
    private $voucherStatusModelFactory;
    /**
     * @var VoucherStatusCollectionFactory
     */
    private $voucherStatusCollectionFactory;
    /**
     * @var VoucherStatusResourceModel
     */
    private $voucherStatusResourceFactory;
    /**
     * @var VoucherFactory
     */
    private $voucherModelFactory;
    /**
     * @var VoucherResource
     */
    private $voucherResourceFactory;
    /**
     * @var VoucherCollectionFactory
     */
    private $voucherCollectionFactory;
    /**
     * @var CustomerModelFactory
     */
    private $customerModelFactory;

    /**
     * VoucherManagement constructor.
     * @param VoucherStatusCollectionFactory $voucherStatusCollectionFactory
     * @param VoucherStatusFactory $voucherStatusModelFactory
     * @param VoucherStatusResourceModel $voucherStatusResourceFactory
     * @param VoucherFactory $voucherModelFactory
     * @param VoucherResource $voucherResourceFactory
     * @param VoucherCollectionFactory $voucherCollectionFactory
     * @param CustomerModelFactory $customerModelFactory
     */
    public function __construct(
        VoucherStatusCollectionFactory $voucherStatusCollectionFactory,
        VoucherStatusModelFactory $voucherStatusModelFactory,
        VoucherStatusResourceModel $voucherStatusResourceFactory,
        VoucherModelFactory $voucherModelFactory,
        VoucherResource $voucherResourceFactory,
        VoucherCollectionFactory $voucherCollectionFactory,
        CustomerModelFactory $customerModelFactory
    ) {
        $this->voucherStatusCollectionFactory = $voucherStatusCollectionFactory;
        $this->voucherStatusModelFactory = $voucherStatusModelFactory;
        $this->voucherStatusResourceFactory = $voucherStatusResourceFactory;
        $this->voucherModelFactory = $voucherModelFactory;
        $this->voucherResourceFactory = $voucherResourceFactory;
        $this->voucherCollectionFactory = $voucherCollectionFactory;
        $this->customerModelFactory = $customerModelFactory;
    }

    public function createVoucherStatus($status)
    {
        $voucherStatus = $this->voucherStatusModelFactory->create();
        $voucherStatus->setStatusCode($status);
        $this->voucherStatusResourceFactory->save($voucherStatus);
        return $voucherStatus->getId();
    }

    public function deleteVoucherStatus($id)
    {
        $voucherStatus = $this->voucherStatusModelFactory->create();
        try {
            $voucherStatus->setId($id)->delete();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    public function getAllVoucherStatuses()
    {
        $data = [];
        $voucherStatusCollection = $this->voucherStatusCollectionFactory->create();
        /**
         * @var \Vendor\Voucher\Model\VoucherStatus $voucherStatus
         */
        foreach ($voucherStatusCollection as $voucherStatus) {
            $data[] = $voucherStatus->getStatusCode();
        }
        return $data;
    }

    public function createVoucher($customer_id, $status_id, $voucher_code)
    {
        $voucher = $this->voucherModelFactory->create();
        $voucher->setVoucherCode($customer_id, $status_id, $voucher_code);
        $this->voucherResourceFactory->save($voucher);
        return $voucher->getId();
    }

    public function deleteVoucher($id)
    {
        $voucher = $this->voucherModelFactory->create();
        try {
            $voucher->setId($id)->delete();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    public function getAllVouchers()
    {
        $data = [];
        $voucherCollection = $this->voucherCollectionFactory->create();
        foreach ($voucherCollection as $voucher) {
            $data[] = $voucher->getVoucherCode();
        }
        return $data;
    }

    public function getAllVouchersByCustomerId($id)
    {
        $data = [];
        $customer = $this->customerModelFactory->create()->load($id);

        $voucherCollection = $this->voucherCollectionFactory->create();

        if (!$customer || !$customer->getId()) {
            throw new \Exception("Customer $id is invalid");
        }

        /** @var \Vendor\Voucher\Model\Voucher  $vouchers */
        foreach ($voucherCollection->filterByCustomerId($customer->getId()) as $vouchers) {
            $data[] = $vouchers->getVoucherCode();
        }

        return $data;
    }
}
