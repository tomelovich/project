<?php
    // Подключение к базе данных
    include 'config.php';

    if (session_status() == PHP_SESSION_NONE) {
    // Сессии еще не запущены
    // Можно выполнить инициализацию сессии
    session_start();
    } else {
    // Сессия уже запущена
    }

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
    header('location:login.php');
    }
    // Получение ID товара из параметра URL-адреса
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        // Если ID не указан, перенаправляем пользователя на страницу со списком товаров
        header("Location: shop.php");
        exit();
    }

    // Запрос для получения информации о товаре из базы данных
    $sql = "SELECT * FROM reviews WHERE product_id = $id";
    $result = mysqli_query($conn, $sql);

    
    $sql = "SELECT * FROM users WHERE id = $user_id ";
    $result_user = mysqli_query($conn, $sql);

    // if (mysqli_num_rows($result) == 0) {
    //     header("Location: products.php");
        
    //     exit();
    // }
    $fetch_user = mysqli_fetch_assoc($result_user);
    $fetch_reviews = mysqli_fetch_assoc($result);
    $date = date("d.m.Y H:i:s");
if(isset($_POST['post_review'])){

    $name = mysqli_real_escape_string($conn, $fetch_user['name']);
    $text = $_POST['text'];
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
 
    $select_review = mysqli_query($conn, "SELECT * FROM `reviews` WHERE user_id = '$user_id' AND product_id = '$id'") or die(mysqli_error($conn));
 
    if(mysqli_num_rows($select_review) > 0){
       $message[] = 'Вы уже оставляли отзыв!';
    }else{
       mysqli_query($conn, "INSERT INTO `reviews`(product_id, rating, user_id, text, date) VALUES('$id', '$rating', '$user_id', '$text', '$date')") or die(mysqli_error($conn));
       $message[] = 'Отзыв опубликован!';
    }
 
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Отзывы на товар</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
       
<?php include 'header.php'; ?>
    
    <h2 class="title">Отзывы</h2>
    <a href="#" id="openModal">Оставить отзыв</a>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Оставьте отзыв о товаре</h1>

        <form method="post" action="">
            <div class="rating-area">
                <input type="radio" id="star-5" name="rating" value="5">
                <label for="star-5" title="Оценка «5»"></label>	
                <input type="radio" id="star-4" name="rating" value="4">
                <label for="star-4" title="Оценка «4»"></label>    
                <input type="radio" id="star-3" name="rating" value="3">
                <label for="star-3" title="Оценка «3»"></label>  
                <input type="radio" id="star-2" name="rating" value="2">
                <label for="star-2" title="Оценка «2»"></label>    
                <input type="radio" id="star-1" name="rating" value="1">
                <label for="star-1" title="Оценка «1»"></label>
            </div>
            <div class="review_content">
                <label>Комментарий</label>
                <textarea name="text" rows="10"></textarea>
                <button type="submit" class="btn" value="Опубликовать" name="post_review">Опубликовать</button>
            </div>
            
        </form>
    </div>
</div>
 
<?php  
    $select_reviews = mysqli_query($conn, "SELECT * FROM `reviews` WHERE product_id = '$id' ORDER BY id DESC") or die(mysqli_error($conn));
    if(mysqli_num_rows($select_reviews) > 0){
    while($fetch_reviews = mysqli_fetch_assoc($select_reviews)){
?>
<div class="rating-items">
		
	<div class="rating-mini">
		<span class="<?php if (ceil($fetch_reviews['rating']) >= 1) echo 'active'; ?>"></span>	
		<span class="<?php if (ceil($fetch_reviews['rating']) >= 2) echo 'active'; ?>"></span>    
		<span class="<?php if (ceil($fetch_reviews['rating']) >= 3) echo 'active'; ?>"></span>  
		<span class="<?php if (ceil($fetch_reviews['rating']) >= 4) echo 'active'; ?>"></span>    
		<span class="<?php if (ceil($fetch_reviews['rating']) >= 5) echo 'active'; ?>"></span>
	</div>
    <p><?php echo $fetch_reviews['text']; ?></p>
	<p><?php echo $fetch_user['name']; ?> </p> <p><?php echo $fetch_reviews['date']; ?></p>
</div>
<?php
         }
      }else{
         echo '<p class="empty">Нет отзывов!</p>';
      }
      ?>
        <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
</body>

</html>