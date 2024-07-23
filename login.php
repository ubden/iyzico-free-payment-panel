<?php
session_start();
// Veritabanı bağlantı bilgileri
$dbHost = 'localhost';
$dbUsername = 'root'; // Veritabanı kullanıcı adınıza göre değiştirin
$dbPassword = 'password'; // Veritabanı şifrenize göre değiştirin
$dbName = 'dbname'; // Veritabanı adınıza göre değiştirin

$db = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUsername, $dbPassword);

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $db->prepare("SELECT id, username, password FROM users WHERE username = :username");
    $query->execute([':username' => $username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        // Giriş başarılı, anasayfaya yönlendirilebilir
        header("Location: index.php"); // Başarıyla giriş yapıldıktan sonra yönlendirme
        exit;
    } else {
        $error_message = "Kullanıcı adı veya şifre hatalı!";
}
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <h2>Giriş Yap</h2>
    <form id="loginForm" method="post">
        <div class="input-group">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required>
        </div>
        
        <div class="input-group">
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <input type="submit" value="Giriş Yap">
        <p>Hesabınız yok mu? <a href="signup.php">Üye Ol</a></p>
        <?php
        if (isset($error_message)) {
             echo '<span style="color: red;">' . $error_message . '</span>';
        }
        ?>
    </form>
</div>

</body>
</html>