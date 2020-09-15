const searchWrapper = document.getElementById("searchWrapper");
const searchOpenBtn = document.getElementById("search_open_btn");
const logo = document.querySelectorAll(".logo");

logo.forEach(l =>{
    l.addEventListener('click', e =>{
        window.location.replace("index.php");
    });
})

let h = searchWrapper.offsetHeight;
searchWrapper.style.padding = 0;
searchWrapper.style.height = 0;


searchOpenBtn.addEventListener('click', e=>{
    e.preventDefault();

    let t = e.target;
    if(t.classList.contains("open")){
        t.classList.remove("open");
        $(searchWrapper).animate({"height": 0 + "px"}, 100);
    }else{
        t.classList.add("open");
        searchWrapper.style.transition = ".2s";
        $(searchWrapper).animate({"height": h + "px"}, 100);
    }

});