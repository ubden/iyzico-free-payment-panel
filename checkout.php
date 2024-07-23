<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'odeme-sayfasi/vendor/autoload.php';

use Iyzipay\Options;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Model\Currency;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\CheckoutFormInitialize;

$apiKey = 'IYZICO_LIVE_API_KEY';
$secretKey = 'IYZICO_SECRET_KEY';
$baseUrl = 'https://api.iyzipay.com';

// Formdan gelen verileri al
$amount = $_POST['amount'] ?? 0; // Formdan gelen ödeme miktarı, varsayılan olarak 0
$name = $_POST['name'] ?? '';
$surname = $_POST['surname'] ?? '';
$phone = $_POST['phone'] ?? '';

$options = new Options();
$options->setApiKey($apiKey);
$options->setSecretKey($secretKey);
$options->setBaseUrl($baseUrl);

$request = new CreateCheckoutFormInitializeRequest();
$request->setLocale(Locale::TR);
$request->setConversationId(uniqid()); // Örneğin, eşsiz bir işlem ID
$request->setPrice($amount);
$request->setPaidPrice($amount);
$request->setCurrency(Currency::TL);
$request->setBasketId(uniqid());
$request->setPaymentGroup(PaymentGroup::PRODUCT);
$request->setCallbackUrl("https://localhost/callback.php"); // Geri çağrı URL'si ayarlanmalıdır

// Buyer bilgilerini oluştur
$buyer = new Buyer();
$buyer->setId("RESELLER");
$buyer->setName($name);
$buyer->setSurname($surname);
$buyer->setGsmNumber("+9" . $phone);
$buyer->setEmail("sales@ubden.com");
$buyer->setIdentityNumber("8831146243");
$buyer->setLastLoginDate(date("Y-m-d H:i:s"));
$buyer->setRegistrationDate(date("Y-m-d H:i:s"));
$buyer->setRegistrationAddress("Maslak Mah, AOS 55. Sok. No 2 Sok. D:23");

// Kullanıcının IP adresini al
$buyer->setIp($_SERVER['REMOTE_ADDR']);

$buyer->setCity("Istanbul");
$buyer->setCountry("Turkey");
$buyer->setZipCode("34398");
$request->setBuyer($buyer);

// Shipping Address ve Billing Address olarak aynı bilgiyi kullanabilirsiniz
$address = new Address();
$address->setContactName($name . " " . $surname);
$address->setCity("Istanbul");
$address->setCountry("Turkey");
$address->setAddress("Maslak, Maslak Mah. AOS 55 Sok. No:2");
$address->setZipCode("34398");
$request->setShippingAddress($address);
$request->setBillingAddress($address);

// BasketItem'ları oluştur
$basketItems = array();

// Örnek bir ürün ekle
$firstBasketItem = new BasketItem();
$firstBasketItem->setId("DGP");
$firstBasketItem->setName("Digital Product");
$firstBasketItem->setCategory1("Digital");
$firstBasketItem->setCategory2("Digital");
$firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
$firstBasketItem->setPrice($amount);
$basketItems[] = $firstBasketItem;

$request->setBasketItems($basketItems);

$checkoutFormInitialize = CheckoutFormInitialize::create($request, $options);

if ($checkoutFormInitialize->getStatus() === 'success') {
    $checkoutFormContent = $checkoutFormInitialize->getCheckoutFormContent();
    echo $checkoutFormContent; // Bu içerik, ödeme formu URL'sini içerir ve kullanıcıyı iyzico ödeme sayfasına yönlendirir

    // Ödeme kimliğini almak için
    $odemeKimligi = $checkoutFormInitialize->getConversationId();
} else {
    echo "Ödeme formu oluşturulamadı. Hata: " . $checkoutFormInitialize->getErrorMessage();
}
?>
