<?php

require "Models/A_Model.php";
class HashTag extends A_Model
{

    private $hashTagID;
    private $hashTagTitle;

    public function __construct($id)
    {
        $res = Config::getConfig()->getConnection()->getSQLData("SELECT * FROM HashTag WHERE hashTagID=?", [$id]);
        foreach ($res->fetchAll() as $fetch => $row) {
            $this->hashTagID = $row['hashTagID'];
            $this->hashTagTitle = $row['hashTagTitle'];
        }
    }

    /**
     * @return mixed
     */
    public function getHashTagID()
    {
        return $this->hashTagID;
    }

    /**
     * @param mixed $hashTagID
     */
    public function setHashTagID($hashTagID)
    {
        $this->hashTagID = $hashTagID;
    }

    /**
     * @return mixed
     */
    public function getHashTagTitle()
    {
        return $this->hashTagTitle;
    }

    /**
     * @param mixed $hashTagTitle
     */
    public function setHashTagTitle($hashTagTitle)
    {
        $this->hashTagTitle = $hashTagTitle;
    }

    static function getAll(){
        $ret = [];
        $res = Config::getConfig()->getConnection()->getSQLData("SELECT * FROM hashTag");

        foreach ($res->fetchAll() as $fetch => $row) {
            array_push($ret, new HashTag($row['hashTagID']));
        }

        return $ret;

    }

    static function existsByTitle($title){
        $hashTags = self::getAll();
        foreach ($hashTags as $hashTag){
            if($hashTag->getHashTagTitle() === $hashTag){
                return true;
            }
        }
        return false;
    }

    static function create($title = "")
    {
        if(!self::existsByTitle($title)){
            return Config::getConfig()->getConnection()->prepareStatement("INSERT INTO hashTag (hashTagTitle) VALUES(?)", [$title]);
        }
        return false;
    }

    static function delete($title = "")
    {
        if(self::existsByTitle($title)){
            return Config::getConfig()->getConnection()->prepareStatement("DELETE FROM hashTag WHERE hashTagTitle=?", [$title]);
        }
        return false;
    }

    static function init()
    {
        Config::getConfig()->getConnection()->createTable("hashTag",[
            ["hashTagID", "INT(11)", "AUTO_INCREMENT", "PRIMARY KEY", "NOT NULL"],
            ["hashTagTitle", "TEXT", "NOT NULL"]
        ]);
    }
}