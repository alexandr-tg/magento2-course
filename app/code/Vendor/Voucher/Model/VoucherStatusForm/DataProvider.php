<?php

namespace Vendor\Voucher\Model\VoucherStatusForm;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Vendor\Voucher\Model\ResourceModel\VoucherStatus\CollectionFactory;
use Vendor\Voucher\Model\VoucherStatusFactory;

class DataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $_loadedData;
    protected $voucher;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        VoucherStatusFactory $voucher,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $contactCollectionFactory->create();
        $this->voucher = $voucher;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        $items = $this->voucher->create()->getCollection()->getItems();

        foreach ($items as $contact) {
            $this->_loadedData[$contact->getId()] = $contact->getData();
        }

        return $this->_loadedData;
    }
}
