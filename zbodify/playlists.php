<?php
include("connect.php");
include("session_check.php");
$user_id = $_SESSION['user_id'];


$query_playlist ="SELECT * FROM PLAYLIST JOIN USER ON (PLuserId = User_Id) WHERE PluserId = $user_id";
$result_playlists = $conn->query($query_playlist);





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
          <a href="createplaylist.php">
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
        <button type="button" class="fa fas fa-chevron-left"></button>
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
      <h2>Playlists</h2>

      <div class="list">
        <?php while ($row_playlists = $result_playlists->fetch_assoc()){ ?>
          <a href="playlist.php?id=<?php echo $row_playlists['Playlist_Id'];?>">
            <div class="item">
              <img src="<?php echo $row_playlists['PlImagePath'];?>" alt="">
                            <div class="play">
                <span class="fa fa-play"></span>
              </div>
              <h4><?php echo $row_playlists['Plname']; ?></h4>
              <p> User: <?php echo $row_playlists['username']; ?> | Description: <?php echo $row_playlists['Pldescription']; ?> </p>
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

  <script
    src="https://kit.fontawesome.com/23cecef777.js"
    crossorigin="anonymous"
  ></script>
</body>