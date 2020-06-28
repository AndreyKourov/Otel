<?php

error_reporting(E_ALL);
include_once('../pages/functions.php');
$link = connect();

$sel = 'SELECT * FROM hotels WHERE cityid='.$_POST['ciid'];
$res = mysqli_query($link, $sel);
echo '<option value="0">Select city...</option>';
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<option value='$row[0]'>$row[1]</option>";
}
mysqli_free_result($res);


    /*
    $sel = 'SELECT co.country, ci.city, ho.hotel, ho.cost, ho.stars, ho.id FROM hotels ho, countries co, cities ci WHERE ho.countryid=co.id AND ho.cityid=ci.id AND ci.id='.$_POST['ciid'];
    $res = mysqli_query($link, $sel);
    echo '<table class="table table-striped text-center">';
    echo '<tr><th>Hotel</th><th>Country</th><th>City</th><th>Price</th><th>Stars</th><th>link</th></tr>';
    while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        echo "<tr>
        <td>$row[2]</td>
        <td>$row[0]</td>
        <td>$row[1]</td>
        <td>$row[3]</td>
        <td>$row[4]</td>
        <td><a href='pages/hotelinfo.php?hotel=$row[5]' target='_blank'>more info</a></td>
        </tr>";
    }
    echo '</table>';
    mysqli_free_result($res);
    */