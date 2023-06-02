l
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
