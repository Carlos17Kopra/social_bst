const underContent = document.getElementById("underContent");

const user_post_btn = document.getElementById("user_posts");
const user_follower_btn = document.getElementById("user_follower");
const user_follows_btn = document.getElementById("user_follows");
const user_friends_btn = document.getElementById("user_friends");

changeContent("user_posts");

user_post_btn.addEventListener('click', e =>{
    changeContent("user_posts");
});
user_follower_btn.addEventListener('click', e=>{
    changeContent("user_follower");
});
user_follows_btn.addEventListener('click', e=>{
    changeContent("user_follows");
});
user_friends_btn.addEventListener('click', e=>{
    changeContent("user_friends");
});
function changeContent(type){

    underContent.setAttribute("data-content", type);
    $.post("../_conf/system/php/scripts/backend_account.php", {
        func: 'underNav',
        type : type
    }, data =>{
        if(data !== false){
            underContent.innerHTML = data;
        }
    });

}