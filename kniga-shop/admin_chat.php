<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
   header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Пользователи</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
   <?php include 'admin_header.php'; ?>
   <section class="users">
      <h1 class="title"> Чаты </h1>
      <div class="box-container">
         <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_type` = 'user'") or die('query failed');
            while($fetch_users = mysqli_fetch_assoc($select_users)){
               $user_id = $fetch_users['id'];
               // Запрос для получения количества сообщений без ответа для данного пользователя
               $count_unanswered = mysqli_query($conn, "SELECT COUNT(*) AS unanswered_count FROM `message` m LEFT JOIN `message_reply` r ON m.id = r.message_id WHERE m.`user_id` = '$user_id' AND r.`reply_text` IS NULL") or die('query failed');
               $fetch_count = mysqli_fetch_assoc($count_unanswered);
               $unanswered_count = $fetch_count['unanswered_count'];
         ?>
         <form class="box" action="user_message.php" method="POST">
            <button type="submit">
               <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
               <p> Имя : <span><?php echo $fetch_users['name']; ?></span> </p>
               <p> email : <span><?php echo $fetch_users['email']; ?></span> </p>
               <?php if ($unanswered_count > 0) { ?>
                  <p> Неотвеченные сообщения: <span><?php echo $unanswered_count; ?></span> </p>
               <?php } ?>
            </button>
         </form>
         <?php
            };
         ?>
      </div>
   </section>
   <script src="js/admin_script.js"></script>
</body>
</html>
