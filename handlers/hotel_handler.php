<?php

error_reporting(E_ALL);
include_once('../pages/functions.php');
$link = connect();

echo '<form action="index.php?page=2" method="post"  id="comments" >';
echo '<br><textarea name="comment" placeholder="Enter your comment" class="mt-1" rows="5" cols="45"></textarea>';
echo '<br>';
echo '<input type="submit" name="addcomment" value="add" class="btn btn-sm btn-primary">';

echo '</form>';

if(isset($_POST['addcomment'])) {
    $hotelid = $_GET['hoid'];
    $comment = trim(htmlspecialchars($_POST['comment']));
    if($comment == "") exit;
    $ins = "INSERT INTO comments(comment, hotelid) VALUES('$comment', '$hotelid')";
    mysqli_query($link, $ins);
    //var_dump($ins);
    if(mysqli_error($link)) {
        echo "Error text: " . mysqli_error($link);
        exit;
    }
    echo '<script>window.location=document.URL</script>';
}


/*
$sel = 'SELECT * FROM hotels WHERE hotel='.$_GET['hoid'];
$res = mysqli_query($link, $sel);
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<p>$row[1]</p>";
}
mysqli_free_result($res);
*/

?>
