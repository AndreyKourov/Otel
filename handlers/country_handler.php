<?php
error_reporting(E_ALL);
include_once('../pages/functions.php');
$link = connect();

$sel = 'SELECT * FROM cities WHERE countryid='.$_GET['coid'];
$res = mysqli_query($link, $sel);
echo '<option value="0">Select city...</option>';
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<option value='$row[0]'>$row[1]</option>";
}
mysqli_free_result($res);

?>