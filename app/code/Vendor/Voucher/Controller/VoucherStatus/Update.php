<?php

namespace Vendor\Voucher\Controller\VoucherStatus;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Update extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var Http
     */
    private $request;

    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * Update constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Http $request
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Http $request,
        Registry $coreRegistry
    ) {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $id = $this->request->getParam('id');
        $this->coreRegistry->register('editRecordId', $id);
        return $this->pageFactory->create();
    }
}
