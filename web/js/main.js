function showmenu(){
    var menu = document.getElementById('menu');
    var icon = document.getElementById('detailicon');

    if(menu.style.display === 'none'){
        menu.style.display = 'block';
        icon.src = "../imgs/open.gif";
    } else if(menu.style.display !== 'none'){
        menu.style.display = 'none';
        icon.src = "../imgs/close.gif";
    }
}