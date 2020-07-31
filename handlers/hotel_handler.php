<?php

error_reporting(E_ALL);
include_once('../pages/functions.php');
$link = connect();

$selhotel = 'SELECT hotel FROM hotels WHERE id='.$_POST['hoid'];
    $reshotel = mysqli_query($link, $selhotel);
    $rowhotel = mysqli_fetch_array($reshotel, MYSQLI_NUM);
    $hotelid = $rowhotel[0];
    mysqli_free_result($reshotel); 

//echo "<p>".$_SESSION['ruser']."</p>";
//echo '<form action="index.php?page=2" method="post"  id="comments" >';
echo '<form action="sand.php" method="post"  id="comments" >';
echo '<br><textarea name="comment" placeholder="Enter your comment" class="mt-1" rows="5" cols="45"></textarea>';
echo '<br>';
echo  '<input type="hidden" name="hotelid" value="'.$_POST['hoid'].'">';
echo '<input type="submit" name="addcomment" value="add" class="btn btn-sm btn-primary">';

echo '</form>';




/*
$sel = 'SELECT * FROM hotels WHERE hotel='.$_GET['hoid'];
$res = mysqli_query($link, $sel);
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<p>$row[1]</p>";
}
mysqli_free_result($res);
*/

?>
