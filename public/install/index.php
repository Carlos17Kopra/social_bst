<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <title>isntall</title>
</head>

<style>
    *{
        padding: 0;
        margin: 0;
        font-family: sans-serif;
        box-sizing: border-box;
    }

    #installBtn{
        position: absolute;
        left: 50%;
        top: 10%;
        transform: translateX(-50%);

        font-size: 20px;
        font-weight: bold;
        text-decoration: none;
        color: white;
        background-color: rgb(35, 35, 204);
        padding: 20px;
    }
    .console{
        position: absolute;
        border: 1px solid black;
        height: 90%;
        width: 90%;
        left: 50%;
        top: 20%;
        transform: translateX(-50%);
        padding: 5px;
        margin-bottom: 12px;
        overflow-y: scroll;
    }
    p.error{
        color: red;
    }
</style>

<body>

<div class="btn">

    <a href="#" id="installBtn">Installieren</a>

</div>
<div class="console">
    <div id="consolecontent">

    </div>
</div>
<script>

    const installConfig = [
        {
            link: "../../_conf/system/php/scripts/backend_install.php",
            model: "user"
        },
        {
            link: "../../_conf/system/php/scripts/backend_install.php",
            model: "rank"
        },
        {
            link: "../../_conf/system/php/scripts/backend_install.php",
            model: "hashtag"
        }
        ,
        {
            link: "../../_conf/system/php/scripts/backend_install.php",
            model: "post"
        }
    ]
    const consolecontent = document.getElementById("consolecontent");
    const installbtn = document.getElementById("installBtn");


    function consoleLog(input, type){
        consolecontent.innerHTML+="<p class='"+type+"'>"+input+"</p>";
    }

    installbtn.addEventListener('click', e =>{
        e.preventDefault();
        consoleLog("[INFO] Starte Installation...", "info");

        initModel(installConfig[0], 0)

    });

    function initModel(ModelObject, index){

        consoleLog("[INFO] Versuche "+ModelObject.model+" zu initialisieren...", "info");

        console.log(ModelObject.link);

        $.post(ModelObject.link, {
            func: 'init',
            model: ModelObject.model
        }, data =>{
            consoleLog(data, "info");

            index+=1;
            if(installConfig[index] !== null){
                initModel(installConfig[index], index);
            }else{
                consoleLog("[INFO] Installationsprozess beendet!", "info");
            }

        }).fail((error)=>{
            consoleLog("[ERROR] Es ist ein Fehler aufgetreten!", "error");
            consoleLog("[ERROR] Für mehr Informationen schau in die Browserkonsole!", "error");
        });


    }

</script>
</body>
</html>
