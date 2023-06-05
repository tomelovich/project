let userBox = document.querySelector('.header .header-2 .user-box');

document.querySelector('#user-btn').onclick = () =>{
   userBox.classList.toggle('active');
   navbar.classList.remove('active');
}


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

function handleCityInput() {
   var cityInput = document.getElementById('city');
   var city = cityInput.value.trim();

   if (city.length >= 2) {
      var xhr = new XMLHttpRequest();
      var url = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address';
      xhr.open('POST', url, true);
      xhr.setRequestHeader('Authorization', 'Token 6ddf0fad2849dee12456fc362586aa8133f01042');
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.setRequestHeader('Accept', 'application/json');

      xhr.onreadystatechange = function() {
         if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var suggestions = response.suggestions;
            var suggestionsList = document.getElementById('city-suggestions');
            suggestionsList.innerHTML = '';

            suggestions.forEach(function(suggestion) {
               var li = document.createElement('li');
               li.textContent = suggestion.value;
               li.addEventListener('click', function() {
                  cityInput.value = suggestion.value;
                  suggestionsList.innerHTML = '';
               });
               suggestionsList.appendChild(li);
            });
         }
      };

      var requestData = {
         query: city,
         count: 5,
         "locations": [
            {
                "country_iso_code": "BY"
            }
         ]
      };

      xhr.send(JSON.stringify(requestData));
   } else {
      document.getElementById('city-suggestions').innerHTML = '';
   }
}
