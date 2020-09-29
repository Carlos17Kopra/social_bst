<?php
//Config implementieren
require "../_conf/config.php";


//HTML und die Links ausgeben
?>
<head>

    <meta charset="utf-8">
    <title>SocialBST</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../_conf/system/css/style.css" >
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">
    <script src="../_conf/system/js/scripts/header.js" defer></script>
</head>
    <nav>
      <div class="logo">
        SocialBST
      </div>
<input type="checkbox" id="click">
      <label for="click" class="menu-btn">
        <i class="fas fa-bars"></i>
      </label>
      <ul>
<li><a href="index.php">Home</a></li>
<li><a href="#">Posts</a></li>
          <?php
            if(isset($_SESSION[session_id])){
                echo "<li><a href='account.php'>Account</a></li>";
            }else{
                echo "<li><a href='login.php'>Account</a></li>";
            }
          ?>
<li><i id="search_open_btn" class="fas fa-chevron-down"></i></li>
</ul>
</nav>
<div class="search" id="searchWrapper">
    <form method="post">
        <input id="searchSub" name="searchSub" type="submit" style="display: none" value="">
        <input name="SearchContent" required type="text" placeholder="was willst du Suchen?">
        <label for="searchSub"><i class="fas fa-search"></i></label>
    </form>
</div>
<div class="background-image"></div>

