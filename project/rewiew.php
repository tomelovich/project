<?php
    // Подключение к базе данных
    include 'config.php';

    if (session_status() == PHP_SESSION_NONE) {
    session_start();
    } else {
    // Сессия уже запущена
    }

    $user_id = $_SESSION['user_id'];

  
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

    
    $fetch_user = mysqli_fetch_assoc($result_user);
    $fetch_reviews = mysqli_fetch_assoc($result);
    $id_author = $fetch_reviews['user_id'];
     
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

    $displaying_number = "SELECT COUNT(*) AS num_reviews FROM reviews WHERE product_id = '$id'";
    $number_rev = mysqli_query($conn, $displaying_number);
    $result = mysqli_fetch_array($number_rev);
    $numb_rev = $result['num_reviews'];
    //-----------
    
$results = mysqli_query($conn, $query);

// Создаем массив с процентным соотношением рейтингов
$ratings_percentages = array(
  '5' => 0,
  '4' => 0,
  '3' => 0,
  '2' => 0,
  '1' => 0
);

$total_ratings = mysqli_num_rows($results);

// Считаем количество отзывов для каждого рейтинга
while ($row = mysqli_fetch_assoc($results)) {
  $rating = $row['rating'];
  $ratings_percentages[$rating]++;
}

// Вычисляем процентное соотношение и сохраняем в массиве
foreach ($ratings_percentages as $key => $value) {
  if ($total_ratings > 0) {
    $ratings_percentages[$key] = round(($value / $total_ratings) * 100);
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
    <a href="book.php?id=<?php echo $id ?>" class="openModal">Вернуться на страницу товара</a>
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
                <?php if(isset($user_id)) { ?>
                    <button type="submit" class="btn" value="Опубликовать" name="post_review">Опубликовать</button>
                <?php } else { ?>
                    <button type="submit" class="btn" value="Опубликовать" name="post_review" disabled>Опубликовать</button>
                <?php } ?>
                
            </div>
            
        </form>
    </div>
</div>
<div class="feedback_statistics">
        <div class="rating_book">
            <b>Средняя оценка: <?php echo number_format($average_rating, 1); ?></b>
            <!-- <p><?php echo $numb_rev ?> отзывов</p> -->
            <?php 
                if ($numb_rev == 1) {
                    echo "<p>" . $numb_rev . " отзыв</p>";
                } elseif ($numb_rev > 1 && $numb_rev < 5) {
                    echo "<p>" . $numb_rev . " отзыва</p>";
                } else {
                    echo "<p>" . $numb_rev . " отзывов</p>";
                }
            
            ?>
        </div>
        <div class="rating_scale">
            <div class="number_stars">
                <p>5 звёзд</p>
                <p>4 звёзды</p>
                <p>3 звёзды</p>
                <p>2 звёзды</p>
                <p>1 звёзда</p>
            </div>
            <div class="percentage_scale">
            <?php 
                    foreach ($ratings_percentages as $key => $value) {
                        echo "<progress value=\"$value\" max=\"100\" title=\"Прогресс: $value%\"></progress>";
                    } 
                ?>
            </div>
            <div class="quantity">
                <?php 
                    foreach ($ratings_percentages as $key => $value) {
                        echo "<span>" . $value . "%</span>";
                    } 
                ?>
            </span>
               
            </div>
        </div>
    </div>
    <?php  
$select_reviews = mysqli_query($conn, "SELECT * FROM `reviews` WHERE product_id = '$id' ORDER BY id DESC") or die(mysqli_error($conn));
if(mysqli_num_rows($select_reviews) > 0){
        
    while($fetch_reviews = mysqli_fetch_assoc($select_reviews)){
        $author_id = $fetch_reviews['user_id'];
        $author = "SELECT name FROM users WHERE id = $author_id";
        $result_author = mysqli_query($conn, $author);
        $fetch_author = mysqli_fetch_assoc($result_author);

        // Получение ответа на отзыв
        $review_id = $fetch_reviews['id'];
        $reply_query = "SELECT * FROM admin_replies WHERE review_id = $review_id";
        $reply_result = mysqli_query($conn, $reply_query);
        $fetch_reply = mysqli_fetch_assoc($reply_result);
        $reply_text = $fetch_reply['reply_text'];
        $reply_date = $fetch_reply['date'];
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
    <p><?php echo $fetch_author['name']; ?></p>
    <p><?php echo $fetch_reviews['date']; ?></p>

    <!-- Вывод ответа на отзыв, если он есть -->
    <?php if ($reply_text) { ?>
        <div class="admin-reply">
            <p>Ответ от администратора:</p>
            <p><?php echo $reply_text; ?></p>
            <p><?php echo $reply_date; ?></p>
        </div>
    <?php } ?>
</div>


<?php
    }
} else {
    echo '<p class="empty">Нет отзывов!</p>';
}
?>
    

        <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
</body>

</html>