<?php

    include 'config.php';
    session_start();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

        if (!$conn) {
            die('Ошибка подключения: ' . mysqli_connect_error());
        }
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        if (!$user) {
            $message[] = 'Пользователь с таким email не зарегистрирован';
        } else {
            $new_password = generate_password();
            $query = "UPDATE users SET password = '" . mysqli_real_escape_string($conn, md5($new_password)) . "' WHERE id = " . $user['id'];
            mysqli_query($conn, $query);
            $subject = 'Восстановление пароля';
            $mail_message = "Ваш новый пароль: $new_password";
            $headers = 'From: kniga.shop.by@gmail.com' . "\r\n" . 'Reply-To: kniga.shop.by@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            mail($email, $subject, $mail_message, $headers);
            $message[] = 'На ваш email отправлено письмо с новым паролем';
        }
        mysqli_close($conn);
    }

    function generate_password($length = 10) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $password;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Восстановление пароля</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
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
    
    <form method="POST" action="recovery.php">
        <h3>Восстановление пароля</h3>
        <input type="email" id="email" name="email" placeholder="Email" required class="box">
        <button type="submit" class="btn">Отправить</button>
        <br>
        <a class="recovery" href="login.php">Вернуться</a>
    </form>
    

</div>

</body>
</html>