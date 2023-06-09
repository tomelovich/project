<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if(isset($_POST['add_to_cart'])){
   $product_name = $_POST['product_name'];
   $product_id = mysqli_query($conn, "SELECT `id` FROM `products` WHERE `name` = '$product_name' ") or die('query failed');
   if(mysqli_num_rows($product_id) > 0){
      while($fetch_products = mysqli_fetch_assoc($product_id)){
         $id = $fetch_products['id'];
      }
   }
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];
   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$id' AND user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'уже добавлено в корзину!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, price, quantity, image) VALUES('$user_id', '$id', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'товар добавлен в корзину!';
   }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Поиск товара</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php include 'header.php'; ?>
   <div class="heading">
      <h3>Поиск...</h3>
   </div>
   <section class="search-form">
      <form action="" method="post">
         <input type="text" name="search" placeholder="Название книги" class="box" autocomplete="off" onkeyup="handleSearchInput(this.value)">
         <input type="submit" name="submit" value="Искать" class="btn">
         <div id="suggestions-container"></div>
      </form>
   </section>
   <section class="products" style="padding-top: 0;">
      <div class="box-container">
      <?php
         if(isset($_POST['submit'])){
            $search_item = $_POST['search'];
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%'") or die('query failed');
            if(mysqli_num_rows($select_products) > 0){
            while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="post" class="box">
         <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" class="image">
         <div class="name"><a title="<?php echo $fetch_product['name']; ?>" href="book.php?id=<?php echo $fetch_product['id']; ?>"><?php echo $fetch_product['name']; ?></a></div>
         <div class="price"><?php echo $fetch_product['price']; ?> руб</div>
         <input type="number"  class="qty" name="product_quantity" min="1" value="1">
         <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
         <input type="submit" class="btn" value="В корзину" name="add_to_cart">
      </form>
      <?php
               }
            }else{
               echo '<p class="empty">Товар отсутствует, либо название введено не верно!</p>';
            }
         }else{
            echo '<p class="empty">Введите название книги!</p>';
         }
      ?>
      </div>
   </section>
   <?php include 'footer.php'; ?>
   <script src="js/script.js"></script>
</body>
</html>
