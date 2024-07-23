<?php
// Veritabanı bağlantı bilgileri
$dbHost = 'localhost';
$dbUsername = 'root'; // Veritabanı kullanıcı adınıza göre değiştirin
$dbPassword = 'password'; // Veritabanı şifrenize göre değiştirin
$dbName = 'dbname'; // Veritabanı adınıza göre değiştirin

$db = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUsername, $dbPassword);

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $result = $query->execute([':username' => $username, ':password' =>$password]);

    if ($result) {
        // Kayıt başarıyla tamamlandı, kullanıcıyı giriş sayfasına yönlendir
        header("Location: login.php");
        exit;
    } else {
        $error_message = "Kayıt sırasında bir hata meydana geldi!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üye Ol</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <h2>Üye Ol</h2>
    <form id="signupForm" method="post">
        <div class="input-group">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required>
        </div>
        
        <div class="input-group">
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <input type="submit" value="Üye Ol">
        <p>Zaten hesabınız var mı? <a href="login.php">Giriş Yap</a></p>
    </form>
</div>

</body>
</html>