<?php

    require "templates/header.php";
    if(!isset($_SESSION[session_id])){
        echo "<script>window.location.replace('login.php');</script>";
    }
    $user = new User($_SESSION[session_id]);

?>
<main>
    <h1>Account</h1>
    <hr>
    <div class="AccountManager slide-up">
        
        <div class="ProfileImage">
            <img src="<?php echo $user->getUserProfilePicture(); ?>" alt="Profilbild">
        </div>
        <div class="userName">
            <p><?php echo $user->getUserName(); ?></p>
            <p><?php echo "@".$user->getUserName()."#".$user->getUserID(); ?></p>
        </div>
        <div class="registerDate">
            <i class="far fa-calendar-alt"></i> <span>seit dem <?php echo $user->getUserRegisterDate(); ?> bei SocialBST</span>
        </div>
        <div class="actions">
            <form method="post">
                <input type="submit" name="logoutSub" value="Abmelden">
                <input type="submit" name="changeData" value="Daten ändern">
                <input type="submit" name="delAccount" value="Account löschen">
            </form>
        </div>
        <div class="Overview-UserInfos" id="userInfos">

            <div class="underNav">
                <ul>
                    <li id="user_posts">Posts</li>
                    <li id="user_follower">Follower</li>
                    <li id="user_follows">Follows</li>
                    <li id="user_friends">Freunde</li>
                </ul>
            </div>
            <div class="underContent customBar" id="underContent">
                <div class="underWrapper" id="underWrapper">
                    <div class="underContentSection" id="posts"></div>
                    <div class="underContentSection inherit-user-data" id="follower"></div>
                    <div class="underContentSection inherit-user-data" id="follows"></div>
                    <div class="underContentSection inherit-user-data" id="friends"></div>
                </div>
            </div>

        </div>

    </div>

    <?php
    if(isset($_POST['logoutSub'])){
        session_destroy();
        echo "<script>window.location.replace('login.php')</script>";
    }
    ?>

</main>
<script src="../_conf/system/js/scripts/underNav.js"></script>
<?php require "templates/footer.php"; ?>
