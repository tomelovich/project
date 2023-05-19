<?php

   include 'config.php';

   session_start();

   $user_id = $_SESSION['user_id'];

   if(!isset($user_id)){
      header('location:login.php');
   }
   if(isset($_GET['delete'])){
      $delete_id = $_GET['delete'];
      mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die(mysqli_error($conn));
      header('location:orders.php');
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Заказы</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Мои заказы</h3>
   </div>
   <section class="placed-orders">

      <h1 class="title">Последние заказы</h1>

      <div class="box-container">

         <?php
            $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' ORDER BY payment_status ASC, id DESC") or die('query failed');
            if(mysqli_num_rows($order_query) > 0){
               while($fetch_orders = mysqli_fetch_assoc($order_query)){
                  $order_id = $fetch_orders['id']; // Получение идентификатора заказа

               $sql = "SELECT GROUP_CONCAT(CONCAT(p.name, ' (', op.quantity_products, ')') SEPARATOR ', ') AS products_list
               FROM order_products AS op
               INNER JOIN products AS p ON op.product_id = p.id
               WHERE op.order_id = $order_id";
               $result = mysqli_query($conn, $sql);

               if ($result && mysqli_num_rows($result) > 0) {
                  $row = mysqli_fetch_assoc($result);
               $products_list = $row['products_list'];
               }
         ?>
         
         <div class="box">
            <p> дата заказа : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
            <p> Имя : <span><?php echo $fetch_orders['name']; ?></span> </p>
            <p> Номер : <span><?php echo $fetch_orders['number']; ?></span> </p>
            <p> Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
            <p> Адрес : <span><?php echo $fetch_orders['address']; ?></span> </p>
            <p> Способ оплаты : <span><?php echo $fetch_orders['method']; ?></span> </p>
            <p> Товары (кол-во) : <span><?php echo $products_list  ?></span> </p>
            <p> Стоимость : <span><?php echo $fetch_orders['total_price']; ?> руб</span> </p>
            <p> Статус оплаты : <span style="color:<?php if($fetch_orders['payment_status'] == 'В ожидании'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
            <?php
               $status = $fetch_orders['payment_status'];
               if ($status == 'В ожидании') { ?>
               <a href="orders.php?delete=<?php echo $fetch_orders[ 'id']; ?>" onclick="return confirm('Отменить этот заказ?');" class="delete-btn">Отменить</a>
               <?php } ?>
               
         </div>
               
         <?php
               }
         }else{
            echo '<p class="empty">Заказов нет</p>';
         }
         ?>
      </div>

   </section>


   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>
</html>