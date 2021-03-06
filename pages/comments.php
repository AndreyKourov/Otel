<h2>Comments</h2>
<hr>
<?php
$link = connect();


if(isset($_SESSION['ruser']) || isset($_SESSION['radmin'])) {
    if(isset($_SESSION['ruser'])) { $user = $_SESSION['ruser']; }
    if(isset($_SESSION['radmin'])) { $user = $_SESSION['radmin']; }
    $user = strval($user);
    $resuserid = mysqli_query($link, 'SELECT id FROM `users` WHERE `login`="'.$user.'"');
    $rowuserid = mysqli_fetch_array($resuserid, MYSQLI_NUM);
    $userid = (int)$rowuserid[0];
    mysqli_free_result($resuserid);
} else { 
    $userid = 0;
}


// выаод городов и отелей через AJAX
echo '<div class="form-inline">';
// событие onchange происходит при выботе пункта в селекте
echo '<select name="countryid" id="countryid" onchange="showCities(this.value)">';
$res = mysqli_query($link, 'SELECT * FROM countries ORDER BY country');
echo '<option value="0">Select country...</option>';
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<option value='$row[0]'>$row[1]</option>";
}

echo '</select>';

//select для выбора города
echo '<select name="cityid" id="cityid" onchange="showHotels(this.value)"></select>';

echo '<select name="hotels" id="hotels" onchange="Hotels(this.value, '.$userid.')"></select>';

echo '</div>';

//блок для вывода отелей
echo '<div id="comhotels"></div>';

//javaScript function
?>
<script>
    
    function showCities(countryid) {
        if(countryid == '0') {}
        // создем аякс обьект
        const ao = new XMLHttpRequest();
        ao.open('GET', 'handlers/country_handler.php?coid='+countryid, true );
        ao.send(null);
        ao.onreadystatechange = function() {
            if(ao.readyState == 4 && ao.status == 200) {
                // перенесем <option> с именами городов 
                document.getElementById('cityid').innerHTML = ao.responseText;
            }
        }
    }
    function showHotels(cityid) {
        const ao = new XMLHttpRequest();
        //Создание AJAX запроса через POST
        ao.open('POST', 'handlers/city_handler.php', true);
        ao.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ao.send('ciid='+cityid);
        ao.onreadystatechange = function() {
            if(ao.readyState == 4 && ao.status == 200) {
                // перенесем <option> с именами городов 
                document.getElementById('hotels').innerHTML = ao.responseText;
            }
        }
    }
    
    function Hotels(hotels, userid) {
        const ao = new XMLHttpRequest();
        ao.open('POST', 'handlers/hotel_handler.php', true );
        ao.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ao.send('hoid='+ hotels +'&'+ 'usid' + userid);
        ao.onreadystatechange = function() {
            if(ao.readyState == 4 && ao.status == 200) {
                document.getElementById('comhotels').innerHTML = ao.responseText;
            }
        }
    }

</script>
