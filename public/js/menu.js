let menu_button = document.getElementsByClassName('menu-btn');
let menu = document.getElementsByClassName('menu');
let close = document.getElementsByClassName('close');


menu_button[0].addEventListener('click' , () => {
    menu_button[0].classList.remove('on');
    menu[0].classList.add('on');
});

close[0].addEventListener('click' , () => {
    menu[0].classList.remove('on');
    menu_button[0].classList.add('on');
});

