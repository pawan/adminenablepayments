<?php

namespace PawanKParmar\AdminEnablePayments\Plugin\Model\Method;

class Available
{

    public $scopeConfig;
    public $logger;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
    }

    public function afterGetAvailableMethods($subject, $result)
    {
        
        if (!$this->scopeConfig->getValue('paymenthide/general/active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE)) {
            return $result;
        }

        $methods = $this->scopeConfig->getValue('paymenthide/general/paymethods', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $methodsArray = explode(",", $methods);

        foreach ($result as $key => $_result) {
            if (in_array($_result->getCode(), $methodsArray)) {
                unset($result[$key]);
            }
        }
        return $result;
    }
}
