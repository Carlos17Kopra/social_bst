<?php
require "../../_conf/config.php";
    if(!isset($_SESSION[Config::session_id])){
        echo "<script>window.location.replace('../login.php');</script>";
    }

    $user = new User($_SESSION[Config::session_id]);

    $tables = Config::getConfig()->getConnection()->getSQLData("SHOW TABLES");

    $html = "<div class='tables'>";
    $html.="<h2>Tabellen</h2>";
        foreach ($tables as $table => $t){

            $html.="<form method='post'>";
            $html.="<h3>".$t['Tables_in_socialbst']."</h3>";
            $html.="<input type='hidden' name='currentTable' value='".$t['Tables_in_socialbst']."'>";
            $html.="<input type='submit' name='delTable' value='löschen'>";
            $html.="<input type='submit' name='reCreateTable' value='neu Erstellen'>";
            $html.="</form>";

        }
    $html.="</div>";

        echo $html;

        if(isset($_POST['delTable'])){
            $table = $_POST['currentTable'];
            Config::getConfig()->getConnection()->prepareStatement("DROP TABLE ".$table);
            header("location: adminpanel.php");
        }