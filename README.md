# SilverCommerce Paypal Payments

Package that adds PayPal payments (via omnipay) along with some customisations

Mostly this just installs the required PayPal omnipay package, but it also fixes the redirect issue where PayPal
payments can be identified as "paid" even when they are rejected.

Hopefully this package will also be upgraded at some point to allow adding an "Express Checkout" button to the begining
of the checkout process.

## Installation

Install via composer:

    composer require silvercommerce/payments-paypal

## Configuration

Configure how you would any SilverStripe omnipay modules:

_payments.yml_

    ---
    Name: paymentconfig
    ---
    SilverStripe\Omnipay\Model\Payment:
      allowed_gateways:
        - 'PayPal_Express'

    SilverStripe\Omnipay\GatewayInfo:
      PayPal_Express:
        parameters:
          username: 'paypal_api_username'
          password: 'paypal_api_password'
          signature: 'paypal_api_signiature'

    # Config for test environments
    ---
    Except:
    environment: 'live'
    ---
    SilverStripe\Omnipay\GatewayInfo:
      PayPal_Express:
        parameters:
          username: 'test_paypal_api_username'
          password: 'test_paypal_api_password'
          signature: 'test_paypal_api_signiature'
          testMode: true


Alternativley, load the PayPal API credentials via environmental variables:

_.env_

    PAYPAL_API_USERNAME="test_paypal_api_username"
    PAYPAL_API_PASSWORD="test_paypal_api_password"
    PAYPAL_API_SIGNATURE="test_paypal_api_signiature"

_payments.yml_

    ---
    Name: paymentconfig
    ---
    SilverStripe\Omnipay\Model\Payment:
      allowed_gateways:
        - 'PayPal_Express'

    SilverStripe\Omnipay\GatewayInfo:
      PayPal_Express:
        parameters:
          username: '`PAYPAL_API_USERNAME`'
          password: '`PAYPAL_API_PASSWORD`'
          signature: '`PAYPAL_API_SIGNATURE`'