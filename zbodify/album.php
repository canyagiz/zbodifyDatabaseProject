<?php
include("connect.php");
include("session_check.php");
$user_id = $_SESSION['user_id'];
$albumId = $_GET['id'];

$query_delete_album = "delete from album
                       where Album_Id = $albumId";

if(isset($_POST['delete_album'])){
    $conn->query($query_delete_album);
    header("Location: main.php");
    exit();
}

$query_album = "SELECT * FROM ALBUM join artist on(AlartistId = Artist_Id) WHERE Album_Id = $albumId";
$query_contain = "SELECT * FROM Song JOIN album ON(SalbumId = Album_Id) WHERE Album_Id = $albumId";
$query_album_retriever = "select * from albumtotalduration";
$result_duration = $conn->query($query_album_retriever);
$row_duration = $result_duration->fetch_assoc();




$result = $conn->query($query_album);
$row = $result->fetch_assoc();
$resultContain = $conn->query($query_contain);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="albumpage.css">
    <title>Album Page</title>
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
                        <img src="<?php echo $row['AlImagePath'] ?>" alt="">
                    </div>
                    <div class="album-content">
                        <div>
                            <h2><?php echo $row['Alname']; ?></h2>
                        </div>
                        <div>
                            <h6>Album Genre: <?php echo $row['Algenre']; ?></h6>
                        </div>
                        <div>
                            <h6>Artist Name: <?php echo $row['Arname']; ?></h6>
                        </div>
                        <div>
                            <h6>Published Date: <?php echo $row['AlpublishDate'];  ?></h6>
                        </div>
                        <div>
                            <h6>Total Album Duration: <?php echo $row_duration['TotalDuration'] . " seconds"  ?></h6>
                        </div>

                        <form method="post">
                            <input type="hidden" name="delete_album" value="true">
                            <button type="submit">Delete Album</button>
                        </form>
                        
                      
                    </div> 
                </div>
            </div>
            <div>


            
                <h1>Songs In The Album</h1>
            </div>
            <div>
                <div class="albumlist-rows">
                    <?php while ($row = $resultContain->fetch_assoc()) { ?>
                        
                            <div class="albumlist-content">
                                <div class="content-columns">
                                    <div>
                                        <h3>Song Name: <?php echo $row['Sname'] ?></h3>
                                    </div>
                                    <div>
                                        <h6>Duration: <?php echo $row['Sduration'] ?>s</h6>
                                    </div>
                                    <div>
                                        <div class="play-buttons">
                                    <a href="play.php?song=<?php echo $row['Song_Id'] ?>">Play</a>
                                    </div>
                        </div>
                                </div>
                            </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script
    src="https://kit.fontawesome.com/23cecef777.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>
