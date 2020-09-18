<?php

class SQLConnection
{

    //Connection
    private $db;

    //constructor
    public function __construct($array)
    {
        //Options für die Connection
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        //PDOConnection aufbauen und Variable setzen
        $this->db = new PDO("mysql:host=".$array['host'].";port=".$array['port'].";dbname=".$array['database'].";charset=utf8mb4", $array['user'], $array['passwd'], $options);
    }

    //Function für Statements wie Insert oder UPDATE -> kein Response
     function prepareStatement($sql, $params=NULL){

        //Statement wird von PDO prepared
        $prep = $this->db->prepare($sql);

        //falls Parameter angegeben sind
        if($params != NULL) {

            //alle Params werden durchgeloopt
            for ($index = 0; $index < sizeof($params); $index++) {

                //Parameter werden von Tags gefiltert
                $params[$index] = strip_tags($params[$index], Config::allowedTags);

            }


            for ($index = 0; $index < sizeof($params); $index++) {

                //Parameter werden eingesetzt
                $prep->bindParam($index + 1, $params[$index]);
            }

        }

        //falls das Statement gut läuft return true, falls nicht Errorreturn
        if($prep->execute()){
            return true;
        }else{

            return "Error: ".$prep->errorInfo()[0];
        }

    }

    //function für alle Response-Statements
    function getSQLData($sql, $params = NULL){

        //Schritte so wie bei Prepare (nur ohne das Filtern der Tags)
        $prep = $this->db->prepare($sql);
        if($params !== NULL) {

            for ($index = 0; $index < sizeof($params); $index++) {

                $prep->bindParam($index + 1, $params[$index]);

            }

        }
        $prep->execute();
        return $prep;

    }

    //Tables löschen
    function deleteTable($tableName){
        $stm = "DROP TABLE ".$tableName;
        return $this->prepareStatement($stm);
    }

    //Tables erstellen
    function createTable($tableName, $fields = []){

        //BasisStatement
        $stm= "CREATE TABLE IF NOT EXISTS ".$tableName." (";

        $vals = "";
        //Wenn Felder angegeben sind dann fahre fort, sonst false
        if(sizeof($fields) > 0) {

            //alle Felder werden durchgegangen
            foreach ($fields as $field) {
                //Stringbuilder für Statement
                $vals .= ",";
                foreach ($field as $f) {

                    $vals .= " " . $f;

                }
            }
            $vals = substr($vals, 2);
            $stm .= $vals . ")";
            //finales Statement return -> true oder Error
            return $this->prepareStatement($stm);
        }else{
            return false;
        }

    }

}