<?php
include("connect.php");
include("session_check.php");
$error = "noerr";

// Sign In
if (isset($_POST['createPl'])) {
    $playlist_name = $_POST['playlist_name'];
    $playlist_description = $_POST['playlist_description'];
    $playlist_image_path = "./playlistImagePath/". $_POST['playlist_image_path'];
    
    
    if ($playlist_name == '') {
        $error = 'Playlist name must be entered to create playlist.';
    }
        
    if ($error !== "noerr") {
        echo "<p>$error</p>";
    } else {
        $insert_pl_query = "INSERT INTO PLAYLIST (Plname, Pldescription, PluserId, PlImagePath) 
                            VALUES ('$playlist_name', '$playlist_description', '$_SESSION[user_id]', '$playlist_image_path')";
                            
        if ($conn->query($insert_pl_query) === TRUE) {
            // Retrieve the ID of the newly created playlist
            $playlist_id = $conn->insert_id;
            // Redirect to songToPlaylist.php with playlist ID as a query parameter
            header("Location: songToPlaylist.php?id=$playlist_id");
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
            <label for="SignIn">Create Playlist</label>
            
        </nav>
        <form action="createPlaylist.php" id="SignInFormData" method="post">
            <input type="text" name="playlist_name" id="playlist_name" placeholder="Playlist Name">
            <input type="text" name="playlist_description" id="playlist_description" placeholder="Playlist Description">
            <input type="text" name="playlist_image_path" id="album_image" placeholder="Playlist Image Path">
            <button type="submit" name= "createPl" href="main.php" title="Sign In">Create</b>
            <button type="submit" name= "backMain" href="main.php" title="Main Menu">Home</b>
            
        </form>
        
    </section>
    <script
    src="https://kit.fontawesome.com/23cecef777.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>