<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6 left">
        <!-- Section A - countries -->
        <?php
        $link = connect();
        $sel = 'SELECT * FROM countries ORDER BY(id)'; // запрос на получ. всех данных
        $res = mysqli_query($link, $sel);
        // var_dump($res);
        echo '<form action="index.php?page=4" method="post" class="input-group" id="formcountry">';
        
        // добавление стран в таблицу countries
        echo '<input type="text" name="country" placeholder="country">';
        echo '<input type="submit" name="addcountry" value="add" class="btn btn-sm btn-info">';
        // кнопка удаления страны
        echo '<input type="submit" name="delcountry" value="del" class="btn btn-sm btn-warning">';


        // вывод стран в таблицу
        echo '<table class="table table-striped mt-3 layer">';
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo '<tr>';
                echo '<td>'.$row[0].'</td>'; // id страны
                echo '<td>'.$row[1].'</td>'; // название страны
                echo '<td><input type="checkbox" name="cb'.$row[0].'"></td>';
            echo '</tr>';
        }
        echo '</table>';
        
        echo "</form>";
        
        mysqli_free_result($res); // освобождает память, занятую запросом

        // обработчик для добавления страны
        if(isset($_POST['addcountry'])) {
            $country = trim(htmlspecialchars($_POST['country']));
            if($country=="") exit;
            $ins = "INSERT INTO countries(country) VALUES('$country')";
            mysqli_query($link, $ins);
            echo '<script>window.location=document.URL</script>';
        }
        
        // обработчик для удаления страны
        if(isset($_POST['delcountry'])) {
            
            // перебираем массив $_POST
            foreach($_POST as $k => $v) {
                if(substr($k, 0, 2) === 'cb') {
                    $idc = substr($k, 2); // обрезаем строку, получая число из cb1, cb2 ...
                    $del = 'DELETE FROM countries WHERE id='.$idc;
                    mysqli_query($link, $del);
                }
            }
            
            echo '<script>window.location=document.URL</script>';
        }
        
        ?>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 right mt-5">
        <!-- Section B - cities -->
        <?php
        
        $res = mysqli_query($link, 'SELECT * FROM countries');
                
        echo '<form action="index.php?page=4" method="post" class="input-group" id="formcity">';

        // выпадающий список существующих стран
        echo '<select name="countryname">';
        // перебираем страны
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<option value='$row[0]'>$row[1]</option>";
        }
        echo '</select>';

        echo '<input type="text" name="city" placeholder="City">';
        echo '<input type="submit" name="addcity" value="add" class="btn btn-sm btn-info">';
        echo '<input type="submit" name="delcity" value="del" class="btn btn-sm btn-warning">';
        


        // выбираем все данные из таблицы стран    
        
        $res1 = mysqli_query($link, 'SELECT * FROM cities');
        
        echo '<table class="table table-striped mt-3">';
        while($row1 = mysqli_fetch_array($res1, MYSQLI_NUM)) {
            echo '<tr>';
                echo '<td>'.$row1[0].'</td>'; // id страны
                echo '<td>'.$row1[1].'</td>'; // название страны
                echo '<td><input type="checkbox" name="cb'.$row1[0].'"></td>';
            echo '</tr>';
        }
        echo '</table>';      
        
        echo '</form>';

        // обработчик добавления города
        if(isset($_POST['addcity'])) {
            $city = trim(htmlspecialchars($_POST['city']));
            if($city == "") exit;
            $countryid = $_POST['countryname']; // здесь будет записано значение из селекта, в зависимости от выбранного option и его value. Пример: в select выбрана страна Argentina, то в $_POST['countryname'] будет номер, допустим 9
            $ins = "INSERT INTO cities(city, countryid) VALUES('$city', '$countryid')";
            mysqli_query($link, $ins);
            
            if(mysqli_error($link)) {
                echo "Error text: " . mysqli_error($link);
                exit;
            }
            
            echo '<script>window.location=document.URL</script>';
        }

        // обработчик для удаления страны
        if(isset($_POST['delcity'])) {
            // перебираем массив $_POST
            foreach($_POST as $k => $v) { 
                if(substr($k, 0, 2) === 'cb') {
                    $idc = substr($k, 2); // обрезаем строку, получая число из cb1, cb2 ...
                    $del = 'DELETE FROM cities WHERE id='.$idc;
                    mysqli_query($link, $del);
                }    
            }
            echo '<script>window.location=document.URL</script>';
        }
        ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6 left">
        <!-- Section C - hotels -->
        <?php
        echo '<form action="index.php?page=4" method="post" class="input-group" id="formhotel">';
        
        $sel = 'SELECT ci.id, ci.city, co.country, co.id FROM countries co, cities ci WHERE ci.countryid=co.id'; // через WHERE реализуем связь 1к1, т.е. каждый город будет соответствовать только одной стране.
        $res = mysqli_query($link, $sel); // ci.id[0], ci.city[1], co.country[2], co.id[3]
        
        $coid_array = array(); // создаем ассоциативный массив
        
        echo '<select name="hcity">';
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<option value='$row[0]'>$row[1] : $row[2]</option>";
            $coid_array[$row[0]] = $row[3]; // т.е. присвоить co.id
        }
        echo '</select>';
        
        echo '<input type="text" name="hotel" placeholder="hotel">';
        echo '<label for="stars">STARS:</label>';
        echo '<input type="number" id="stars" name="stars" min="1" max="5">';
        echo '<input type="text" name="cost" placeholder="cost">';
        echo '<br><textarea name="info" placeholder="Description hotel"></textarea>';
        echo '<input type="submit" name="addhotel" value="add" class="btn btn-sm btn-info">';
        echo '<input type="submit" name="delhotel" value="del" class="btn btn-sm btn-warning">';

        //таблица отеля
        $sel1 = 'SELECT ho.id, ho.hotel, ho.stars, ho.cost, ho.cityid, ci.id, ci.city FROM hotels ho, cities ci WHERE ho.cityid=ci.id';
        $res1 = mysqli_query($link, $sel1);

        echo '<table class="table table-striped mt-3">';
        while($row = mysqli_fetch_array($res1, MYSQLI_NUM)) {
            echo '<tr>';
                echo '<td>'.$row[0].'</td>'; // id страны
                echo '<td>'.$row[1].'</td>'; // название страны
                echo '<td>'.$row[2].'</td>';
                echo '<td>'.$row[3].'</td>';
                echo '<td>'.$row[6].'</td>';
                echo '<td><input type="checkbox" name="cb'.$row[0].'"></td>';
            echo '</tr>';
        }
        echo '</table>';
        
        echo '</form>';
        
        
        // добавление отеля
        if(isset($_POST['addhotel'])) {
            $hotel = trim(htmlspecialchars($_POST['hotel']));
            $cost = intval(trim(htmlspecialchars($_POST['cost']))); // intval() - преобразует текст в число
            $stars = intval($_POST['stars']);
            $info = trim(htmlspecialchars($_POST['info']));
            if($hotel == "" || $cost == "" || $info == "") exit;
            $cityid = $_POST['hcity']; // берем value из выпадающего списка, т.е. номер города
            $countryid = $coid_array[$cityid]; // берем из массива $coid_array индекс по номеру города (ci.id) и заносим в переменную
                        
            $ins = "INSERT INTO hotels(hotel, cityid, countryid, stars, cost, info) VALUES('$hotel', '$cityid', '$countryid', '$stars', '$cost', '$info')";
            mysqli_query($link, $ins);
            
            if(mysqli_error($link)) {
                echo "Error text: " . mysqli_error($link);
                exit;
            }
            echo '<script>window.location=document.URL</script>';
        }

        

        //удаление отеля
        if(isset($_POST['delhotel'])) {
            var_dump($_POST);
            foreach($_POST as $k => $v ) {
                if(substr($k, 0, 2) === 'cb') {
                    $idc = substr($k, 2);
                    $del = 'DELETE FROM hotels WHERE id='.$idc;
                    mysqli_query($link, $del);
                }
            }
            echo '<script>window.location=document.URL</script>';
        }
        
        ?>
        
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 right">
        <!-- Section D - image -->
        <?php
        echo '<form action="index.php?page=4" method="post" enctype="multipart/form-data" class="input-group">';
        $sel = 'SELECT ho.id, co.country, ci.city, ho.hotel FROM countries co, cities ci, hotels ho WHERE ho.countryid=co.id AND ho.cityid=ci.id';
        $res = mysqli_query($link, $sel);
        echo '<select name="hotelid">';
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<option value='$row[0]'>$row[1] | $row[2] | $row[3]</option>";
        }
        echo '</select>';
        mysqli_free_result($res);
        
        echo '<input type="file" name="file[]" multiple accept="image/*" id="gallery-photo-add" class="m-2">';
        echo '<input type="submit" name="addimage" value="add" class="btn btn-sm btn-info m-2">';
        echo '</form>';

         echo '<div class="gallery"></div>';
        
        
        // обработчик добавления изображения
        if(isset($_POST['addimage'])) {
            // перебираем все загруженные через форму картинки отелей
            foreach($_FILES['file']['name'] as $k => $v) {
                // проверяем, произошла ли ошибка при загрузке какого-нибудь из множества файлов
                if($_FILES['file']['error'][$k] != 0) {
                    echo '<script>alert("Upload file error:'.$_FILES['file']['error'][$k] .':'. $v.')</script>';     continue;
                }
                if(move_uploaded_file($_FILES['file']['tmp_name'][$k], 'images/'.$v)) {
                   $ins = 'INSERT INTO images(hotelid, imagepath) VALUES('.$_POST['hotelid'].', "images/'.$v.'")';
                   mysqli_query($link, $ins);
                } 
            }
        }

        ?>  

      
              <script>
                $(function() { 
                // Multiple images preview in browser
                    var imagesPreview = function(input, placeToInsertImagePreview) { 
                     if (input.files) { 
                         var filesAmount = input.files.length; 

                         for (i = 0; i < filesAmount; i++) { 
                             var reader = new FileReader(); 

                             reader.onload = function(event) { 
                                 $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                                 }
                            
                             reader.readAsDataURL(input.files[i]);
                         }
                     }
                 };

                 $('#gallery-photo-add').on('change', function() { 
                        imagesPreview(this, 'div.gallery');
                     });
                 });
              
                 </script>

                 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </div>
</div>