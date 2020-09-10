<?php
//Config implementieren
require "../_conf/config.php";


//HTML und die Links ausgeben
echo '
<link rel="stylesheet" href="../_conf/system/css/style.css" >
<link rel="stylesheet" href="../_conf/system/scss/master.css" >
<script src="../_conf/system/js/lib/particles.min.js" defer></script>
<script src="../_conf/system/js/scripts/headerparticles.js" defer></script>

<div class="header" id="particles-js">

        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Infos</a></li>
            <li><a href="#">Account</a></li>
            <li><a href="#">FAQ</a></li>
        </ul>

    </div>

';
