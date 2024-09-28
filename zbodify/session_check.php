<?php
// Oturum açılmamışsa
if (!isset($_SESSION['loggedin'])) {
    echo 'You directed to login page';
    header("Location: login.php"); // Giriş sayfasına yönlendir
    exit();
}
?>
