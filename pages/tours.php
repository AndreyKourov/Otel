<h2>Select tours</h2>
<hr>
<?php
$link = connect();

echo '<form action="index.php?page=1" method="post">';
$res = mysqli_query($link, 'SELECT * FROM countries ORDER BY country');
echo '<select name="countryid" class="col-3">';
echo '<option value="0">Select country...</option>';
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<option value='$row[0]'>$row[1]</option>";
}
echo '</select>';
mysqli_free_result($res);
echo '<input type="submit" name="selcountry" value="Select country" class="btn btn-primary btn-sm">';

// обработчик выбора страны
if(isset($_POST['selcountry'])) {
    $countryid = $_POST['countryid'];
    if($countryid == 0) exit;
    // запрос на выборку городов и вывод их в select
    $result = mysqli_query($link, 'SELECT * FROM cities WHERE countryid='.$countryid.' ORDER BY city');
    echo '<select name="cityid" class="col-3">';
    echo '<option value="0">Select city...</option>';
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
        echo "<option value='$row[0]'>$row[1]</option>";
    }
    echo '</select>';
    mysqli_free_result($result);
    echo '<input type="submit" name="selcity" value="Select city" class="btn btn-primary btn-sm">';
}
echo '</form>';

// обработчик для вывода таблицы с отелями выбранного города
if(isset($_POST['selcity'])) {
    $cityid = $_POST['cityid'];
    $sel = 'SELECT co.country, ci.city, ho.hotel, ho.cost, ho.stars, ho.id FROM hotels ho, countries co, cities ci WHERE ho.countryid=co.id AND ho.cityid=ci.id AND ci.id='.$cityid;
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
}








?>