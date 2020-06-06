<?php

namespace Vendor\Voucher\Model;

use Magento\Customer\Model\CustomerFactory as CustomerModelFactory;
use Vendor\Voucher\Api\VoucherManagementInterface;
use Vendor\Voucher\Model\ResourceModel\Voucher\CollectionFactory as VoucherCollectionFactory;
use Vendor\Voucher\Model\ResourceModel\VoucherFactory as VoucherResourceFactory;
use Vendor\Voucher\Model\ResourceModel\VoucherStatus\CollectionFactory as VoucherStatusCollectionFactory;
use Vendor\Voucher\Model\ResourceModel\VoucherStatusFactory as VoucherStatusResourceModel;
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
     * @var VoucherResourceFactory
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
     * @param VoucherResourceFactory $voucherResourceFactory
     * @param VoucherCollectionFactory $voucherCollectionFactory
     * @param CustomerModelFactory $customerModelFactory
     */
    public function __construct(
        VoucherStatusCollectionFactory $voucherStatusCollectionFactory,
        VoucherStatusModelFactory $voucherStatusModelFactory,
        VoucherStatusResourceModel $voucherStatusResourceFactory,
        VoucherModelFactory $voucherModelFactory,
        VoucherResourceFactory $voucherResourceFactory,
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

    public function createVoucherStatus()
    {
        $content = trim(file_get_contents("php://input"));
        $status = json_decode($content, true)['status'];
        $voucherStatus = $this->voucherStatusModelFactory->create();
        $voucherStatus->setData(['status_code' => $status]);
        $voucherStatus->save();
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

    public function createVoucher()
    {
        $content = trim(file_get_contents("php://input"));
        $decode = json_decode($content, true);
        $customer_id = $decode['customer_id'];
        $status_id = $decode['status_id'];
        $voucher_code = $decode['voucher_code'];

        $voucher = $this->voucherModelFactory->create();
        $voucher->setData(['customer_id' => $customer_id, 'status_id' => $status_id, 'voucher_code' =>$voucher_code]);
        $voucher->save();
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
