const user_post_btn = document.getElementById("user_posts");
const user_follower_btn = document.getElementById("user_follower");
const user_follows_btn = document.getElementById("user_follows");
const user_friends_btn = document.getElementById("user_friends");

const user_post_content = document.getElementById("posts");
const user_follower_content = document.getElementById("follower");
const user_follows_content = document.getElementById("follows");
const user_friends_content = document.getElementById("friends");

const underContent = document.getElementById("underContent");
const userInfo = document.getElementById("userInfos");
const underWrapper = document.getElementById("underWrapper");
userInfo.classList.add("loading");

changeContent("user_posts", user_post_content).then(()=>{

    changeContent("user_follower", user_follower_content).then(()=>{
        changeContent("user_follows", user_follows_content).then(()=>{
            changeContent("user_friends", user_friends_content).then(()=> {
                renderTooltip();
                userInfo.classList.remove("loading");
            });
        });
    });
});


function changeContent(type, element){

    return $.post("../_conf/system/php/scripts/backend_account.php", {
        func: 'underNav',
        type : type
    }, data =>{
        if(data !== false){
            element.innerHTML = data;
        }
    });

}

function renderTooltip(){


    const profiles = document.querySelectorAll(".profile");

    let userSize = profiles.length;
    let tmp = userSize;
    for(let i = 0; i<userSize;i++){

        profiles[i].style.zIndex = tmp.toString();
        tmp-=1;
        let s = profiles[i].nextElementSibling;
        if(s == null){
            profiles[i].classList.add("last");
        }
    }

    user_post_btn.addEventListener('click', e=>{
        underWrapper.style.left = "0";
        underContent.scrollTop = 0;
        hideElements(user_post_content);

    });
    user_follower_btn.addEventListener('click', e=>{
        underWrapper.style.left = "-100%";
        underContent.scrollTop = 0;
        hideElements(user_follower_content);

    });
    user_follows_btn.addEventListener('click', e=>{
        underWrapper.style.left = "-200%";
        underContent.scrollTop = 0;
        hideElements(user_follows_content);

    });
    user_friends_btn.addEventListener('click', e=>{
        underWrapper.style.left = "-300%";
        underContent.scrollTop = 0;
        hideElements(user_friends_content);

    });

    function hideElements(element){
        /*setTimeout(()=>{
            let content_elements = [user_post_content, user_follower_content, user_follows_content, user_friends_content];
            content_elements.forEach(el =>{
                if(el.id === element.id){
                    el.style.display = "block";
                }else{
                    el.style.display = "none";
                }
            });
            underWrapper.style.left = "0";
        }, 200);*/
    }

    const copy_btns = document.querySelectorAll(".copy_btn");
    copy_btns.forEach(btn => {

        btn.addEventListener('click', e => {

            btn.style.animation = "resize .2s linear 1";

            let data_text = btn.getAttribute("data-input");

            let el = document.createElement('textarea');
            el.value = data_text;
            document.body.appendChild(el);
            el.select()
            document.execCommand('copy');
            document.body.removeChild(el);
            setTimeout(() => {
                btn.style.animation = "none";
            }, 200);
        });
    });

    const images = document.querySelectorAll(".image");
    const inputs = document.querySelectorAll(".slide_input");

    inputs.forEach(input =>{

        input.addEventListener('click', e=>{
            let image = input.getAttribute("data-element");

            let act_image = document.getElementById(image);
            act_image.style.left = "0px";
            images.forEach(img => {
                if(img.id !== image){
                    img.style.left = "100%";
                }
            });


        });

    });


    const profileImages = document.querySelectorAll(".profile-image-image");
    profileImages.forEach(img => {

        let img_src = img.getAttribute("data-src");

        img.style.backgroundImage = "url('"+img_src+"')";

    });

    profiles.forEach(profile => {
        profile.addEventListener('mouseenter', e=>{

            let id = profile.getAttribute("data-tooltip-id");

            let child = document.getElementById(id);

            child.style.display = "block";
            child.style.animation = "slide .2s linear 1";

        });
        profile.addEventListener('mouseleave', e=>{

            let id = profile.getAttribute("data-tooltip-id");

            let child = document.getElementById(id);
            child.style.animation = "slide-rev .2s linear 1";
            setTimeout(() => {
                child.style.display = "none";
            }, 190);

        });
    });

    /*const userToolTips = document.querySelectorAll(".profile .info");
    userToolTips.forEach(toolTip =>{
        let tt = toolTip.cloneNode(true);
        toolTip.remove();
        document.body.appendChild(tt);
    });*/

    const like_btns = document.querySelectorAll(".clickable");
    like_btns.forEach(btns =>{
        btns.addEventListener('click', e=>{
            let data_id = btns.getAttribute("data-id");

            $.post("../_conf/system/php/scripts/backend_account.php",{
                func: "post",
                type: "like",
                postID: data_id
            }, data =>{

                if(data !== "false"){
                    btns.classList.remove("clickable");
                    btns.classList.add("active");
                    btns.nextSibling.innerHTML = "<span>"+data+"</span>";
                }
            });
        });
    });

}