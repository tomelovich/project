<?php
session_start();
include 'config.php';

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

if (isset($_POST['submit'])) {
   $review_id = $_POST['review_id'];
   $reply_text = $_POST['reply_text'];

   // Проверка наличия отзыва и текста ответа
   if (!empty($review_id) && !empty($reply_text)) {
      $reply_text = mysqli_real_escape_string($conn, $reply_text);
      $date = date('Y-m-d H:i:s');

      // Вставка ответа администратора в таблицу admin_replies
      $insert_reply = mysqli_query($conn, "INSERT INTO admin_replies (review_id, reply_text, date) VALUES ('$review_id', '$reply_text', '$date')");

      if ($insert_reply) {
         echo "Ответ успешно сохранен.";
      } else {
         echo "Ошибка при сохранении ответа.";
      }
   } else {
      echo "Пожалуйста, заполните все поля.";
   }
}

// Перенаправление обратно на страницу с отзывами после отправки ответа
header('location:admin_rewiews.php');
?>
