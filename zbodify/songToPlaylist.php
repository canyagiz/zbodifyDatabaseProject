<?php
include("connect.php");
include("session_check.php");

// Check if playlist_id is set and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $playlist_id = $_GET['id'];
} else {
    // Handle the error if playlist_id is not set or invalid
    die("Invalid playlist ID.");
}

// Şarkı verilerini çekme
$sql = "SELECT Song_Id, Sname, Sduration, SongPath, SongImagePath FROM SONG";
$result = $conn->query($sql);

$songs = array();
if ($result->num_rows > 0) {
    // Verileri diziye ekle
    while($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
} else {
    echo "0 results";
}

// Form gönderildiğinde işleme
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (!empty($_POST['songs'])) {
        $selected_songs = $_POST['songs']; // selected songs array = songs

        foreach ($selected_songs as $song_id) {
            // Aynı şarkının playlist'e zaten eklenmiş olup olmadığını kontrol et
            $check_sql = "SELECT * FROM CONTAIN WHERE CONPl_Id = $playlist_id AND CONSong_Id = $song_id";
            $check_result = $conn->query($check_sql);

            if ($check_result->num_rows == 0) {
                // Şarkı eklenmemişse ekle
                $insert_sql = "INSERT INTO CONTAIN (CONPl_Id, CONSong_Id) VALUES ($playlist_id, $song_id)";
                if ($conn->query($insert_sql) === TRUE) {
                    echo "Şarkı başarıyla eklendi: " . $song_id . "<br>";
                    header("main.php");
                } else {
                    echo "Hata: " . $insert_sql . "<br>" . $conn->error;
                }
            } else {
                echo "Şarkı zaten ekli: " . $song_id . "<br>";
            }
        }
    } else {
        echo "Lütfen en az bir şarkı seçin.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>The Songs Valid In Zbodify</title>
    <link rel="stylesheet" type="text/css" href="songToPlaylist.css">
</head>
<body>
    <h1>Şarkı Listesi</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $playlist_id; ?>">
        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Song</th>
                    <th>Duration (sn)</th>
                    <th>Path of mp3</th>
                    <th>Path of image</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($songs as $song): ?>
                <tr>
                    <td><input type="checkbox" name="songs[]" value="<?php echo $song['Song_Id']; ?>"></td>
                    <td><?php echo $song['Sname']; ?></td>
                    <td><?php echo $song['Sduration']; ?></td>
                    <td><?php echo $song['SongPath']; ?></td>
                    <td><?php echo $song['SongImagePath']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" name="submit">Add songs to playlist</button>
    </form>
</body>
</html>
