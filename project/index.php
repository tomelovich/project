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
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, price, quantity, image) VALUES('$user_id', '$id', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Kniga shop</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php include 'header.php'; ?>
   <section class="home">
      <div class="content">
         <h3>Любить чтение — это обменивать часы скуки, неизбежные в жизни, на часы большого наслаждения.</h3>
         <p>— Цицерон</p>
      </div>
   </section>
   <section class="products">
      <h1 class="title">Новинки</h1>
      <div class="box-container">
         <?php  
            $select_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY id DESC LIMIT 6") or die('query failed');
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
      <div class="load-more" style="margin-top: 2rem; text-align:center">
         <a href="shop.php" class="option-btn">Загрузить ещё</a>
      </div>
   </section>
   <section class="about">
      <div class="flex">
         <div class="image">
            <img src="./images/img/header/логотип.svg" alt="">
         </div>
         <div class="content about-box">
            <h3>О нас</h3>
            <p>Мы - это интернет-магазин, занимающийся продажей книг. Наша компания была основана в 2022 году с целью предоставить покупателям широкий выбор литературы и удобный сервис покупок.</p>
            <a href="about.php" class="btn">Подробнее</a>
         </div>
      </div>
   </section>
   <section class="home-contact">
      <div class="content">
         <h3>ЕСТЬ ВОПРОСЫ?</h3>
         <a href="contact.php" class="white-btn">связаться с нами</a>
      </div>
   </section>
   <?php include 'footer.php'; ?>
   <script src="js/script.js"></script>
</body>
</html>
