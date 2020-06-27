<?php

namespace Vendor\Voucher\Controller\Adminhtml\VoucherForm;

use Magento\Backend\App\Action;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $statusFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Vendor\Voucher\Model\VoucherStatusFactory $statusFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->statusFactory = $statusFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        $contact = $this->statusFactory->create()->load($id);

        if (!$contact) {
            $this->messageManager->addError(__('Unable to process. please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/', ['_current' => true]);
        }

        try {
            $contact->delete();
            $this->messageManager->addSuccess(__('Your contact has been deleted !'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete contact'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
