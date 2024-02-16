<?php

namespace SwiftOtter\OrderExport\Action;

use Magento\Sales\Api\Data\OrderInterface;
use SwiftOtter\OrderExport\Api\OrderDataCollectorInterface;
use SwiftOtter\OrderExport\Model\HeaderData;

class CollectOrderData
{
    /**
     * @var OrderDataCollectorInterface[]
     */
    private array $collectors;

    public function __construct(
        array $collectors = []
    ) {
        $this->collectors = $collectors;
    }
    public function execute(OrderInterface $order, HeaderData $headerData) : array
    {
        $output = [];
        foreach ($this->collectors as $collector) {
            $output = array_merge_recursive($output, $collector->collect($order, $headerData));
        }

        return $output;
    }
}
