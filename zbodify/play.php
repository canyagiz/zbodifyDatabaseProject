<?php
include("connect.php");
$user_id = $_SESSION['user_id'];
if (isset($_GET["song"])){
    $_SESSION['current']=$_GET["song"];
}
$query_listen = "select * from listen";
$result_query_listen = $conn->query($query_listen);


$currentSong = $_SESSION['current']; 
if ($result_query_listen->num_rows == 0){
    $query_insert_listen = "INSERT INTO LISTEN (LuserId, LsongId)
                            VALUES ('$user_id','$currentSong')";
 if($conn->query($query_insert_listen)){
    header("Location: main.php");
 }
 else{
    echo "Error: " . $conn->error;
 }

} elseif($result_query_listen->num_rows > 0){
 $query_update_listen = "UPDATE LISTEN
                         SET LuserId = '$user_id',
                             LSongId = '$currentSong'
                        WHERE LuserId = '$user_id'";

if($conn->query($query_update_listen)){
    header("Location: main.php");
 }
 else{
    echo "Error: " . $conn->error;
 }
        
}


    
?>