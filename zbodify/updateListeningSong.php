<?php
include("connect.php");
include("session_check.php");

if(isset($_GET['song_id'])){
  $_SESSION['Song_Id'] =$_GET['song_id'];
}

?>