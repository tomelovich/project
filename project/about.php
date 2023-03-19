<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>О нас</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>О нас</h3>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="./images/img/header/логотип.svg" alt="">
      </div>

      <div class="content">
         <h3>О магазине</h3>
         <p>Мы - это интернет-магазин, занимающийся продажей книг. Наша компания была основана в 2022 году с целью предоставить покупателям широкий выбор литературы и удобный сервис покупок.</p>
         <p>Мы гордимся тем, что предлагаем нашим клиентам только качественную продукцию от проверенных издательств. У нас вы можете найти книги на любую тему – от классики до современной литературы, от научных работ до детских сказок.</p>
         <p>Основная ценность нашей компании – это наша команда. Мы – люди, которые любят книги и понимают ценность чтения. Наша задача – помочь каждому человеку найти книгу, которая его заинтересует и приведет к удовольствию.</p>
         <p>Мы постоянно работаем над тем, чтобы наш магазин был максимально удобным и простым в использовании. Он доступен 24/7, поэтому вы можете сделать заказ в любое удобное для вас время.</p>
         <p>Мы стремимся к тому, чтобы каждый наш клиент был доволен своей покупкой. Поэтому мы предоставляем высококачественный сервис, быструю доставку и гарантию на все товары.</p>
         <p>Мы ценим наших клиентов и всегда идем навстречу их пожеланиям и потребностям. Если у вас есть пожелания, вопросы или предложения – свяжитесь с нами и мы с радостью вам поможем.</p>
         <a href="contact.php" class="btn">Связаться с нами</a>
      </div>

   </div>

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>