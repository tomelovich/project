<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
   header('location:login.php');
}
$product_id = $_GET['product_id'];
$rating = $_GET['rating'];
$time_filter = $_GET['time_filter'];
$query = "SELECT r.*, u.name AS user_name, p.name AS product_name FROM `reviews` r ";
$query .= "JOIN `users` u ON r.user_id = u.id ";
$query .= "JOIN `products` p ON r.product_id = p.id ";
$query .= "WHERE 1 ";
if (!empty($product_id)) {
   $query .= "AND r.product_id = '$product_id' ";
}
if (!empty($rating)) {
   $query .= "AND r.rating = '$rating' ";
}
if (!empty($time_filter)) {
   $current_date = date('d.m.Y');
   switch ($time_filter) {
      case 'today':
         $query .= "AND DATE_FORMAT(STR_TO_DATE(r.date, '%d.%m.%Y'), '%d.%m.%Y') = '$current_date' ";
         break;
      case 'week':
         $week_start = date('d.m.Y', strtotime('-1 week'));
         $query .= "AND STR_TO_DATE(r.date, '%d.%m.%Y') >= STR_TO_DATE('$week_start', '%d.%m.%Y') ";
         break;
      case 'month':
         $month_start = date('d.m.Y', strtotime('-1 month'));
         $query .= "AND STR_TO_DATE(r.date, '%d.%m.%Y') >= STR_TO_DATE('$month_start', '%d.%m.%Y') ";
         break;
   }
}
$select_reviews = mysqli_query($conn, $query) or die('query failed');
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `rewiews` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_rewiews.php');
}
if(isset($_GET['delete_reply'])){
   $delete_id = $_GET['delete_reply'];
   mysqli_query($conn, "DELETE FROM `admin_replies` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_rewiews.php');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Отзывы</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
   <?php include 'admin_header.php'; ?>
   <section class="rewiews">
      <h1 class="title">Отзывы на товары</h1>
      <div class="filter">
      <button class="filter-toggle-btn" aria-expanded="true">
      <span class="arrow-down"></span>
      <span class="arrow-up"></span>
   </button>
         <h3>Фильтровать по товару, рейтингу и времени</h3>
         <form action="" method="GET">
            <select name="product_id">
               <option value="">Выберите товар</option>
               <?php
               $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
               while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                  $product_id = $fetch_products['id'];
                  $product_name = $fetch_products['name'];
                  $selected = ($_GET['product_id'] == $product_id) ? 'selected' : '';
                  echo "<option value='$product_id' $selected>$product_name</option>";
               }
               ?>
            </select>
            <select name="rating">
               <option value="">Выберите рейтинг</option>
               <?php
               $ratings = array(1, 2, 3, 4, 5);
               foreach ($ratings as $rating) {
                  $selected = ($_GET['rating'] == $rating) ? 'selected' : '';
                  echo "<option value='$rating' $selected>$rating ★</option>";
               }
               ?>
            </select>
            <select name="time_filter">
               <option value="">Выберите временной фильтр</option>
               <option value="today" <?php echo ($_GET['time_filter'] == 'today') ? 'selected' : ''; ?>>Сегодня</option>
               <option value="week" <?php echo ($_GET['time_filter'] == 'week') ? 'selected' : ''; ?>>За неделю</option>
               <option value="month" <?php echo ($_GET['time_filter'] == 'month') ? 'selected' : ''; ?>>За месяц</option>
            </select>
            <button type="submit" class="btn">Применить фильтр</button>
         </form>
      </div>
      <div class="box-container">
         <?php
         if (mysqli_num_rows($select_reviews) > 0) {
            while ($fetch_reviews = mysqli_fetch_assoc($select_reviews)) {
               $user_name = $fetch_reviews['user_name'];
               $product_name = $fetch_reviews['product_name'];
         ?>
               <div class="box">
                  <p>Товар: <span><?php echo $product_name; ?></span></p>
                  <p>user id: <span><?php echo $fetch_reviews['user_id']; ?></span></p>
                  <p>Имя пользователя: <span><?php echo $user_name; ?></span></p>
                  <p>Рейтинг: <span><?php echo $fetch_reviews['rating'] . " ★"; ?></span></p>
                  <p>Дата: <span><?php echo $fetch_reviews['date']; ?></span></p>
                  <p>Текст сообщения: <span><?php echo $fetch_reviews['text']; ?></span></p>
                  <?php
                  $review_id = $fetch_reviews['id'];
                  $reply_feedback = mysqli_query($conn, "SELECT * FROM admin_replies WHERE review_id = '$review_id'") or die('query failed');
                  if (mysqli_num_rows($reply_feedback) > 0) {
                     $fetch_feedback = mysqli_fetch_assoc($reply_feedback);
                     ?>
                     <div class="admin-reply">
                        <p>Ответ администратора: <span><?php echo $fetch_feedback['reply_text']; ?></span></p>
                        <a href="admin_rewiews.php?delete_reply=<?php echo $fetch_feedback['id']; ?>" onclick="return confirm('Удалить ответ?');" class="delete-btn">Удалить ответ</a>
                     </div>
                      <?php } else { ?>
                     <a href="#" class="btn openModal" data-review-id="<?php echo $review_id; ?>">Ответить</a>
                  <?php } ?>
                  <div id="myModal-<?php echo $review_id; ?>" class="modal">
                     <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1>Оставьте отзыв о товаре</h1>
                        <form action="admin_reply_submit.php" method="POST">
                           <input type="hidden" name="review_id" value="<?php echo $review_id; ?>">
                           <textarea name="reply_text" placeholder="Введите ваш ответ" required></textarea>
                           <button type="submit" name="submit" class="btn">Отправить</button>
                        </form>
                     </div>
                  </div>
                  <a href="admin_rewiews.php?delete=<?php echo $review_id; ?>" onclick="return confirm('Удалить этот отзыв?');" class="delete-btn">Удалить</a>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">У вас нет отзывов!</p>';
         }
         ?>
      </div>
   </section>
   <script src="js/admin_script.js"></script>
</body>
</html>
