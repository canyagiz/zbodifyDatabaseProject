<?php
include("connect.php");
include("session_check.php");

$query_album_retriever = "SELECT * FROM album JOIN artist ON(Artist_Id = AlartistId)";
$result = $conn->query($query_album_retriever);
if(isset($_SESSION['ArtistId'])){
  $ArtistId = $_SESSION['ArtistId'];}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./main.css">
  <title>Zbodify Home Page</title>
</head>

</html>
<body>

  <div class="sidebar">
    <div class="logo">
      <a href="#">
        <img src="./img/zbodifyLogo.jpeg" alt="Logo" />
      </a>
    </div>

    <div class="navigation">
      <ul>
        <li>
          <a href="main.php">
            <span class="fa fa-home"></span>
            <span>Home</span>
          </a>
        </li>

        <li>
          <a href="playlists.php">
            <span class="fa fa-search"></span>
            <span>Playlists</span>
          </a>
        </li>

        <li>
          <a href="createPlaylist.php">

            <span class="fa fas fa-plus-square"></span>
            <span>Create Playlist</span>
          </a>
        </li>
      </ul>
    </div>

    <div class="navigation">
      <ul>
        <li>
          <?php if(!empty($ArtistId)){ ?>
            <a href="publishAlbum.php">
              <span class="fa fas fa-book"></span>
              <span>Publish Album </span>
            </a>
          <?php } ?>
        </li>
      </ul>
    </div>
  </div>

  <div class="main-container">
    <div class="topbar">
      <div class="prev-next-buttons">
        <button type="button" class="fa fas fa-chevron-left" ></button>
        <button type="button" class="fa fas fa-chevron-right"></button>
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

    <div class="spotify-playlists">
      <h2> Albums</h2>

      <div class="list">
        <?php while ($row = $result->fetch_assoc()){ ?>
          <a href="album.php?id=<?php echo $row['Album_Id'];?>">
            <div class="item">
              <img src="<?php echo $row['AlImagePath'];?>" alt="">
                            <div class="play">
                <span class="fa fa-play"></span>
              </div>
              <h4><?php echo $row['Alname']; ?></h4>
              <p> Artist: <?php echo $row['Arname']; ?> | Genre: <?php echo $row['Algenre']; ?> | Published Date: <?php echo $row['AlpublishDate'];  ?></p>
            </div>
          </a>
        <?php } ?> 
      </div>

      <div class="music-player">
        <div class="text">
          <?php
            include "current_music.php";
          ?>
          
        </div>
      </div>
    </div>



  </div>

  <script src="https://kit.fontawesome.com/23cecef777.js" crossorigin="anonymous"></script>
</body>
</html>
