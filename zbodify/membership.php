<?php
include("connect.php");
include("session_check.php");
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./membership.css">
  <title>Membership Page</title>
</head>
<body>
  
</body>
</html>
<body>
  <div class="topbar">
    <div class="home">
      <a href="main.php" class="home-icon">
        <span class="fa fa-home">Home</span>
      </a>
    </div>

    <div class="navbar">
      <ul>
        <li>
          <a href="membership.php">Membership</a>
        </li>
        
       
        <li class="divider">|</li>
        <li>
          <a href="profile.php">Profile</a>
        </li>
      </ul>
     
    </div>
  </div>
  <section id="membership-types" class="text-center py-2">
    <div class="container">
        <h1>Membership Types</h1>
        <div class="bottom-line"></div>
        <div class="specials">
            <div class="type-1">
                <h2>TYPE-1</h2>
                <p>Price: 5$</ph>
                <p>Being member cost</p>
                <a type="button" href="membership-type1.php"  title="Select">Select</a>
            </div>
            <div class="type-2">
                
                <h2>TYPE-2</h2>
                <p>Price: 10$</p>
                <p>Extra 5 dolar for donation</p>
                <a type="button" href="membership-type2.php" title="Select">Select</a>
            </div>
            
           
        </div>
        
    </div>
</section>
      <script
    src="https://kit.fontawesome.com/23cecef777.js"
    crossorigin="anonymous"
  ></script>
</body>
