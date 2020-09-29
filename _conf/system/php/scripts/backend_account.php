<?php

require_once("../../../Config.php");

if(isset($_SESSION[session_id])) {

    $uid = $_SESSION[session_id];

    $user = new User($uid);

    if (isset($_POST['func'])) {

        if (isset($_POST['type'])) {

            $func = $_POST['func'];
            $type = $_POST['type'];

            if ($func === "underNav") {

                if ($type == "user_posts") {

                    echo "<div class='user-posts'>";
                    echo "<h2>Deine Posts (".sizeof(Post::getUserPosts($user)).")</h2>";
                    $posts = Post::getUserPosts($user);
                    foreach ($posts as $post) {
                        echo $post->render($user);
                    }
                    echo "</div>";
                    

            } else if ($type == "user_follower") {

                    echo "<div class='follower'>";
                    echo "<h2>Deine Follower (".$user->getUserFollowerCount().")</h2>";
                    $followers = $user->getUserFollower();
                    foreach ($followers as $f){
                        echo $f->render();
                    }
                    echo "</div>";

                } else if ($type == "user_follows") {
                    echo "<div class='follower'>";
                    echo "<h2>Deine Follows (".$user->getUserFollowingCount().")</h2>";
                    $followers = $user->getUserFollows();
                    foreach ($followers as $f){
                        echo $f->render();
                    }
                    echo "</div>";
                } else if ($type == "user_friends") {
                    echo "<div class='friends'>";
                    echo "<h2>Deine Freunde (".$user->getUserFriendsCount().")</h2>";
                    $followers = $user->getUserFriends();
                    foreach ($followers as $f){
                        echo $f->render();
                    }
                    echo "</div>";
                }
            }else if($func == "post"){
                if($type == "like") {
                    if (isset($_POST['postID'])) {
                        $pid = $_POST['postID'];
                        $post = new Post($pid);

                        if (!$post->isUserLiker($user)) {
                            $post->addLiker($user);
                            echo $post->getPostLikes();
                        } else {
                            print_r("error");
                        }

                    }
                }
            }

        }
    }
}