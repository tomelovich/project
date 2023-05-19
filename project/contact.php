<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}
$sql = "SELECT * FROM users WHERE id = $user_id ";
    $result_user = mysqli_query($conn, $sql);

    
    $fetch_user = mysqli_fetch_assoc($result_user);
if(isset($_POST['send'])){
   $name = $fetch_user['name'];
   $email = $fetch_user['email'];
   $number = $_POST['number'];
   // $timestamp = date('Y-m-d H:i:s');
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND message = '$msg'") or die(mysqli_error($conn));

   if(mysqli_num_rows($select_message) > 0){
      $message[] = 'message sent already!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, message, timestamp) VALUES('$user_id', '$name', '$email', '$msg', NOW())") or die(mysqli_error($conn));
      $message[] = 'message sent successfully!';
   }

}

// Запрос для получения сообщений пользователя и ответов администратора
$sql = "SELECT m.*, r.reply_text, r.timestamp AS reply_timestamp FROM `message` m LEFT JOIN `message_reply` r ON m.id = r.message_id WHERE m.user_id = $user_id";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Связаться с нами</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>есть вопрос?</h3>
</div>

<section class="contact">
   <?php if(isset($message)) { ?>
      <div class="message"><?php echo $message; ?></div>
   <?php } ?>
   <form action="" method="post">
      <h3>связаться с нами</h3>
      
      <textarea name="message" class="box" placeholder="Ваше сообщение" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Отправить" name="send" class="btn">
   </form>

   <h3>Ваши сообщения:</h3>
   <?php
      if(mysqli_num_rows($result) > 0){
         while($row = mysqli_fetch_assoc($result)){
   ?>
      <div class="message-box">
         <p>Ваше сообщение:</p>
         <p><?php echo $row['message']; ?></p>
         <p class="timestamp">Отправлено: <?php echo $row['timestamp']; ?></p>
         <?php if($row['reply_text']) { ?>
            <div class="admin-reply">
               <p>Ответ администратора:</p>
               <p><?php echo $row['reply_text']; ?></p>
               <p class="timestamp">Отправлено: <?php echo $row['reply_timestamp']; ?></p>
               <p class="admin-marker">Администратор</p>
            </div>
            
         <?php } ?>
      </div>
   <?php
         }
      } else {
         echo '<p class="empty">У вас нет сообщений</p>';
      }
   ?>
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
