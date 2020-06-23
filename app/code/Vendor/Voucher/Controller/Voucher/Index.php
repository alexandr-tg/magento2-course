<?php

namespace Vendor\Voucher\Controller\Voucher;

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
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Session $session
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Session $session
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->session = $session;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
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
