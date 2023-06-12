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
   if (!empty($review_id) && !empty($reply_text)) {
      $reply_text = mysqli_real_escape_string($conn, $reply_text);
      $date = date('Y-m-d H:i:s');
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
header('location:admin_rewiews.php');
?>
