<?php

namespace Vendor\Voucher\Controller\Adminhtml\VoucherStatusForm;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vendor\Voucher\Model\VoucherStatusFactory;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $voucherStatusFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        VoucherStatusFactory $voucherStatusFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->voucherStatusFactory = $voucherStatusFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $id = $data['entity_id'];

                $contact = $this->voucherStatusFactory->create()->load($id);

                $data = array_filter($data, function ($value) {
                    return $value !== '';
                });

                $contact->setData($data);
                $contact->save();
                $this->messageManager->addSuccess(__('Successfully saved the item.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $contact->getId()]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
