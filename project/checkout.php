<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, $_POST['city'].', '. $_POST['street'].', № '. $_POST['flat'].' - '. $_POST['pin_code']);
   $placed_on = date("d.m.Y");

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query) ){
         $product_id = $cart_item['product_id'];
         $product_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id'") or die('query failed');
         while($product_item = mysqli_fetch_assoc($product_query)){
            $cart_products[] = $product_item['name'].' ('.$cart_item['quantity'].') ';
         }
        
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'Ваша корзина пуста!';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'заказ уже сделан!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $id_order = mysqli_insert_id($conn);


         $cart = mysqli_query($conn, "SELECT product_id, quantity FROM cart") or die(mysqli_error($conn));
         if(mysqli_num_rows($cart) > 0){
            while($cart_item = mysqli_fetch_assoc($cart)){
               mysqli_query($conn, "INSERT INTO `order_products` (`order_id`, `product_id`, `quantity_products`) VALUES ('$id_order', '{$cart_item['product_id']}', '{$cart_item['quantity']}')") or die('query faailed');
               
            }
         }
         
         
        
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         $message[] = "Ваш заказ принят!";
      }
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Оформление заказа</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Оформлние заказа</h3>
</div>

<section class="display-order">

    <?php  
    /*
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
             */
   ?>
   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $product_id = $fetch_cart['product_id'];
            $product_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id'") or die('query failed');
            while($product_item = mysqli_fetch_assoc($product_query)){
               $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
               $grand_total += $total_price;
   ?>
   <p> <?php echo $product_item['name']; ?> <span>(<?php echo $fetch_cart['price'].' руб'.' x '. $fetch_cart['quantity']; }?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">Ваша корзина пуста</p>';
   }
   ?>
   <div class="grand-total"> Общая стоимость : <span><?php echo $grand_total; ?> руб</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>Детали заказа</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Имя :</span>
            <input type="text" name="name" required placeholder="введите ваше имя">
         </div>
         <div class="inputBox">
            <span>Номер телефона :</span>
            <input type="number" name="number" required placeholder="введите ваш номер телефона">
         </div>
         <div class="inputBox">
            <span>Email :</span>
            <input type="email" name="email" required placeholder="введите ваш email">
         </div>
         <div class="inputBox">
            <span>Способ оплаты :</span>
            <select name="method">
               <option value="cash on delivery">Наличными курьеру</option>
               <option value="credit card">Карточкой</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Город :</span>
            <input type="text" name="city" required placeholder="например: Борисов">
         </div>
         <div class="inputBox">
            <span>Улица :</span>
            <input type="text" name="street" required placeholder="например: Ленина">
         </div>
         <div class="inputBox">
            <span>Номер дома :</span>
            <input type="number" min="0" name="flat" required placeholder="например: 13">
         </div>  
         <div class="inputBox">
            <span>Индекс :</span>
            <input type="number" min="0" name="pin_code" required placeholder="например: 230009">
         </div>
      </div>
      <input type="submit" value="Оформить" class="btn" name="order_btn">
   </form>

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>