<?php
if(isset($_POST['func'])){
    if(isset($_POST['type'])){

        $func = $_POST['func'];
        $type = $_POST['type'];
        if($func === "underNav"){

            if($type == "user_posts"){
                echo "UserPosts";
            }else if($type == "user_follower"){
                echo "UserFollower";
            }else if($type == "user_follows"){
                echo "UserFollows";
            }else if($type == "user_friends"){
                echo "UserFriends";
            }

        }

    }
}