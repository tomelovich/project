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
var link = document.getElementById("openModal");
var modal = document.getElementById("myModal");

// Получаем элемент для закрытия модального окна
var close = document.getElementsByClassName("close")[0];

// Добавляем обработчик события клика на ссылку
link.onclick = function() {
  modal.style.display = "block"; // Показываем модальное окно
}

// Добавляем обработчик события клика на кнопку закрытия
close.onclick = function() {
  modal.style.display = "none"; // Скрываем модальное окно
}

// Добавляем обработчик события клика вне модального окна
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none"; // Скрываем модальное окно
  }
}


//чат
// Обработка отправки сообщений
document.getElementById('message-form').addEventListener('submit', function(event) {
   event.preventDefault();

   var formData = new FormData(this);

   var xhr = new XMLHttpRequest();
   xhr.open('POST', 'send-message.php', true);
   xhr.onload = function() {
      if (xhr.status === 200) {
         // Очищение формы после успешной отправки
         document.getElementById('message-form').reset();
      } else {
         console.error(xhr.responseText);
      }
   };
   xhr.send(formData);
});

// Обновление блока с сообщениями
function updateMessages() {
   var xhr = new XMLHttpRequest();
   xhr.open('GET', 'load-messages.php', true);
   xhr.onload = function() {
      if (xhr.status === 200) {
         var messageContainer = document.getElementById('message-container');
         messageContainer.innerHTML = xhr.responseText;
      } else {
         console.error(xhr.responseText);
      }
   };
   xhr.send();
}

// Обновление сообщений каждые 5 секунд
setInterval(updateMessages, 5000);
