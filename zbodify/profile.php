<?php 
include("connect.php");
include("session_check.php");

$query_paying = "SELECT PAYmtype FROM PAYING WHERE PAYuserId = $_SESSION[user_id]";
$result = $conn->query($query_paying);
$user_id = $_SESSION['user_id'];


$query_playlist_count = "select * from User_Playlist_Count;";
$result_playlist_count = $conn->query($query_playlist_count);
$playlist_count = $result_playlist_count->fetch_assoc();





if($result->num_rows==0) {
    $_SESSION['mtype'] = "None";
} elseif ($query_paying = "Standard"){
    $_SESSION['mtype'] = "Standard";
} elseif($query_paying = "Premium") {
    $_SESSION['mtype'] = "Premium";
}

if(isset($_POST['delete_account'])) {
    $query_del_user = "delete from user where user_Id = $user_id";
    $conn->query($query_del_user);
    session_destroy();
    header("Location: login.php"); // Redirect to the login page
    exit;
}
if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    $query_listen_delete = "delete from listen";
    $conn->query($query_listen_delete);
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Profile Page</title>
</head>
<body>
<div class="topbar">

<div class="home">

  <a href="main.php" class="home-icon">

    <span class="fa fa-home">Home</span>

  </a>

</div>



<div class="navbar">

  <ul>

    <li>

      <a href="membership.php">Membership</a>

    </li>

    

   

    <li class="divider">|</li>

    <li>

      <a href="profile.php">Profile</a>

    </li>

  </ul>

 

</div>

</div>
    <div class="displaybox">
        <div class="song-rows">
            <div>
                <div class="song-columns">
                    
                    <div>
                        <h2>Username: <?php echo $_SESSION["username"] ?></h2>
                    </div>
                    <div class="check">
                        <h6>Membership Type: <?php echo $_SESSION['mtype'] ?></h6>
                         <h6>Playlist Count: <?php echo $playlist_count['Playlist_Count'] ?> </h6> 
                         <?php if(isset($_SESSION['ArtistId'])){
                            $query_album_count = "select * from Artist_Album_Count;";
                            $result_album_count = $conn->query($query_album_count);
                            $album_count = $result_album_count->fetch_assoc();
                            
                            ?>
                            <h6>Album Count: <?php echo $album_count['Album_Count'] ?> </h6> 
                         <?php } ?>
                    </div>
                    <div>
                        <!-- Form for account deletion -->
                        <form method="post">
                            <input type="hidden" name="delete_account" value="true">
                            <button type="submit">Delete Account</button>
                        </form>

                        <form method="post">
                            <input type="hidden" name="logout" value="true">
                            <button type="submit">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://kit.fontawesome.com/23cecef777.js" crossorigin="anonymous"></script>
</body>
</html>