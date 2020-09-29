<?php
require_once("Models/A_Model.php");
class Post extends A_Model
{
    
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

    static function getUserPosts(User $user)
    {
        $ret = [];
        $posts = self::all();
        foreach ($posts as $post) {
            if ($post->getPostCreatorID() === $user->getUserID()) {
                array_push($ret, new Post($post->getPostID()));
            }
        }
        return $ret;
    }

    static function all()
    {
        $ret = [];
        $res = Config::getConfig()->getConnection()->getSQLData("SELECT * FROM post ORDER BY postID DESC");
        foreach ($res->fetchAll() as $fetch => $row) {
            $post = new Post($row['postID']);
            array_push($ret, $post);
        }
        return $ret;
    }

    static function existsFromID($postID)
    {
        $posts = self::all();
        foreach ($posts as $post) {
            if ($post->getPostID() === $postID) {
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
        if (self::existsFromID($postID)) {
            Config::getConfig()->getConnection()->prepareStatement("DELETE FROM post WHERE postID=?", [$postID]);
        }
    }

    static function init()
    {
        return Config::getConfig()->getConnection()->createTable("post", [
            ["postID", "INT(11)", "AUTO_INCREMENT", "PRIMARY KEY", "NOT NULL"],
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
    public function getPostCreatorID()
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

    public function getPostImages()
    {
        return explode(";", $this->getPostData());
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
    public function getPostHashtagIDS()
    {
        return explode(";", $this->postHashtags);
    }

    public function getPostHashTags()
    {
        $ret = [];
        $hts = $this->getPostHashtagIDS();
        foreach ($hts as $h) {
            array_push($ret, new HashTag($h));
        }
        return $ret;
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

    public function getPostLikes()
    {
        return sizeof($this->getPostLikers());
    }

    /**
     * @return mixed
     */
    public function getPostLikers()
    {
        $arr = explode(";", $this->postLikers);
        $ret = [];
        foreach ($arr as $i){
            if(User::existsFromID($i)){
                $u = new User($i);
                array_push($ret, $u);
            }
        }
        return $ret;
    }

    public function isUserLiker(User $aliker)
    {
        $likers = $this->getPostLikers();
        foreach ($likers as $liker) {
            if ($liker->getUserID() === $aliker->getUserID()) {
                return true;
            }
        }
        return false;
    }

    public function addLiker(User $liker)
    {
        if (!$this->isUserLiker($liker)) {
            $this->postLikers .= ";" . $liker->getUserID();
            Config::getConfig()->getConnection()->prepareStatement("UPDATE post SET postLikers=? WHERE postID=?", [$this->postLikers, $this->postID]);
        }
    }

    public function removeLiker(User $liker)
    {
        if ($this->isUserLiker($liker)) {
            $this->postLikers = str_replace(";" . $liker->getUserID(), "", $this->postLikers);
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

    public function render(User $user = null)
    {

        $creatorID = self::getPostCreatorID();
        $creator = new User($creatorID);

        $html = "<div class='post'>";

        $html .= "<div class='postheader'>";

        $html .= "<div class='profileImage'><img src='" . $creator->getUserProfilePicture() . "' alt='ProfilBild'></div>";

        $html .= "<div class='userInfo'>";

        $html .= "<div class='userName'>";
        $html .= "<span data-id='" . $creator->getUserID() . "'>" . $creator->getUserName() . "</span>";
        $html .= "</div>";

        $html .= "<div class='userTag'>";
        $html .= "<span data-id='" . $creator->getUserID() . "'>" . $creator->getUserName() . "#" . $creator->getUserID() . "</span>";
        $html .= "</div>";

        $html .= "</div>";

        if ($user->getUserID() === $creator->getUserID()) {
            $html .= "<div class='action'>";
            $html .= "<a href='#'>Löschen</a>";
            $html .= "</div>";
        } else {
            if($user !== null){
                if ($user->isUserFollowing($creator)) {
                    $html .= "<div class='action'>";
                    $html .= "<a href='#' class='followbtn' data-function='entfollow' data-user='" . $creator->getUserID() . "'>Entfolgen</a>";
                    $html .= "</div>";
                } else {
                    $html .= "<div class='action'>";
                    $html .= "<a href='#' class='followbtn' data-function='follow' data-user='" . $creator->getUserID() . "'>Folgen</a>";
                    $html .= "</div>";
                }
            }
        }

        $html .= "</div>";

        $html .= "<div class='postcontent'>";

        $html .= "<div class='actions'>";
        if($user !== null) {
            if (self::isUserLiker($user)) {
                $html .= "<div class='like'><i class='far fa-heart active active' data-id='".$this->getPostID()."'></i><div class='likeCount'><span>" . self::getPostLikes() . "</span></div></div>";
            } else {
                $html .= "<div class='like'><i class='far fa-heart clickable' data-id='".$this->getPostID()."'></i><div class='likeCount'><span>" . self::getPostLikes() . "</span></div></div>";
            }
        }else{
            $html .= "<div class='like'><i class='far fa-heart' data-id='".$this->getPostID()."'></i><div class='likeCount'><span>" . self::getPostLikes() . "</span></div></div>";
        }
        if($user !== null) {
            $html .= "<div class='comment'><i class='fas fa-pen' data-id='".$this->getPostID()."'></i></div>";
        }
        $html .= "<div class='share'>";
        $html .= "<i class='fas fa-share-alt share_open_btn' data-id='share_" . self::getPostID() . "'></i>";
        $html .= "<div class='share_container' id='share_" . self::getPostID() . "'>";
        $link = Domain . "/public/posts/all.php?qid=" . self::getPostID();
        $html .= "<span>" . $link . " <i class='far fa-clone copy_btn' data-input='" . $link . "'></i></span>";
        $html .= "</div>";
        $html .= "</div>";

        $html .= "<div class='date'>";
        $html .= "<i class='fas fa-calendar-alt'></i>";
        $html .= "<div class='date-display'>";
        $html .= "<span>" . self::getPostDate() . "</span>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</div>";
        $images = self::getPostImages();
        if (sizeof($images)-1 > 0) {
            $html .= "<div class='slider'>";
            $html .= "<div class='images'>";
            $index = 1;
            foreach ($images as $image) {
                $html .= "<img src='" . $image . "' id='slide_" . self::getPostID() . "_" . $index . "'>";
                $index += 1;
            }
            if (sizeof($images)-1 > 1) {
                $html .= "<div class='inputs'>";
                $index = 1;
                foreach ($images as $image) {
                    $html .= "<div>";
                    $html .= "<input type='radio' name='slider_input_" . self::getPostID() . "' class='slide_input' data-element='slide_" . self::getPostID() . "_" . $index . "' id='slide_input_" . self::getPostID() . "_" . $index . "'>";
                    $html .= "<label for='slide_input_" . self::getPostID() . "_" . $index . "' class='slide_label'></label>";
                    $html .= "</div>";
                    $index += 1;
                }
                $html .= "</div>";
            }

            $html .= "</div>";
            $html .= "</div>";
        }
        $html .= "<div class='text'><span>" . nl2br(self::getPostContent()) . "</span></div>";

        $htgs = self::getPostHashTags();
        if (sizeof($htgs)-1 > 0) {
            $html .= "<div class='hashtags'>";
            foreach ($htgs as $htg) {
                $html .= "<span class='hashtag' data-id='" . $htg->getHashTagID() . "'>" . $htg->getHashTagTitle() . "</span>";
            }
            $html .= "</div>";
        }


        $html .= "<div>";

        $html .= "</div>";

        $html .= "</div>";

        $html.="</div>";

        return $html;

    }


}