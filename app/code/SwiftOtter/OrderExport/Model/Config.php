<?php

namespace SwiftOtter\OrderExport\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const CONFIG_PATH_ENABLED = 'sales/order_export/enabled';
    const CONFIG_PATH_API_TOKEN = 'sales/order_export/api_token';
    const CONFIG_PATH_API_URL = 'sales/order_export/api_url';
    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {

        $this->scopeConfig = $scopeConfig;
    }

    public function isEnable(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLED);
    }

    public function getApiToken(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        $value = $this->scopeConfig->getValue(self::CONFIG_PATH_API_TOKEN, $scopeType, $scopeCode);
        return ($value !== null) ? (string) $value : '';
    }

    public function getApiUrl(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        $value = $this->scopeConfig->getValue(self::CONFIG_PATH_API_URL, $scopeType, $scopeCode);
        return ($value !== null) ? (string) $value : '';
    }
}
