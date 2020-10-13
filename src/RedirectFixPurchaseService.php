<?php

namespace SilverCommerce\Payments\PayPal;

use Omnipay\Common\Message\AbstractResponse;
use SilverStripe\Omnipay\Helper\ErrorHandling;
use SilverStripe\Omnipay\Service\PurchaseService;
use SilverStripe\Omnipay\Service\ServiceResponse;
use Omnipay\PayPal\ExpressGateway as PayPalExpressGateway;

class RedirectFixPurchaseService extends PurchaseService
{
    /**
     * If gateway is paypal express and it returns a redirect response with a failier
     * then mark as pending capture (rather than captured)
     *
     * @param string $endStatus
     * @param ServiceResponse $serviceResponse
     * @param AbstractResponse $gatewayMessage
     */
    protected function markCompleted($endStatus, ServiceResponse $serviceResponse, $gatewayMessage)
    {
        $gateway = $this->oGateway();
        $data = $gatewayMessage->getData();

        if (is_a($gateway, PayPalExpressGateway::class)
            && $serviceResponse->isRedirect()
            && isset($data['ACK'])
            && $data['ACK'] == 'Failure'
        ) {
            $this->payment->Status = 'PendingCapture';
            $this->createMessage('PurchasedResponse', $gatewayMessage);
            ErrorHandling::safeExtend($this->payment, 'onAwaitingCaptured', $serviceResponse);
            return;
        }

        parent::markCompleted($endStatus, $serviceResponse, $gatewayMessage);
    }
}