<?php

namespace SwiftOtter\OrderExport\Action;

use Magento\Sales\Api\OrderRepositoryInterface;
use SwiftOtter\OrderExport\Api\OrderDataCollectorInterface;
use SwiftOtter\OrderExport\Model\HeaderData;

class CollectOrderData
{
    private OrderRepositoryInterface $orderRepository;
    /**
     * @var OrderDataCollectorInterface[]
     */
    private array $collectors;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        array $collectors = []
    ) {
        $this->orderRepository = $orderRepository;
        $this->collectors = $collectors;
    }
    public function execute(int $orderId, HeaderData $headerData) : array
    {
        $order = $this->orderRepository->get($orderId);

        $output = [];
        foreach ($this->collectors as $collector) {
            $output = array_merge_recursive($output, $collector->collect($order, $headerData));
        }

        return $output;
    }
}
