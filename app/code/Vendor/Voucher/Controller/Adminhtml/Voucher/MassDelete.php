<?php

namespace Vendor\Voucher\Controller\Adminhtml\Voucher;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Vendor\Voucher\Model\ResourceModel\Voucher\CollectionFactory;
use Vendor\Voucher\Model\ResourceModel\VoucherFactory as VoucherResource;

class MassDelete extends Action
{
    private $filter;

    private $collectionFactory;

    private $voucher;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        VoucherResource $voucher
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->voucher = $voucher;

        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $voucher = $this->voucher->create();

            $done = 0;
            foreach ($collection as $item) {
                $voucher->delete($item);
                ++$done;
            }

            if ($done) {
                $this->messageManager->addSuccess(__('A total of %1 record(s) were modified.', $done));
            }
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Vendor_Voucher::mass_Delete');
    }
}
