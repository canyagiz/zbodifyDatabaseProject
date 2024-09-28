<?php
include("connect.php");

// Oturum kontrolü
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['loggedin'])) {
    if (basename($_SERVER['PHP_SELF']) != 'login.php') {
        // Oturum açılmamışsa ve mevcut sayfa login.php değilse kullanıcı login sayfasına yönlendiriliyor
        header("Location: login.php");
        exit();
    }
}

// Sign In
if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Kullanıcıyı kontrol et
    $check_query = "SELECT * FROM user WHERE BINARY Umail='$email' AND BINARY Upassword='$password' LIMIT 1";
    $result = $conn->query($check_query);

    if ($result->num_rows == 1) {
        // Kullanıcı bulunduğunda, kullanıcı verilerini oturumda sakla
        $user = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['User_Id']; // Kullanıcı ID'si
        $_SESSION['username'] = $user['username']; // Kullanıcı adı
        $_SESSION['email'] = $user['Umail']; // Kullanıcı e-posta
        $_SESSION['password'] = $user['Upassword'];

        // Sanatçı olup olmadığını kontrol et
        $query_arUserId = "SELECT * FROM ARTIST WHERE ArUserId = {$user['User_Id']} LIMIT 1";
        $result_arUserId = $conn->query($query_arUserId);
        
        if ($result_arUserId->num_rows == 1) {
            $artist = $result_arUserId->fetch_assoc();
            $_SESSION["ArtistId"] = $artist['Artist_Id'];
        }

        header("Location: main.php");
        exit();
    } else {
        echo "Invalid email or password";
    }
}





// Sign Up
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // İstek artist olarak gelirse
    if (isset($_POST['is_artist'])) {
        $artist_style = $_POST['artist_style'];
        $artist_country = $_POST['artist_country'];

        $check_query = "SELECT * FROM USER WHERE BINARY Umail='$email' LIMIT 1";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            echo "User already exists";
        } else {
            $insert_USER_query = "INSERT INTO USER (Username, Umail, Upassword) VALUES ('$username', '$email', '$password')";
            if ($conn->query($insert_USER_query) === TRUE) {
                // Eklenen satırın User_Id değerini al
                $user_id = $conn->insert_id;
                $insert_ARTIST_query = "INSERT INTO Artist (ArUserId, Arname, Arstyle, Arcountry) VALUES ('$user_id', '$username', '$artist_style', '$artist_country')";
                if ($conn->query($insert_ARTIST_query) === TRUE) {
                    $artist_id = $conn->insert_id;
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION["ArtistId"] = $artist_id;
                    header("Location: login.php");
                    exit();
                }
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        // İstek sadece kullanıcı olarak gelirse
        $check_query = "SELECT * FROM USER WHERE BINARY Umail='$email' LIMIT 1";
        $result = $conn->query($check_query);
        if ($result->num_rows > 0) {
            echo "User already exists";
        } else {
            $insert_query = "INSERT INTO USER (Username, Umail, Upassword) VALUES ('$username', '$email', '$password')";
            if ($conn->query($insert_query) === TRUE) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $conn->insert_id; // Kullanıcı ID'si oturuma ekleniyor
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                header("Location: login.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Zbodify Login Page</title>
</head>
<body>
    <input type="radio" name="optionScreen" id="SignIn" hidden checked>
    <input type="radio" name="optionScreen" id="SignUp" hidden>

    <section>
        <div id="logo">
            <img src="./img/zbodifyLoginLogo.jpeg">
            <h1>Zbodify</h1>
        </div>

        <nav>
            <label for="SignIn">Sign In</label>
            <label for="SignUp">Sign Up </label>
        </nav>

        <form action="login.php" id="SignInFormData" method="post">
            <input type="text" name="email" id="email" placeholder="Email">
            <input type="password" name="password" id="password" placeholder="Password">
            <button type="submit" name="signin" title="Sign In">Sign In</button>
        </form>

        <form action="login.php" id="SignUpFormData" method="post">
            <input type="text" name="username" id="Username" placeholder="Enter Username">
            <input type="email" name="email" id="Umail" placeholder="Enter E-Mail">
            <input type="password" name="password" id="Upassword" placeholder="Enter Password">
            <label><input type="checkbox" id="is_artist" name="is_artist">Are you artist?</label>
            <div id="extra_inputs"></div>
            <button type="submit" name="signup" title="Sign Up">Sign Up</button>
        </form>

        <script>
            document.getElementById('is_artist').addEventListener('change', function() {
                var extraInputs = document.getElementById('extra_inputs');
                if (this.checked) {
                    extraInputs.innerHTML = '<input type="text" name="artist_style" placeholder="Artist Style"><input type="text" name="artist_country" placeholder="Artist Country">';
                } else {
                    extraInputs.innerHTML = '';
                }
            });
        </script>
    </section>

    <script src="https://kit.fontawesome.com/23cecef777.js" crossorigin="anonymous"></script>
</body>
</html>