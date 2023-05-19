<?php
 include 'config.php';

 if (session_status() == PHP_SESSION_NONE) {
 session_start();
 } else {
 // Сессия уже запущена
 }

 $user_id = $_SESSION['user_id'];

 if(!isset($user_id)){
 header('location:login.php');
 }

if(isset($_GET['message_id'])){
   $message_id = $_GET['message_id'];

   // Получение информации об исходном сообщении пользователя
   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE id = '$message_id'") or die(mysqli_error($conn));
   $fetch_message = mysqli_fetch_assoc($select_message);

   // Получение всех ответов на данное сообщение
   $select_replies = mysqli_query($conn, "SELECT * FROM `message_reply` WHERE message_id = '$message_id'") or die(mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Сообщения</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title">Сообщения</h1>

   <div class="box-container">
      <div class="box">
         <p>Имя: <span><?php echo $fetch_message['name']; ?></span></p>
         <p>Email: <span><?php echo $fetch_message['email']; ?></span></p>
         <p>Номер: <span><?php echo $fetch_message['number']; ?></span></p>
         <p>Сообщение: <span><?php echo $fetch_message['message']; ?></span></p>
      </div>
      <?php
      if(mysqli_num_rows($select_replies) > 0){
         while($fetch_reply = mysqli_fetch_assoc($select_replies)){
      ?>
      <div class="box reply">
         <p>Администратор ID: <span><?php echo $fetch_reply['admin_id']; ?></span></p>
         <p>Ответ: <span><?php echo $fetch_reply['reply_text']; ?></span></p>
         <p>Время: <span><?php echo $fetch_reply['timestamp']; ?></span></p>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Нет ответов на это сообщение!</p>';
      }
      ?>
   </div>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
