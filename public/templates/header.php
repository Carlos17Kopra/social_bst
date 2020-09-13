<?php
//Config implementieren
require "../_conf/config.php";


//HTML und die Links ausgeben
echo '
<head>

    <meta charset="utf-8">
    <title>SocialBST</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../_conf/system/css/style.css" >
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">

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
<li><a href="#">Home</a></li>
<li><a href="#">About</a></li>
<li><a href="#">Services</a></li>
<li><a href="#">Gallery</a></li>
<li><a href="#">Feedback</a></li>
</ul>
</nav>

';
