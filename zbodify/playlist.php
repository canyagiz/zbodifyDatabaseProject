<?php
include("connect.php");
include("session_check.php");
$user_id = $_SESSION['user_id'];
$playlistId = $_GET['id'];

$query_playlist ="SELECT * FROM PLAYLIST WHERE Playlist_Id = $playlistId";

$query_contain ="SELECT * FROM CONTAIN JOIN SONG ON(CONSong_Id = Song_Id) where CONPl_Id = $playlistId";
$query_delete_playlist = "delete from playlist
                       where Playlist_Id = $playlistId";

if(isset($_POST['delete_playlist'])){
    $conn->query($query_delete_playlist);
    header("Location: main.php");
    exit();
}


$result_playlist = $conn->query($query_playlist);
$row_playlist = $result_playlist->fetch_assoc();
$resultContain_songs = $conn->query($query_contain);
$query_playlist_retriever = "select * from PlaylistTotalDuration where CONPl_Id = $playlistId";
$result_playlist_retriever = $conn->query($query_playlist_retriever);
$row_playlist_retriever = $result_playlist_retriever->fetch_assoc();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="songpage.css">
    <title>Album Page</title>
</head>
<body>
    <div class="navigationbar">
        <div class="navigationdiv">
            <div class="logo"><a href="main.php">Home</a></div>
            <ul>
                <button><a href="membership.php">Membership</a></button>
                <button><a href="profile.php">Profile</a></button>
            </ul>
        </div>
    </div>
    <div class="displaybox">
        <div class="song-rows">
            <div>
                <div class="song-columns">
                    <div>
                        <img src="<?php echo $row_playlist['PlImagePath']  ?>" alt="">
                    </div>
                    <div class="album-content">
                        <div>
                            <h2>Playlist Name: <?php echo $row_playlist['Plname']  ?></h2>
                        </div>
                        <div>
                            <h6>Playlist Description: <?php echo $row_playlist['Pldescription']  ?></h6>
                        </div>
                        <div>
                            <h6>Playlist Duration: <?php echo $row_playlist_retriever['TotalDuration']  ?></h6>
                        </div>

                        <form method="post">
                            <input type="hidden" name="delete_playlist" value="true">
                            <button type="submit">Delete Playlist</button>
                        </form>

                        <form action="songToPlaylist.php?id=<?php echo $playlistId ?>" method="post">
                        <input type="hidden" name="add_song_to_playlist" value="true">
                            <button type="submit">Add Song</button>
                        </form>
                    </div>
                </div>
            </div>
            <div>


                <h1>Songs In The playlist</h1>
            </div>
            <div>
                <div class="albumlist-rows">
                    <?php while ($row = $resultContain_songs->fetch_assoc()) { ?>
                        
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
</body>
</html>

