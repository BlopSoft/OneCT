var menuopen = 0;

function showmenu(){
    var menu = document.getElementById('menu');
    var icon = document.getElementById('detailicon');

    if(menuopen == 0){
        menu.style = "display: block;";
        icon.src = "../imgs/open.gif";
        menuopen = 1;
    } else if(menuopen == 1){
        menu.style = "display: none;";
        icon.src = "../imgs/close.gif";
        menuopen = 0;
    }
}