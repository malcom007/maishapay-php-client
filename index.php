<?php
/**
 *   This file is part of the maishapay-php-client
 * 
 *   @copyright   Bernard ngandu <ngandubernard@gmail.com>
 *   @link    https://github.com/bernard-ng/maishapay-php-client
 *
 *   For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 */

require("vendor/autoload.php");

$apikey = "kdfkdjffdkjfkasdjfakdfadfdfdfd";
$config = [
    "gateway_mode" => 0,
    "payment_devise" => "USD",
    "payment_description" => "love",
    "payment_amount" => "360",
    "apiOptions" => "127.0.0.1",
    "page_callback_success" => "http://location.com/success",
    "page_callback_failure" => "http://location.com/faillure",
    "page_callback_cancel" => "http:://location.com/cancel"
];

try {
    $maishapay = new Ng\Maishapay\Client($apikey);
    $redirectUrl = $maishapay->getRedirectUrl($config);
    echo $redirectUrl;
} catch(\Exception $e) {
    echo sprintf("Opus something went wrong => %s", $e->getMessage());
}