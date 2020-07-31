<?php

error_reporting(E_ALL);
include_once('pages/functions.php');
$link = connect();

if(isset($_POST['addcomment'])) {
    //$hotelid = $_POST['hoid'];
    //$comment = trim(htmlspecialchars($_POST['comment']));
    //if($comment == "") exit;
    
    $hotelid = $_POST['hotelid'];
    $comment = trim($_POST['comment']);
    $ins = "INSERT INTO comments(comment, hotelid) VALUES('$comment', '$hotelid')";
    mysqli_query($link, $ins);
    //var_dump($ins);
    
    $err = mysqli_errno($link);
    if($err) {
        echo "<h6 class='text-danger'>Error code ".$err."</h6>";   
    } else {
        echo "<h4 class='text-success'>Комментарий успешно добавлен</h4>";
    }
}
?>

<button onclick="myFunction()">GET BACK</button>

<script>
function myFunction() {
  location.replace("index.php?page=2")
}
</script>