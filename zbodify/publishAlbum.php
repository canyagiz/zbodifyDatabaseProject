<?php
include("connect.php");
include("session_check.php");
$error = "noerr";
$Artist_Id = $_SESSION["ArtistId"];
echo $Artist_Id;
$date = date('Y-m-d');

// Sign In
if (isset($_POST['publish_album'])) {
    $album_name = $_POST['album_name'];
    $album_genre = $_POST['album_genre'];
    $album_image_path = "./albumImagePath/" . $_POST['album_image_path'];
    
    if ($album_name == '') {
        $error = 'Album name must be entered to publish album.';
    }
        
    if ($error !== "noerr") {
        echo "<p>$error</p>";
    } else {
        $insert_al_query = "INSERT INTO Album (AlartistId, Alname, Algenre, AlpublishDate, AlImagePath) 
                            VALUES ('$Artist_Id','$album_name', '$album_genre', '$date','$album_image_path')";
                            
        if ($conn->query($insert_al_query) === TRUE) {
            // Retrieve the ID of the newly created playlist
            $album_id = $conn->insert_id;
            // Redirect to songToPlaylist.php with playlist ID as a query parameter
            header("Location: songToAlbum.php?id=$album_id");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
} elseif (isset($_POST['backMain'])) {
    header("Location: main.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="createPlaylist.css">
    <title>Create Playlist Page</title>
</head>
<body>
    
    <input type="radio" name="optionScreen" id="SignIn" hidden checked>
   

        <section>
            <div id="logo"> 
            </div>

        <nav>
            <label for="SignIn">Create Album</label>
            
        </nav>
        <form action="publishAlbum.php" id="SignInFormData" method="post">
            <input type="text" name="album_name" id="album_name" placeholder="Album Name">
            <input type="text" name="album_genre" id="album_genre" placeholder="Album Genre">
            <input type="text" name="album_image_path" id="album_image" placeholder="Album Image Path">
            <button type="submit" name= "publish_album" href="publishAlbum.php" title="Album publishing">Publish</b>
            <button type="submit" name= "backMain" href="main.php" title="Main Menu">Home</b>
        </form>
        
    </section>
    <script
    src="https://kit.fontawesome.com/23cecef777.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>