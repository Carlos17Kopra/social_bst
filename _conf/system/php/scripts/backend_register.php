<?php

if(isset($_POST['registerSubmit'])){

    if(isset($_POST['mail'])){
        if(isset($_POST['name'])){
            if(isset($_POST['password'])){
                if(isset($_POST['rep_password'])){
                    if(isset($_POST['dateofbirth'])){

                        $mail = $_POST['mail'];
                        $name = $_POST['name'];
                        $password = $_POST['password'];
                        $password_rep = $_POST["rep_password"];
                        $birth = $_POST['dateofbirth'];

                        if(!User::existsFromEmail($mail)){

                            if(!User::existsFromName($name)){

                                if($password === $password_rep){

                                    $registerTask = User::create($name, $password, $mail, $birth);
                                    if($registerTask){
                                        echo "<script>window.location.replace('login.php');</script>";
                                    }

                                }else{
                                    echo "<error>Deine Passwörter stimmen nicht überein!</error>";
                                }

                            }else{
                                echo "<error>Einen Nutzer mit diesem Namen gibt es schon!</error>";
                            }

                        }else{
                            echo "<error>Einen Nutzer mit dieser E-Mail gibt es schon!</error>";
                        }

                    }else{
                        echo "<error>Du musst ein Gebutsalter angeben!</error>";
                    }
                }else{
                    echo "<error>Du musst dein Passwort wiederholen!</error>";
                }
            }else{
                echo "<error>Du musst ein Passwort angeben!</error>";
            }
        }else{
            echo "<error>Du musst einen Namen angeben!</error>";
        }
    }else{
        echo "<error>Du musst eine E-Mail angeben!</error>";
    }


}