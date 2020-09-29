<?php

require_once("Models/A_Model.php");
class User extends A_Model
{

    private $userID;
    private $userName;
    private $userPassword;
    private $userEmail;
    private $userAge; // Datum d. geb. -> beim getter berechnen lassen
    private $userProfilePicture;
    private $userStatus;
    private $userClass; // z.B FIN/ISE 01 für die vertretung bzw Stundenpläne
    private $userRankID;
    private $userFriends;
    private $userRegisterDate;
    private $userFollows;

    public function __construct($id)
    {
        $res = Config::getConfig()->getConnection()->getSQLData("SELECT * FROM `user` WHERE UserID=?", [$id]);
        foreach ($res->fetchAll() as $fetch => $row) {

            $this->userID = $row['userID'];
            $this->userName = $row['userName'];
            $this->userPassword = $row['userPassword'];
            $this->userEmail = $row['userEmail'];
            $this->userAge = $row['userAge'];
            $this->userProfilePicture = $row['userProfilePicture'];
            $this->userStatus = $row['userStatus'];
            $this->userClass = $row['userClass'];
            $this->userRankID = $row['userRankID'];
            $this->userFriends = $row['userFriends'];
            $this->userRegisterDate = $row['userRegisterDate'];
            $this->userFollows = $row['userFollows'];

        }
    }

    //Tabellen erstellen
    public static function init(){
        return Config::getConfig()->getConnection()->createTable(
            "user",
            [
                ["userID", "INT(11)", "AUTO_INCREMENT", "PRIMARY KEY", "NOT NULL"],
                ["userName", "VARCHAR(200)", "NOT NULL"],
                ["userPassword", "TEXT", "NOT NULL"],
                ["userEmail", "VARCHAR(200)", "NOT NULL"],
                ["userAge", "DATE", "NOT NULL"],
                ["userProfilePicture", "TEXT", "NOT NULL"],
                ["userStatus", "TEXT", "NOT NULL"],
                ["userClass", "VARCHAR(200)", "NOT NULL"], // noch unklar
                ["userRankID", "INT(11)", "NOT NULL"],
                ["userFriends", "LONGTEXT", "NOT NULL"], // noch unklar
                ["userFollows", "LONGTEXT", "NOT NULL"],
                ["userRegisterDate", "VARCHAR(200)", "NOT NULL"]
            ]
        );
    }

    //beim Registrieren verwendete Mehtode
    static function create($userName = "",$userPassword = "", $userEmail = "", $userAge = "", $userProfilePicture = "../_conf/system/data/user/profilepictures/demo.png", $userStatus = "Hallo, ich habe hier einen Account!", $userClass = "", $userRankID = 0){

        $date = date("d.m.Y");

        //ist der Name schon vergeben? (Sicherheitsabfrage -> Errorhandling in dem RegisterScreen)
        if(!User::existsFromName($userName)){

            //SQLStatement und values vorbereiten
            $sql = "INSERT INTO `user` (userName, userPassword, userEmail, userAge, userProfilePicture, userStatus, userClass, userRankID, userFriends, userRegisterDate, userFollows)
                                VALUES(?,?,?,?,?,?,?,?,?,?,?)";
            $vals = [$userName, PasswordHash::hashPassword($userPassword), $userEmail, $userAge, $userProfilePicture, $userStatus, $userClass, $userRankID, "", $date, ""];
            return Config::getConfig()->getConnection()->prepareStatement($sql, $vals);

        }else{
            return false;
        }

    }

    //Methode zum löschen eines Users
    static function delete($userID = "")
    {
        //ist eine UserID angegeben -> ja returne das Statement, nein returne false
        if($userID !== ""){

            return Config::getConfig()->getConnection()->prepareStatement("DELETE FROM `user` WHERE userID=?", [$userID]);

        }else{
            return false;
        }
    }

    //User von dem Namen getten
    static function fromName($userName){

        //Callback der Database holen und falls es existiert einen User returnen, falls nicht einfach false
        $res = Config::getConfig()->getConnection()->getSQLData("SELECT * FROM `user` WHERE userName=?", [$userName]);
        if($res->rowCount() > 0){

            $id = $res->fetch()['userID'];
            return new User($id);

        }else{
            return false;
        }

    }

    //User von dem Email getten
    static function fromMail($userMail){

        //Callback der Database holen und falls es existiert einen User returnen, falls nicht einfach false
        $res = Config::getConfig()->getConnection()->getSQLData("SELECT * FROM `user` WHERE userEmail=?", [$userMail]);
        if($res->rowCount() > 0){

            $id = $res->fetch()['userID'];
            return new User($id);

        }else{
            return false;
        }

    }

    //Alle User getten
    static function all(){

        //UserArray, welches returned wird
        $ret = [];

        $res = Config::getConfig()->getConnection()->getSQLData("SELECT * FROM `user`");
        foreach ($res->fetchAll() as $fetch => $row) {

            $u = new User($row['userID']);
            array_push($ret, $u);

        }
        return $ret;

    }

    //Abfrage onb der User anhand des Namens schon existiert
    static function existsFromName($name){
        $users = User::all();
        foreach ($users as $user){
            if($user->getUserName() === $name){
                return true;
            }
        }
        return false;
    }
    //Abfrage onb der User anhand der Email schon existiert
    static function existsFromEmail($mail){
        $users = User::all();
        foreach ($users as $user){
            if($user->getUserEmail() === $mail){
                return true;
            }
        }
        return false;
    }
    //Abfrage ob der User anhand der ID schon existiert
    static function existsFromID($id){
        $users = User::all();
        foreach ($users as $user){
            if($user->getUserID() == $id){

                return true;
            }
        }
        return false;
    }

    //normale Getter


    /**
     * @return mixed
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * @return mixed
     */
    public function getUserFriends()
    {
        $array = explode(";", $this->userFriends);
        $ret = [];
        foreach ($array as $u){

            if(User::existsFromID($u)){
                $add = new User($u);
                array_push($ret, $add);
            }
        }
        return $ret;
    }
    public function getUserFriendsCount(){
        return sizeof($this->getUserFriends());
    }

    /**
     * @return mixed
     * @TODO
     *  - AgeCalculation
     */
    public function getUserAge()
    {
        return $this->userAge;
    }

    /**
     * @return mixed
     */
    public function getUserClass()
    {
        return $this->userClass;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getUserProfilePicture()
    {
        return $this->userProfilePicture;
    }

    /**
     * @return mixed
     */
    public function getUserRankID()
    {
        return $this->userRankID;
    }

    /**
     * @return mixed
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    //normale Setter

    /**
     * @param User $friend
     */
    public function addFriend(User $friend)
    {
        //FriendArray pushen und updaten
        $this->userFriends.=";".$friend->getUserID();
        Config::getConfig()->getConnection()->prepareStatement("UPDATE `user` SET friends=? WHERE userID=?", [$this->userFriends, $this->userID]);
    }
    public function isFriend(User $friend){
        $friends = $this->getUserFriends();
        return in_array($friend->getUserID(), $friends);
    }
    public function removeFriend(User $friend){
        if($this->isFriend($friend)){
            $this->userFriends = str_replace(";".$friend->getUserID(), "", $this->userFriends);
            Config::getConfig()->getConnection()->prepareStatement("UPDATE `user` SET friends=? WHERE userID=?", [$this->userFriends, $this->userID]);
        }
    }

    /**
     * @param mixed $userAge
     */
    public function setUserAge($userAge)
    {
        $this->userAge = $userAge;
        Config::getConfig()->getConnection()->prepareStatement("UPDATE `user` SET userAge=? WHERE userID=?", [$userAge, $this->userID]);
    }

    /**
     * @param mixed $userClass
     */
    public function setUserClass($userClass)
    {
        $this->userClass = $userClass;
        Config::getConfig()->getConnection()->prepareStatement("UPDATE `user` SET userClass=? WHERE userID=?", [$userClass, $this->userID]);
    }

    /**
     * @param mixed $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
        Config::getConfig()->getConnection()->prepareStatement("UPDATE `user` SET userEmail=? WHERE userID=?", [$userEmail, $this->userID]);
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        //abfragen ob der Name schon existiert
        if($this->canUserChangeName($userName)){
            $this->userName = $userName;
            Config::getConfig()->getConnection()->prepareStatement("UPDATE `user` SET userName=? WHERE userID=?", [$userName, $this->userID]);
        }
    }

    //Andersnameige, spezialisierte Methode
    /**
     * @param $newName
     * @return bool
     */
    public function canUserChangeName($newName){

        if(User::fromName($newName) === false){
            return false;
        }else{
            return true;
        }

    }

    /**
     * @param mixed $userProfilePicture
     * */
    public function setUserProfilePicture($userProfilePicture)
    {
        $this->userProfilePicture = $userProfilePicture;
    }

    /**
     * @param mixed $userRankID
     * @TODO
     *  - TeamKlasse mit exists-function einfügen
     */
    public function setUserRankID($userRankID)
    {
        $this->userRankID = $userRankID;
        Config::getConfig()->getConnection()->prepareStatement("UPDATE `user` SET userRankID=? WHERE userID=?", [$userRankID, $this->userID]);
    }

    /**
     * @param mixed $userStatus
     */
    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;
        Config::getConfig()->getConnection()->prepareStatement("UPDATE `user` SET userStatus=? WHERE userID=?", [$userStatus, $this->userID]);
    }

    /**
     * @param mixed $userPassword
     * @TODO
     *  - Methode sicher machen
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = PasswordHash::hashPassword($userPassword);
    }

    /**
     * @param $givenPW
     * @return bool
     */
    public function isUserPassword($givenPW){
        return PasswordHash::checkPassword($givenPW, $this);
    }

    /**
     * @return mixed
     */
    public function getUserRegisterDate()
    {
        return $this->userRegisterDate;
    }

    /**
     * @return mixed
     */
    public function getUserFollows()
    {
        $array = explode(";",$this->userFollows);
        $ret = [];
        foreach ($array as $u){
            if(User::existsFromID($u)){
                array_push($ret, new User($u));
            }
        }
        return $ret;
    }
    public function isUserFollowing(User $follow){
        $follows = $this->getUserFollows();
        foreach ($follows as $_follow) {
            if($_follow->getUserID() === $follow->getUserID()){
                return true;
            }
        }
        return false;
    }
    public function addUserFollow(User $newFollow){
        if(!$this->isUserFollowing($newFollow)){
            $this->userFollows = $this->userFollows.=";".$newFollow->getUserID();
        }
    }
    public function removeUserFollow(User $newFollow){
        if($this->isUserFollowing($newFollow)){
            $this->userFollows = str_replace(";".$newFollow->getUserID(), "", $this->userFollows);
        }
    }
    public function getUserFollowingCount(){
        return sizeof($this->getUserFollows());
    }

    public function getUserRankObj(){
        $ranks = Rank::all();
        foreach ($ranks as $rank){
            if($rank->hasUser($this)){
                return $rank;
            }
        }
        return new Rank(0);
    }

    public function getUserFollower(){
        $users = User::all();
        $ret = [];
        foreach ($users as $user){
            if($user->isUserFollowing($this)){
                array_push($ret, $user);
            }
        }
        return $ret;
    }
    public function getUserFollowerCount(){
        return sizeof($this->getUserFollower());
    }

    public function render(){

        $renderID = uniqid(md5(uniqid()));

        $html="<div class='profile' data-tooltip-id='".$renderID."' data-id='".$this->getUserID()."'>";
            $html.="<div class='profile-image'>";
                $html.="<div class='profile-image-image' data-src='".$this->getUserProfilePicture()."'></div>";
            $html.="</div>";
            $html.="<div class='username'>";
                $html.="<p class='name'>".$this->getUserName()."</p>";
                $html.="<p class='tag'>".$this->getUserName()."#".$this->getUserID()."</p>";
            $html.="</div>";
            $rankName = $this->getUserRankObj()->getName();
            $rankColor = $this->getUserRankObj()->getColor();
            $html.="<div class='rank' style='background-color: ".$rankColor."'>";

                $html.="<p>".$rankName."</p>";

            $html.="</div>";

            $html.="<div class='info' id='".$renderID."'>";
                $html.="<div class='row row1'>";
                    $html.="<div class='profile-image'>";
                        $html.="<div class='profile-image-image' data-src='".$this->getUserProfilePicture()."'></div>";
                    $html.="</div>";

                    $html.="<div class='username'>";
                        $html.="<p class='name'>".$this->getUserName()."</p>";
                        $html.="<p class='tag'>".$this->getUserName()."#".$this->getUserID()."</p>";
                        $html.="<p class='date'><i class='fas fa-calendar-alt'></i> ".$this->getUserRegisterDate()."</p>";
                    $html.="</div>";

                $html.="</div>";
                $html.="<div class='row row2'>";
                    $html.="<div class='user-info'>";
                        $html.="<span>Status: <br> <span>".nl2br($this->getUserStatus())."</span></span>";
                        $html.="<span>Freunde: <br> <span>".$this->getUserFriendsCount()."</span></span>";
                        $html.="<span>Follower: <br> <span>".$this->getUserFollowerCount()."</span></span>";
                    $html.="</div>";
                $html.="</div>";
            $html.="</div>";

        $html.="</div>";
        return $html;

    }

}