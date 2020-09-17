<?php
if(isset($_POST['loginSubmit'])){

    if(isset($_POST['name_o_mail'])){
        if(isset($_POST['password'])){

            $password = $_POST['password'];
            $name_o_name = $_POST['name_o_mail'];
            $mode = 0;
            $exist = false;
            $user = new User(0);
            if(strpos($name_o_name, "@")){
                $mode = 1;
            }else{
                $mode = 2;
            }
            if($mode == 1){
                if(User::existsFromEmail($name_o_name)){
                    $user = User::fromMail($name_o_name);
                    login($user, $password);
                }else{
                    echo "<error>Ein User mit dieser E-Mail existiert nicht!</error>";

                }
            }else if($mode == 2){
                if(User::existsFromName($name_o_name)){
                    $user = User::fromName($name_o_name);
                    login($user, $password);
                }else{
                    echo "<error>Ein User mit diesem Namen existiert nicht!</error>";

                }
            }

        }else{
            echo "<error>Du musst ein Passwort angeben!</error>";
        }
    }else{
        echo "<error>Du musst einen Namen angeben!</error>";
    }

}
function login(User $user, $pw){

    if($user->isUserPassword($pw)){
        echo "<info>Du bist eingeloggt! <br> <a href='account.php'>Hier</a> kommst du zu deinem Account!</info>";
        $_SESSION[Config::session_id] = $user->getUserID();
    }else{
        echo "<error>Deine Daten sind nicht korrekt!</error>";
    }

}