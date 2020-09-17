<?php

spl_autoload_register('autoload'); //autoloader führ die autoload-Methode aus

//autoload function
function autoload($classname) {

    $ext = ".php"; //FileExtention wird zu .php gesetzt

    $pathArray = array(
                        "../../_conf/system/php/classes/",
                        "../classes/",
                        "_conf/system/php/classes/",
                        "../_conf/system/php/classes/",
                        "../../../_conf/system/php/classes/"
                    ); //array mit möglichen Include-Paths wird gesetzt
    //suche nach der Datei in allen möglichen Paths
    foreach ($pathArray as $path) {
        //file wird gefunden

        if (file_exists($path . $classname . $ext)) {
            //file wird includiert
            include_once $path . $classname . $ext;
            return;
        }
    }
}

class Config{

    const allowedTags = "";

    const session_id = "qQ95C1DwXn5gOOY";

    const sql = [
        "host" => "localhost",
        "port" => "3306",
        "user" => "root",
        "passwd" => "",
        "database" => "socialbst"
    ];

    static function getConfig(){
        return new Config();
    }

    public function getConnection(){
        return new SQLConnection(Config::sql);
    }


}

//sofortiger Sessionstart
session_start();