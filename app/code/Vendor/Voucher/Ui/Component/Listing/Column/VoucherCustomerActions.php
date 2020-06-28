<?php

namespace Vendor\Voucher\Ui\Component\Listing\Column;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class VoucherCustomerActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $urlBuilder;
    protected $customer;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        CustomerRepositoryInterface $customer,
        array $components=[],
        array $data=[]
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->customer = $customer;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                $customer = $this->customer->getById($item[$name]);

                $item[$name] = sprintf("%s %s", $customer->getFirstname(), $customer->getLastname());
                $item[$name] = sprintf(
                    "<a href=\"%s\">%s</a>",
                    $this->urlBuilder->getUrl('customer/index/edit/', ['id' => $customer->getId()]),
                    $item[$name]
                );
            }
        }
        return $dataSource;
    }
}
