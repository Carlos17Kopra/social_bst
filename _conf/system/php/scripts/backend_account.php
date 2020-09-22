<?php
if(isset($_SESSION[Config::session_id])) {
    $user = new User($_SESSION[Config::session_id]);
    if (isset($_POST['func'])) {
        if (isset($_POST['type'])) {

            $func = $_POST['func'];
            $type = $_POST['type'];
            if ($func === "underNav") {

                if ($type == "user_posts") {
                    $posts = Post::getUserPosts($user);
                    foreach ($posts as $post){

                    }
                } else if ($type == "user_follower") {
                    echo "UserFollower";
                } else if ($type == "user_follows") {
                    echo "UserFollows";
                } else if ($type == "user_friends") {
                    echo "UserFriends";
                }

            }

        }
    }
}