<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Install</title>
</head>
<body>
<form method="post">

    <input type="submit" value="Installieren" name="InstallSubmit">

</form>

<?php
require "../../_conf/config.php";
if(isset($_POST['InstallSubmit'])){

    User::init();
    User::create(
        "Admin",
        "Admin",
        "admin@bst.de",
        "00.00.0000",
        "../data/pics/default.png",
        "Ich bin der erste Account hier!",
        "NONE",
        "0",
        "NONE"
    );
    //unlink("index.php");

}

?>

</body>
</html>