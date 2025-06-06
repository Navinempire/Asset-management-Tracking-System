const wrapper = document.querySelector('.wapper');
const btnpopup = document.querySelector('.btnlogin-popup');
const iconClose = document.querySelector('.icon-close');

btnpopup.addEventListener('click', ()=>{
    wrapper.classList.add('active');
})
iconClose.addEventListener('click',()=>{
    wrapper.classList.remove('active-popup');
})