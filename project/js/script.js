let userBox = document.querySelector('.header .header-2 .user-box');

document.querySelector('#user-btn').onclick = () =>{
   userBox.classList.toggle('active');
   navbar.classList.remove('active');
}

// let parent = document.querySelector('.catalog-nav__wrapper');
// let menuItem = parent.querySelectorAll('.catalog-nav__btn');


// parent.addEventListener('click', (event) => {
//   // Отлавливаем элемент в родители на который мы нажали
//   let target = event.target;
  
//     for(let i = 0; i < menuItem.length; i++) {
//       // Убираем у других
//       menuItem[i].classList.remove('is-active');
//     }
//     // Добавляем тому на который нажали
//     target.classList.add('is-active');
//   }
  
// );


let navbar = document.querySelector('.header .header-2 .navbar');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   userBox.classList.remove('active');
}

window.onscroll = () =>{
   userBox.classList.remove('active');
   navbar.classList.remove('active');

   if(window.scrollY > 60){
      document.querySelector('.header .header-2').classList.add('active');
   }else{
      document.querySelector('.header .header-2').classList.remove('active');
   }
}