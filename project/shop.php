<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];


   
if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_id = mysqli_query($conn, "SELECT `id` FROM `products` WHERE `name` = '$product_name' ") or die(mysqli_error($conn));
   if(mysqli_num_rows($product_id) > 0){
      while($fetch_products = mysqli_fetch_assoc($product_id)){
         $id = $fetch_products['id'];
      }
   }
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$id' AND user_id = '$user_id'") or die(mysqli_error($conn));

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, price, quantity, image) VALUES('$user_id', '$id', '$product_price', '$product_quantity', '$product_image')") or die(mysqli_error($conn));
      $message[] = 'product added to cart!';
   }
   }
   $select_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY name") or die(mysqli_error($conn));
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Каталог</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Каталог</h3>
  
</div>

<section class="products">

   <nav class="catalog-nav">
      <form action="" method="post" class="box">
         <ul class="catalog-nav__wrapper">'
            <li class="catalog-nav__item"><button class="catalog-nav__btn" value="all" name="select" type="submit">все</button></li>
            <li class="catalog-nav__item"><button class="catalog-nav__btn" value="book" name="select"  type="submit">книги</button></li>
            <li class="catalog-nav__item"><button class="catalog-nav__btn" name="select" value="manga" type="submit">манга</button></li>
            <li class="catalog-nav__item"><button class="catalog-nav__btn" name="select" value="comics" type="submit">комиксы</button></li>
         </ul>
      </form>   
   </nav>
   
   <div class="box-container">

      <?php
      
    
         $select=$_POST['select'];
         if ($select == "all") {
            $select_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY name") or die(mysqli_error($conn));
         }
         else if ($select == "book") {
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE type_id = 1 ORDER BY name") or die(mysqli_error($conn));
         }
         else if ($select == "manga") {
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE type_id = 2 ORDER BY name") or die(mysqli_error($conn));
         }
         else if ($select == "comics") {
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE type_id = 3 ORDER BY name") or die(mysqli_error($conn));
         }
         
          if(mysqli_num_rows($select_products) > 0){
             while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><a title="<?php echo $fetch_products['name']; ?>" href="book.php?id=<?php echo $fetch_products['id']; ?>"><?php echo $fetch_products['name']; ?></a></div>
      <div class="price"><?php echo $fetch_products['price']; ?> руб</div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <?php if(isset($user_id)) { ?>
      <input type="submit" value="В корзину" name="add_to_cart" class="btn">
      <?php } else { ?>
      <input type="submit" value="В корзину" name="add_to_cart" class="btn" disabled>
      <?php } ?>
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>