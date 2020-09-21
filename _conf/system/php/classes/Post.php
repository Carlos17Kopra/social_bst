<?php

require "Models/A_Model.php";

class Post extends A_Model
{

    //HashTags als Array weil eigene Klasse und Tabelle
    private $postID;
    private $postName;
    private $postCreator;
    private $postContent;
    private $postData;
    private $postHashtags;
    private $postDate;
    private $postStatus;
    private $postLikers;

    public function __construct($postID)
    {
        $res = Config::getConfig()->getConnection()->getSQLData("SELECT * FROM post WHERE postID=?", [$postID]);
        foreach ($res->fetchAll() as $fetch => $row) {

            $this->postID = $row['postID'];
            $this->postName = $row['postName'];
            $this->postContent = $row['postContent'];
            $this->postCreator = $row['postCreator'];
            $this->postData = $row['postData'];
            $this->postHashtags = $row['postHashtags'];
            $this->postDate = $row['postDate'];
            $this->postStatus = $row['postStatus'];
            $this->postLikers = $row['postLikers'];

        }
    }

    static function getUserPosts(User $user){
        $ret = [];
        $posts = self::getAll();
        foreach ($posts as $post){
            if($post->getCreatorID() === $user->getUserID()){
                array_push($ret, new Post($post->getPostID()));
            }
        }
        return $ret;
    }

    static function getAll(){
        $ret = [];
        $res = Config::getConfig()->getConnection()->getSQLData("SELECT * FROM posts");
        foreach ($res->fetchAll() as $fetch => $row) {
            $post = new Post($row['postID']);
            array_push($ret, $post);
        }
        return $ret;
    }

    static function existsFromID($postID){
        $posts = self::getAll();
        foreach ($posts as $post){
            if($post->getPostID() === $postID){
                return true;
            }
        }
        return false;
    }

    //Createfunction schreiben
    static function create()
    {
        
    }

    static function delete($postID = 0)
    {
        if(self::existsFromID($postID)){
            Config::getConfig()->getConnection()->prepareStatement("DELETE FROM post WHERE postID=?", [$postID]);
        }
    }

    static function init()
    {
        Config::getConfig()->getConnection()->createTable("posts",[
           ["postID", "INT(11)", "AUTO_IMCREMENT", "PRIMARY KEY", "NOT NULL"],
           ["postName", "VARCHAR(200)", "NOT NULL"],
           ["postCreator", "INT(11)", "NOT NULL"],
           ["postContent", "TEXT", "NOT NULL"],
           ["postData", "LONGTEXT", "NOT NULL"],
           ["postHashtags", "LONGTEXT", "NOT NULL"],
           ["postDate", "VARCHAR(200)", "NOT NULL"],
           ["postStatus", "INT(11)", "NOT NULL"],
           ["postLikers", "LONGTEXT", "NOT NULL"]
        ]);
    }

    /**
     * @return mixed
     */
    public function getPostContent()
    {
        return $this->postContent;
    }

    /**
     * @return mixed
     */
    public function getPostCreator()
    {
        return $this->postCreator;
    }

    /**
     * @return mixed
     */
    public function getPostData()
    {
        return $this->postData;
    }

    /**
     * @return mixed
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * @return mixed
     */
    public function getPostHashtags()
    {
        return $this->postHashtags;
    }

    /**
     * @return mixed
     */
    public function getPostID()
    {
        return $this->postID;
    }

    /**
     * @return mixed
     */
    public function getPostName()
    {
        return $this->postName;
    }

    /**
     * @return mixed
     */
    public function getPostStatus()
    {
        return $this->postStatus;
    }

    /**
     * @return mixed
     */
    public function getPostLikers()
    {
        return explode(";",$this->postLikers);
    }
    public function isUserLiker(User $aliker){
        $likers = $this->getPostLikers();
        foreach ($likers as $liker){
            if($liker === $aliker->getUserID()){
                return true;
            }
        }
        return false;
    }
    public function addLiker(User $liker){
        if(!$this->isUserLiker($liker)){
            $this->postLikers = $this->postLikers.=";".$liker->getUserID();
        }
    }
    public function removeLiker(User $liker){
        if($this->isUserLiker($liker)){
            $this->postLikers = str_replace(";".$liker->getUserID(), "", $this->postLikers);
        }
    }


    /**
     * @param mixed $postContent
     */
    public function setPostContent($postContent)
    {
        $this->postContent = $postContent;
    }

    /**
     * @param mixed $postData
     */
    public function setPostData($postData)
    {
        $this->postData = $postData;
    }

    /**
     * @param mixed $postDate
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;
    }

    /**
     * @param mixed $postHashtags
     */
    public function setPostHashtags($postHashtags)
    {
        $this->postHashtags = $postHashtags;
    }

    /**
     * @param mixed $postName
     */
    public function setPostName($postName)
    {
        $this->postName = $postName;
    }

    /**
     * @param mixed $postStatus
     */
    public function setPostStatus($postStatus)
    {
        $this->postStatus = $postStatus;
    }
}