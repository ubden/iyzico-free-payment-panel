<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Kullanıcı girişi yapılmadıysa, giriş sayfasına yönlendir
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayi Ödeme Formu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="payment-form">
    <h2>Online Ödeme Formu</h2>
    <form id="paymentForm" action="checkout.php" method="post">
        <label for="amount">Ödeme Miktarı:</label>
        <div class="input-group">
            <input type="number" id="amount" name="amount" min="0" step="0.01" placeholder="Ödeme miktarını girin" required>
        </div><br><br>
        
        <label for="name">İsim:</label>
        <input type="text" id="name" name="name" placeholder="İsim" required><br><br>
        
        <label for="surname">Soyisim:</label>
        <input type="text" id="surname" name="surname" placeholder="Soyisim" required><br><br>
        
        <label for="phone">Telefon Numarası:</label>
        <input type="tel" id="phone" name="phone" placeholder="05XXXXXXXXXX" required><br><br>
        
        <input type="submit" value="Ödemeyi Yap">
    </form>
    <div id="message" class="hidden"></div>
</div>

<script src="script.js"></script>
</body>
</html>