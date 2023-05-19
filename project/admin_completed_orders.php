<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>История заказов</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">ЗАВЕРШЕННЫЕ ЗАКАЗЫ</h1>
   
   

   <div class="box-container form-income">
      <?php
      $total_income = 0;
      $start_date = mysqli_real_escape_string($conn, $_GET['start_date']);
      $end_date = mysqli_real_escape_string($conn, $_GET['end_date']);
      if (!empty($start_date) && !empty($end_date)) {
        $select_orders = mysqli_query($conn, "SELECT * FROM orders WHERE  payment_status= 'Завершен' AND placed_on BETWEEN '$start_date' AND '$end_date'") or die(mysqli_error($conn));
      }
      else{
        $select_orders = mysqli_query($conn, "SELECT * FROM orders WHERE  payment_status= 'Завершен'") or die(mysqli_error($conn));
      } ?>
      

     
   
   <?php
   $total_income = 0;
   if (mysqli_num_rows($select_orders) > 0) {
      while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
         
         $total_income += $fetch_orders['total_price'];

         $order_id = $fetch_orders['id']; 

         $sql_products = "SELECT GROUP_CONCAT(CONCAT(p.name, ' (', op.quantity_products, ')') SEPARATOR ', ') AS products_list
         FROM order_products AS op
         INNER JOIN products AS p ON op.product_id = p.id
         WHERE op.order_id = $order_id";
         $result_products = mysqli_query($conn, $sql_products);

         if ($result_products && mysqli_num_rows($result_products) > 0) {
            $row_products = mysqli_fetch_assoc($result_products);
            $products_list = $row_products['products_list'];
         }
         ?>
      <div class="box">
         <p> user id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> размещён : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> имя : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> номер : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> адрес : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> книги : <span><?php echo $products_list ?></span> </p>
         <p> общая стоимость : <span><?php echo $fetch_orders['total_price']; ?> руб</span> </p>
         <p> способ оплаты : <span><?php echo $fetch_orders['method']; ?></span> </p>
         
      </div>
      
      <?php
         }
      }else{
         echo '<p class="empty">Заказы отсутствуют!</p>';
      }
      ?>
   </div>
   <div class="form-container">
        <form method="GET" action="">
            <div class="label_input">
               <label for="start_date">С:</label>
               <input type="date" name="start_date" id="start_date">
            </div>           
            <div class="label_input">
               <label for="end_date">По:</label>
               <input type="date" name="end_date" id="end_date">
            </div>
            <button type="submit" class="btn">Применить</button>
        </form>
        
    </div>
   <div class="statistics">
      <h3>Общий заработок за выбранный период</h3>
      <p><?php echo $total_income . ' руб'; ?></p>
   </div>
</section>










<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>