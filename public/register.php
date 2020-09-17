<?php
require "templates/header.php";
?>

    <main>

        <h1>Register</h1>
        <hr>
        <?php require "../_conf/system/php/scripts/backend_register.php"; ?>
        <div class="login-wrapper slide-up">

            <form method="post">

                <label><input autocomplete="off" required type="text" name="mail"><span>E-Mail</span></label><br>
                <label><input autocomplete="off" required type="text" name="name"><span>Benutzername</span></label><br>
                <label><input autocomplete="off" required type="password" name="password"><span>Passwort</span></label><br>
                <label><input autocomplete="off" required type="password" name="rep_password"><span>Passwort wiederholen</span></label><br>
                <label><input autocomplete="off" required type="date" name="dateofbirth" ></label><br>

                <input type="submit" class="login-submit" name="registerSubmit" value="Registrieren">
                <p class="info-text">schon einen Account?</p>
                <p class="info-text">Dann melde dich <a href="login.php">hier</a> an.</p>

            </form>

        </div>

    </main>

<?php
require "templates/footer.php";
?>