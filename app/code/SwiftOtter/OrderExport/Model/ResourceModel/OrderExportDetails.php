<?php

namespace SwiftOtter\OrderExport\Model\ResourceModel;



use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderExportDetails extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('sales_order_export', 'id');
    }
}
