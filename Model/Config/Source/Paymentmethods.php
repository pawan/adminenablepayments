<?php

namespace Pawan\AdminEnablePayments\Model\Config\Source;

use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Payment\Model\Config;

class Paymentmethods implements \Magento\Framework\Option\ArrayInterface
{
    public $appConfigScopeConfigInterface;

    public $paymentModelConfig;

    public function __construct(
        ScopeConfigInterface $appConfigScopeConfigInterface,
        Config $paymentModelConfig
    ) {
    
        $this->appConfigScopeConfigInterface = $appConfigScopeConfigInterface;
        $this->paymentModelConfig = $paymentModelConfig;
    }

    public function toOptionArray()
    {
        $payments = $this->paymentModelConfig->getActiveMethods();
        $methods = [];
        foreach ($payments as $paymentCode => $paymentModel) {
            $paymentTitle = $this->appConfigScopeConfigInterface->getValue('payment/'.$paymentCode.'/title');
            $methods[$paymentCode] = [
            'label' => $paymentTitle,
            'value' => $paymentCode
            ];
        }
        return $methods;
    }
}
