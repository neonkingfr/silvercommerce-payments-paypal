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

    