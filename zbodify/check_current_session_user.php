<?php
include("connect.php");
include("session_check.php");
echo " email:";
echo $_SESSION["email"];
echo " Username: ";
echo $_SESSION["username"]; 
echo " User_id: ";
echo $_SESSION["user_id"];
echo " password: ";
echo $_SESSION["password"]; 
echo " ArtistId: ";
echo $_SESSION["ArtistId"]; 
echo " Song_id: ";
echo $_SESSION["current"];
?>