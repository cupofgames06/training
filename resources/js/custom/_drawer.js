import { Drawer } from 'flowbite';
// set the drawer menu element
const element = document.getElementById('drawer-menu');
const btn = document.getElementById('btn-drawer');
const btnclose = document.getElementById('btn-drawer-close');

// options with default values
const options = {
    onHide: () => {
        console.log('drawer is hidden');
        $(btn).removeClass('hidden');
        $(btnclose).addClass('hidden');
    },
    onShow: () => {
        console.log('drawer is shown');
        $(btn).addClass('hidden');
        $(btnclose).removeClass('hidden');
    },
};
const drawer = new Drawer(element, options);

btn.addEventListener("click", function(){
    drawer.show();
});
btnclose.addEventListener("click", function (){
    drawer.hide();
})
