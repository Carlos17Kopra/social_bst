<?php

require_once("Models/A_Model.php");
class Rank extends A_Model
{

    private $id;
    private $name;
    private $color;

    public function __construct($id)
    {
        $res = Config::getConfig()->getConnection()->getSQLData("SELECT * FROM rank WHERE rankID=?", [$id]);
        foreach ($res->fetchAll() as $fetch => $row) {
            $this->id = $row['rankID'];
            $this->name = $row['rankName'];
            $this->color = $row['rankColor'];
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    static function all(){
        $res = Config::getConfig()->getConnection()->getSQLData("SELECT * FROM rank");
        $ret = [];
        foreach ($res->fetchAll() as $fetch => $row) {
            $rank = new Rank($row['rankID']);
            array_push($ret, $rank);
        }
        return $ret;
    }

    static function create($name = "", $color="")
    {
        return Config::getConfig()->getConnection()->prepareStatement("INSERT INTO rank (rankName, rankColor) VALUES(?,?)", [$name, $color]);
    }

    static function delete($id = 0)
    {
        Config::getConfig()->getConnection()->prepareStatement("DELETE FROM rank WHERE rankID=?)", [$id]);
    }

    static function init()
    {
        return Config::getConfig()->getConnection()->createTable("rank",[
           ["rankID", "INT(11)", "AUTO_INCREMENT", "PRIMARY KEY", "NOT NULL"],
           ["rankName", "VARCHAR(200)", "NOT NULL"],
           ["rankColor" ,"VARCHAR(200)", "NOT NULL"]
        ]);
    }

    public function hasUser(User $user){
        $rankID = $user->getUserRankID();
        return $rankID === $this->getId();
    }
}