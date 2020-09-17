<?php

require "templates/header.php";


/*
Config::getConfig()->getConnection()->createTable(
    "User",
    [
        ["UserID", "INT(11)", "AUTO_INCREMENT", "PRIMARY KEY"],
        ["UserName", "VARCHAR(200)"]
    ]
);
*/

for($i=0;$i<100;$i++){
    echo "<br>";
}

require "templates/footer.php";
