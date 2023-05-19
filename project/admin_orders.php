<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'payment status has been updated!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
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

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">РАЗМЕЩЕННЫЕ ЗАКАЗЫ</h1>
   <a href="admin_completed_orders.php" class="btn btn_ord">История заказов</a>

   <div class="box-container">
      <?php
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status= 'В ожидании'") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
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
         <p> user id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> размещён : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> имя : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> номер : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> адрес : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> книги : <span><?php echo $products_list ?></span> </p>
         <p> общая стоимость : <span><?php echo $fetch_orders['total_price']; ?> руб</span> </p>
         <p> способ оплаты : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="В ожидании">В ожидании</option>
               <option value="Завершен">Завершен</option>
            </select>
            <input type="submit" value="Обновить" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Удалить этот заказ?');" class="delete-btn">Удалить</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">заказы еще не размещены!</p>';
      }
      ?>
   </div>

</section>










<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>