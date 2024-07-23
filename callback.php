<?php
require 'odeme-sayfasi/vendor/autoload.php';

use Iyzipay\Options;
use Iyzipay\Request\RetrieveCheckoutFormRequest;
use Iyzipay\Model\CheckoutForm;

$apiKey = 'IYZICO_LIVE_API_KEY';
$secretKey = 'IYZICO_SECRET_KEY';
$baseUrl = 'https://api.iyzipay.com';

$options = new Options();
$options->setApiKey($apiKey);
$options->setSecretKey($secretKey);
$options->setBaseUrl($baseUrl);

$request = new RetrieveCheckoutFormRequest();
$request->setToken($_POST['token']);

$checkoutForm = CheckoutForm::retrieve($request, $options);
$status = $checkoutForm->getStatus();
$paymentId = $checkoutForm->getPaymentId();
$errorMessage = $checkoutForm->getErrorMessage();
$amount = $checkoutForm->getPrice();

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödeme Sonucu</title>
    <link rel="stylesheet" href="callback-style.css">
</head>
<body>
<div class="result-container">
    <?php if ($status == 'success'): ?>
        <div class="result success">
            <i class="icon">&#10004;</i>
            <h2>Ödeme Başarılı!</h2>
            <p>Ödeme Tutarı: <strong><?php echo number_format($amount, 2, ',', '.'); ?> TL</strong></p>
            <p>Ödeme ID: <strong><?php echo $paymentId; ?></strong></p>
        </div>
    <?php else: ?>
        <div class="result error">
            <i class="icon">&#10060;</i>
            <h2>Ödeme Başarısız!</h2>
            <p>Hata: <strong><?php echo $errorMessage; ?></strong></p>
        </div>
    <?php endif; ?>
    <button onclick="window.print()" class="btn">Yazdır</button>
    <button onclick="window.location.href='index.php'" class="btn">Yeniden Ödeme Yap</button>
</div>
<script src="callback-script.js"></script>
</body>
</html>
