<?php
require "templates/header.php";
?>

<main>

    <h1>Login</h1>
    <hr>
    <?php require "../_conf/system/php/scripts/backend_login.php";
        if(!isset($_SESSION[session_id])) {
            echo '
            <div class="login-wrapper slide-up">
        
                <form method="post">
        
                    <label><input autocomplete="off" required type="text" name="name_o_mail"><span>Benutzername oder E-Mail</span></label><br>
                    <label><input autocomplete="off" required type="password" name="password"><span>Passwort</span></label><br>
                    <input type="submit" class="login-submit" name="loginSubmit" value="Anmelden">
                    <p class="info-text">Noch keinen Account?</p>
                    <p class="info-text">Dann registriere dich <a href="register.php">hier</a>.</p>
        
                </form>
        
            </div>
            ';
        }
    ?>

</main>

<?php
require "templates/footer.php";
?>