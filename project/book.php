<?php
include 'config.php';
if (session_status() == PHP_SESSION_NONE) {
  session_start();
} else {
  
}
$user_id = $_SESSION['user_id'];
if (isset($_GET['id'])) {
   $id = $_GET['id'];
} else {
   header("Location: shop.php");
   exit();
}
$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0) {
   header("Location: products.php");
   exit();
}
$fetch_products = mysqli_fetch_assoc($result);
if(isset($_POST['add_to_cart'])){
  $product_name = $_POST['product_name'];
  $product_id = mysqli_query($conn, "SELECT `id` FROM `products` WHERE `name` = '$product_name' ") or die(mysqli_error($conn));
  if(mysqli_num_rows($product_id) > 0){
     while($fetch_products = mysqli_fetch_assoc($product_id)){
        $id = $fetch_products['id'];
     }
  }
  $product_price = $fetch_products['price'];
  $product_image = $fetch_products['image'];
  $product_quantity = $_POST['product_quantity'];
  $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$id' AND user_id = '$user_id'") or die(mysqli_error($conn));
  if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'уже добавлено в корзину!';
  }else{
     mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, price, quantity, image) VALUES('$user_id', '$id', '$product_price', '$product_quantity', '$product_image')") or die(mysqli_error($conn));
      $message[] = 'товар добавлен в корзину!';
  }
}
  $select_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY name") or die(mysqli_error($conn));
  $query = "SELECT rating FROM reviews WHERE product_id = $id";
      $result_rating = mysqli_query($conn, $query);
      $ratings = mysqli_fetch_all($result_rating, MYSQLI_ASSOC);
      $sum = 0;
      foreach ($ratings as $rating) {
         $sum += $rating['rating'];
      }
      if (count($ratings) > 0 ) {
         $average_rating = $sum / count($ratings);
      }
      else {
         $average_rating = 0;
      }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo $fetch_products['name']; ?></title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php include 'header.php'; ?>
      <div class="catalog-book__item">
         <form action="" method="post" class="catalog-book__product">
         <div class="book_image">
            <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="product__img">
            <input type="number" min="1" name="product_quantity" value="1" class="qty">
            <?php if(isset($user_id)) { ?>
            <input type="submit" value="В корзину" name="add_to_cart" class="btn">
         <?php } else { ?>
            <input type="submit" value="В корзину" name="add_to_cart" class="btn" disabled>
         <?php } ?>
         </div>
         <div class="product__content">
            <h3 class="product__title"><?php echo $fetch_products['name']; ?>
               <span class="product__price-value" > ( <?php echo number_format($average_rating, 1); ?>)</span>
            </h3>
            <p class="product__description"><?php echo $fetch_products['author']; ?></p>
            <span class="product__price-value" ><?php echo $fetch_products['price']; ?> руб</span>
            <p class="description-book"><?php echo $fetch_products['description']; ?></p>
            <a href="rewiew.php?id=<?php echo $fetch_products['id']; ?>" class="option-btn">Смотреть отзывы</a>
         </div>
         </form>
      </div>
   <?php include 'footer.php'; ?>
   <script src="js/script.js"></script>
</body>
</html>
