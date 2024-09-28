<?php
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
if (isset($_POST['hasinput']) && $_POST['hasinput'] == "1") {
    $username = $_POST['username'];
    $Umail = $_POST['Umail'];
    $Upassword = $_POST['Upassword'];
    $sql = "INSERT INTO USER (username, Umail, Upassword) VALUES ('$username', '$Umail', '$Upassword')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


    <form action="user.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="Umail" placeholder="Password">
        <input type="password" name="Upassword" placeholder="Password">
        <input style="display:none;" type="text" name="hasinput"value="1">
        <button type="submit">Submit</button>
    </form>
</body>
</html>