<?php
include 'config.php';

$query = $_GET['query'];

if ($query) {
   $query = mysqli_real_escape_string($conn, $query);
   $result = mysqli_query($conn, "SELECT `name` FROM `products` WHERE `name` LIKE '{$query}%'") or die('query failed');
   $suggestions = [];
   while ($row = mysqli_fetch_assoc($result)) {
      $suggestions[] = $row['name'];
   }
   echo json_encode($suggestions);
}
?>
