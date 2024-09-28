<?php

$currentID = isset($_SESSION['current']) ? $_SESSION['current'] : 1;

$sql = "SELECT * FROM SONG JOIN ALBUM ON SalbumId = Album_ID JOIN ARTIST ON AlartistId = Artist_Id WHERE Song_Id = $currentID LIMIT 1";
$result = $conn->query($sql);

$song = $result->fetch_assoc();

$query_last_listened = "select * from last_listened";
$result_last_listened = $conn->query($query_last_listened);
$row_last_listened = $result_last_listened->fetch_assoc();
$songId_last_listened = $row_last_listened["LastSongId"];



?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="musicplayer.css">
  </head>

  <body>
  <div class="grid1">
  

<div class="grid1">
    <div>
        <img src="<?php echo $song['SongImagePath']; ?>">
            </div>
            <div class="grid-links">
              <li> <a href="song.php?id=<?php echo $currentID; ?>">Song Name:
        <?php echo $song["Sname"]; ?>
               </a>
                </li>
              <li><a href="album.php?id=<?php echo $song['SalbumId']?>"> Album Name:
              <?php
              echo $song["Alname"];
              ?>
              </a>
              <li><a href="index.html">Artist Name:<?php
              echo $song["Arname"];
              ?>
              </a>
            </div>
            <div></div>
            
            <div>
              <div class="prev-button">
              <a href="play.php?song=<?php echo $songId_last_listened ?>">
              <span class="fa fa-backward"></span>
              </a>
              </div>
            </div>
            <div>
            <audio controls autoplay src="<?php echo $song["SongPath"]; ?>"></audio>
            </div>
            
</div>

</body>


</html>
