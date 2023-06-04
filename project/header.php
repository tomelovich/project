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

<header class="header">
   <div class="header-2">
      <div class="flex">
         <a href="index.php" class="logo"><img src="./images/img/header/логотип.svg" width="80px" alt=""></a>

         <nav class="navbar">
            <a href="index.php">Главная</a>
            <a href="about.php">О нас</a>
            <a href="shop.php">Каталог</a>
            
            <?php
               if (isset($_SESSION['user_name']) != "") {
                  echo '<a href="contact.php">Связаться с нами</a>';
                  echo '<a href="orders.php">Мои заказы</a>';
               }
            ?>
            
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               if (isset($user_id)) {
                  $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die(mysqli_error($conn));
                  $cart_rows_number = mysqli_num_rows($select_cart_number); 
                  echo '<a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>('.$cart_rows_number.')</span> </a>';
               }
            ?>
         </div>

         <div class="user-box">
            <?php
               if (isset($_SESSION['user_name']) != "") {
                  echo '<p>Имя : <span>'.$_SESSION['user_name'].'</span></p>';
                  echo '<p>Email : <span>'.$_SESSION['user_email'].'</span></p>';
                  echo '<a href="logout.php" class="delete-btn">Выйти</a>';
               } else {
                  // Содержимое, когда пользователь не авторизован
                  echo '<p>Пожалуйста, войдите или зарегистрируйтесь</p>';
                  echo '<a href="login.php" class="btn">Войти</a>';
               }
            ?>
         </div>
      </div>
   </div>
</header>