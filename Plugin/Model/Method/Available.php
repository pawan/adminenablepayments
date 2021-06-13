<?php

namespace Pawan\AdminEnablePayments\Plugin\Model\Method;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Available will check which payment method need to hide form frontend
 */
class Available
{

    /**
     * @var ScopeConfigInterface
     */
    public $scopeConfig;
    /**#@+
    * Constants defined
    */
    const IS_ACTIVE = 'paymenthide/general/active';
    const PAYMENT_METHODS = 'paymenthide/general/paymethods';

    /**
     * Available constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $subject
     * @param $result
     * @return mixed
     */
    public function afterGetAvailableMethods($subject, $result)
    {

        if (!$this->scopeConfig->getValue(self::IS_ACTIVE, ScopeInterface::SCOPE_STORE)) {
            return $result;
        }

        $methods = $this->scopeConfig->getValue(self::PAYMENT_METHODS, ScopeInterface::SCOPE_STORE);

        $methodsArray = explode(",", $methods);

        foreach ($result as $key => $_result) {
            if (in_array($_result->getCode(), $methodsArray)) {
                unset($result[$key]);
            }
        }
        return $result;
    }
}
