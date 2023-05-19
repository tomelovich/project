<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};
if(isset($_POST['submit_message'])){
   $message_id = $_POST['message_id'];
   $reply_text = mysqli_real_escape_string($conn, $_POST['reply_text']);

   // Получение информации о сообщении пользователя
   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE id = '$message_id'") or die(mysqli_error($conn));
   $fetch_message = mysqli_fetch_assoc($select_message);
   $user_id = $fetch_message['user_id'];
   $user_name = $fetch_message['name'];
   $user_email = $fetch_message['email'];

   // Вставка ответа в базу данных
   mysqli_query($conn, "INSERT INTO `message_reply` (message_id, admin_id, reply_text, timestamp) VALUES ('$message_id', '$admin_id', '$reply_text', NOW())") or die(mysqli_error($conn));

   // Перенаправление обратно на страницу администратора
   header('location: admin_contacts.php');
}
?>
