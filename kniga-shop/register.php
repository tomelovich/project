<?php
include 'config.php';
if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');
   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'Пользователь уже существует!';
   }else{
      if($pass != $cpass){
         $message[] = 'Подтверждение пароля не совпадает!';
      }else{
         $min_password_length = 8;
         if (strlen($_POST['password']) < $min_password_length) {
            $message[] = 'Пароль должен содержать не менее ' . $min_password_length . ' символов!';
         } else {
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', 'user')") or die('query failed');
            $message[] = 'Регистрация прошла успешно!';
            header('location:login.php');
         }
      }
   }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Регистрация</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   ?>
   <div class="form-container">
      <form action="" method="post">
         <h3>Регистрация</h3>
         <input type="text" name="name" placeholder="Имя" required class="box">
         <input type="email" name="email" placeholder="Email" required class="box">
         <input type="password" name="password" placeholder="Пароль" required minlength="8" class="box">
         <input type="password" name="cpassword" placeholder="Повторите" required class="box">
         <input type="submit" name="submit" value="Зарегистрироваться" class="btn">
         <p>Уже зарегистрированы? <a href="login.php">Авторизация</a></p>
      </form>
   </div>
</body>
</html>
