<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Hotel info</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
    error_reporting(E_ALL);
    include_once("functions.php");
    $link = connect();
    // обработчик переданного значения номера отеля
    if(isset($_GET['hotel'])) {
        $ho_id = $_GET['hotel'];
        $sel = 'SELECT * FROM hotels WHERE id='.$ho_id;
        $res = mysqli_query($link, $sel);
        $row = mysqli_fetch_array($res, MYSQLI_NUM);
        //var_dump($row);
        $ho_name = $row[1];
        $ho_stars = $row[4];
        $ho_cost = $row[5];
        $ho_info = $row[6];
        mysqli_free_result($res);
        
        echo '<section class="container text-center">';
        echo "<h1 class='text-uppercase'>$ho_name</h1>";
        echo '<p class="lead">Watch our pictures</p>';
        echo '<p class="lead">Info: '.$ho_info.'</p>';

        echo "<h3>Отзывы</h3>";
        $sel = 'SELECT * FROM comments WHERE hotelid='.$ho_id;
        $res = mysqli_query($link, $sel);
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            
            echo "<div>$row[1]</div>";
        }

        for($i=0; $i<$ho_stars; $i++) {
            echo '<img src="../images/star.png" alt="star" class="container_star">';
        }
        
        $sel1 = 'SELECT imagepath FROM images WHERE hotelid='.$ho_id;
        $result = mysqli_query($link, $sel1);
        $act = mysqli_fetch_array($result, MYSQLI_NUM);
                
        echo '<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">';
            echo '<div class="carousel-inner">';
                echo '<div class="carousel-item active">';
                    echo '<img src="../' . $act[0] . '" class="d-block-center w-100" alt="...">';
                echo '</div>';

                while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                echo '<div class="carousel-item">';
                    echo "<img src='../$row[0]' class='d-block w-100' alt='hotel pic'>";
                echo '</div>';
                }

            echo '</div>';
                echo '<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">';
                echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                echo '<span class="sr-only">Previous</span>';
                echo '</a>';
                echo '<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">';
                echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                echo '<span class="sr-only">Next</span>';
                echo '</a>';
        echo '</div>';

        echo '</section>';
    mysqli_free_result($result);



        /*
        echo '<div class="carousel-item">';
            while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            echo "<img src='../$row[0]' class='d-block w-100' alt='hotel pic'>";
            }
        echo '</div>';
        */   
        /*
        $sel = 'SELECT imagepath FROM images WHERE hotelid='.$ho_id;
        $result = mysqli_query($link, $sel);
        echo '<div class="gallery mt-5">';
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            echo "<img src='../$row[0]' alt='hotel pic'>";
        }
        echo '</div>';
        echo '</section>';
        mysqli_free_result($result);
        */
        
    }
    
    ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>