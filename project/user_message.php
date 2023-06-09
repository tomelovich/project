<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
   header('location:login.php');
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die(mysqli_error($conn));
   header('location:admin_contacts.php');
}

if (isset($_GET['delete_reply'])) {
   $delete_reply_id = $_GET['delete_reply'];
   mysqli_query($conn, "DELETE FROM `message_reply` WHERE id = '$delete_reply_id'") or die(mysqli_error($conn));
   header('location:admin_contacts.php');
}

// Получение идентификатора пользователя из POST-запроса
if (isset($_POST['user_id'])) {
   $user_id = $_POST['user_id'];

   // Получение информации о пользователе
   $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
   $user = mysqli_fetch_assoc($select_user);

   // Получение сообщений пользователя
   $select_messages = mysqli_query($conn, "SELECT m.*, r.id AS reply_id, r.reply_text, r.timestamp AS reply_timestamp
      FROM `message` m
      LEFT JOIN `message_reply` r ON m.id = r.message_id
      WHERE m.user_id = '$user_id'
      ORDER BY m.timestamp DESC") or die('query failed');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Сообщения пользователя</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
   <?php include 'admin_header.php'; ?>
   <section class="messages">
      <h1 class="title">Сообщения пользователя: <?php echo $user['name']; ?></h1>
      <div class="box-container">
         <?php
         if (mysqli_num_rows($select_messages) > 0) {
            while ($fetch_message = mysqli_fetch_assoc($select_messages)) {
         ?>
               <div class="box">
                  <p>Имя: <span><?php echo $fetch_message['name']; ?></span></p>
                  <p>email: <span><?php echo $fetch_message['email']; ?></span></p>
                  <p>Текст сообщения: <span><?php echo $fetch_message['message']; ?></span></p>
                  <p class="timestamp">Отправлено: <?php echo $fetch_message['timestamp']; ?></p>
                  <?php if ($fetch_message['reply_text']) { ?>
                     <div class="admin-reply">
                        <p>Ответ администратора: <span><?php echo $fetch_message['reply_text']; ?></span></p>
                        <p class="timestamp">Отправлено: <?php echo $fetch_message['reply_timestamp']; ?></p>
                        <a href="user_message.php?delete_reply=<?php echo $fetch_message['reply_id']; ?>&user_id=<?php echo $user_id; ?>" onclick="return confirm('Удалить ответ?');" class="delete-btn">Удалить ответ</a>
                     </div>
                  <?php } else { ?>
                     <a href="#" class="btn openModal" data-review-id="<?php echo $fetch_message['id']; ?>">Ответить</a>
                  <?php } ?>
                  <div id="myModal-<?php echo $fetch_message['id']; ?>" class="modal">
                     <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1>Ответ на сообщение</h1>
                        <form action="admin_reply.php" method="POST">
                           <input type="hidden" name="message_id" value="<?php echo $fetch_message['id']; ?>">
                           <textarea name="reply_text" placeholder="Введите ваш ответ" required></textarea>
                           <button type="submit" name="submit_message" class="btn">Отправить</button>
                        </form>
                     </div>
                  </div>
               </div>
         <?php
            };
         } else {
            echo '<p class="empty">У пользователя нет сообщений!</p>';
         }
         ?>
      </div>
   </section>
   <script src="js/admin_script.js"></script>
</body>
</html>
