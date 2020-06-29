<?php

namespace Vendor\Voucher\Ui\Component\Listing\Column;

use Vendor\Voucher\Model\VoucherStatusFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class VoucherVoucherStatusActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $urlBuilder;
    protected $voucherStatus;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        VoucherStatusFactory $voucherStatus,
        array $components=[],
        array $data=[]
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->voucherStatus = $voucherStatus;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                $customer = $this->voucherStatus->create()->load($item[$name]);


                $item[$name] = sprintf(
                    "<a href=\"%s\">%s</a>",
                    $this->urlBuilder->getUrl('vouchers/voucherstatusform/edit', ['id' => $customer->getId()]),
                    $customer->getStatusCode()
                );
            }
        }
        return $dataSource;
    }
}
