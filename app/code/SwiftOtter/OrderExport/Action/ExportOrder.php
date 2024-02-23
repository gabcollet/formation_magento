<?php

namespace SwiftOtter\OrderExport\Action;

use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use SwiftOtter\OrderExport\Model\HeaderData;
use SwiftOtter\OrderExport\Model\Config;
use SwiftOtter\OrderExport\Action\PushDetailsToWebservice;

class ExportOrder
{
    private OrderRepositoryInterface $orderRepository;
    private Config $config;
    private CollectOrderData $collectOrderData;
    private PushDetailsToWebservice $pushDetailsToWebservice;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Config $config,
        CollectOrderData $collectOrderData,
        PushDetailsToWebservice $pushDetailsToWebservice
    )
    {
        $this->orderRepository = $orderRepository;
        $this->config = $config;
        $this->collectOrderData = $collectOrderData;
        $this->pushDetailsToWebservice = $pushDetailsToWebservice;
    }

    public function execute(int $orderId, HeaderData $headerData): array
    {
        $order = $this->orderRepository->get($orderId);

        if (!$this->config->isEnable(ScopeInterface::SCOPE_STORE, $order->getStoreId())) {
            throw new LocalizedException(__('Order export is disabled'));
        }

        $results = ['success' => false, 'error' => null];

        $exportData = $this->collectOrderData->execute($order, $headerData);

        try {
            $results['success'] = $this->pushDetailsToWebservice->execute($exportData, $order);
        } catch (\Throwable $ex) {
            $results['error'] = $ex->getMessage();
        }

        return $results;
    }
}
