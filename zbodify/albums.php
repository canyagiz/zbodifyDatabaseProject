<?php
include("connect.php");
include("session_check.php");

$query_playlist ="SELECT * FROM PLAYLIST WHERE PluserId = $user_id";

$result = $conn->query($query_playlist);
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
        <img src="./img/Logo-DarkS.png" alt="Logo" />
       
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
          <a href="publishalbum.php">
            <span class="fa fas fa-book"></span>
            <span>Publish Album </span>
          </a>
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
            <a href="#">Profile</a>
          </li>
        </ul>
       
      </div>
    </div>

    <div class="spotify-playlists">
      <h2> Playlists</h2>

      <div class="list">
        
      <?php
      
      while ($row = $result->fetch_assoc()){
        ?>
      <a href="playlist.php?id=<?php echo $row['Playlist_Id']?>">
      <div class="item">
          <img src="https://i.scdn.co/image/ab67616d0000b2733b5e11ca1b063583df9492db" />
          <div class="play">
            <span class="fa fa-play"></span>
          </div>
          <h4><?php echo $row['Plname']?></h4>
          <p><?php $row['Pldescription'] ?></p>
        </div>
        </a>
      
      <?php } ?>

      

        
    </div>

   

   

    <div class="music-player">
      <div class="text">
        <h6>Music Player</h6>
        
      </div>
      
    </div>
  </div>

  <script
    src="https://kit.fontawesome.com/23cecef777.js"
    crossorigin="anonymous"
  ></script>
</body>