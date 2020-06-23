<?php

namespace Vendor\Voucher\Controller\VoucherStatus;

use Magento\Customer\Model\SessionFactory as Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var Session
     */
    private $session;

    /**
     * Index constructor.
     * @param PageFactory $PageResult
     * @param Context $context
     * @param Session $session
     */
    public function __construct(
        PageFactory $PageResult,
        Context $context,
        Session $session
    ) {
        $this->pageFactory = $PageResult;
        $this->session = $session;
        parent::__construct($context);
    }

    /**
     * @return void|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        if ($this->session->create()->isLoggedIn()) {
            return $this->pageFactory->create();
        } else {
            $this->_redirect('customer/account/login/');
        }
    }
}
