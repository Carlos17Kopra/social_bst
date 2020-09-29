<?php

require "../../../config.php";

if(isset($_POST['func'])){
    $func = $_POST['func'];
    if($func === "init"){

        if(isset($_POST['model'])){
            $model = $_POST['model'];

            if($model === "user"){
                if(User::init()){
                    echo "[INFO] UserTabelle wurde erstellt.";
                }else{
                    die("[ERROR] UserTabelle konnte nicht erstellt werden!");
                }
                if(User::create(
                    "Admin",
                    "Admin",
                    "admin@bst.de"
                )){
                    echo "[INFO] Adminbenutzer wurde erstellt.";
                }else{
                    die("[ERROR] Adminbenutzer wurde nicht erstellt!");
                }
            }else if($model === "rank"){
                if(Rank::init()){
                    echo "[INFO] RangTabelle wurde erstellt.";
                }else{
                    die("[ERROR] RangTabelle wurde nicht erstellt!");
                }
                if(Rank::create("Admin", "red")){
                    echo "[INFO] Adminrang wurde erstellt.";
                }else{
                    echo "[WARN] Adminrang wurde nicht erstellt!";
                }
                if(Rank::create("User", "grey")){
                    echo "[INFO] Userrang wurde erstellt.";
                }else{
                    echo "[WARN] Userrang wurde nicht erstellt!";
                }
            }else if($model === "hashtag"){
                if(HashTag::init()){
                    echo "[INFO] HashTagTabelle wurde erstellt.";
                }else{
                    die("[ERROR] HashTagTabelle wurde nicht erstellt!");
                }
            }else if($model === "post"){
                if(Post::init()){
                    echo "[INFO] PostTabelle wurde erstellt";
                }else{
                    die("[ERROR] PostTabelle wurde nicht erstellt!");
                }
            }

        }

    }
}