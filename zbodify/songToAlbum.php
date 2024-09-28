<?php
include("connect.php");
include("session_check.php");


if(isset($_GET['id'])){
    $albumid = $_GET['id'];

}

// Şarkıları albüme ekle
if (isset($_POST['add_song'])) {
    $song_name = $_POST['song_name'];
    $song_duration = $_POST['song_duration'];
    $song_file_path = "./songPath/" . $_POST['song_file_path']; // Düzgün dosya yolu
    $song_image_path = "./songImagePath/" . $_POST['song_image_path']; // Düzgün dosya yolu

    // Şarkı bilgilerini veritabanına ekle
    $insert_song_query = "INSERT INTO SONG (Sname, Sduration, SalbumId, SongPath, SongImagePath) 
                          VALUES ('$song_name', '$song_duration', '$albumid', '$song_file_path', '$song_image_path');";
                          
    if ($conn->query($insert_song_query) === TRUE) {
        echo "Song added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
} 
?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="songToAlbum.css">

    <title>Zbodify Login Page</title>

</head>

<body>

    <input type="radio" name="optionScreen" id="SignIn" hidden checked>

    <input type="radio" name="optionScreen" id="SignUp" hidden>



    <section>

        <div id="logo">

            

            <h1>Add Songs To Album</h1>

        </div>



        <nav>

            <label for="SignIn">Sign In</label>



        <form action="songToAlbum.php?id=<?php echo $albumid ?>" id="SignInFormData" method="post">

        <input type="text" name="song_name" placeholder="Song Name" required><br>

        <input type="number" name="song_duration" placeholder="Song Duration (in seconds)" required><br>

        <input type="text" name="song_file_path" placeholder="Song File Path" required><br>

        <input type="text" name="song_image_path" placeholder="Song Image Path" required><br>

        <button type="submit" name="add_song">Add Song</button>
        

        </form>



        

        </section>



    <script src="https://kit.fontawesome.com/23cecef777.js" crossorigin="anonymous"></script>

</body>

</html>