<?php

function connect($host="127.0.0.1:3306", $user="root", $pass="123456", $dbname="travels") {
    // подключаемся к MySQL и к БД travels
    $link = mysqli_connect($host, $user, $pass, $dbname);
    if(!$link) {
        echo "Ошибка: невозможно установить соединение с MySQL";
        echo "Код ошибки errno: " . mysqli_connect_errno();
        echo "Текст ошибки errno: " . mysqli_connect_error();
        exit; // прервать дальнейшее выполнение ф-и  
    }
    
    // проверяем, можем ли мы работать с MySQL через кодировку utf-8
    if(!mysqli_set_charset($link, "utf8")) {
        echo "Ошибка при загрузке кодировки символов utf8: ".mysqli_error($link);
        exit;
    }
    
    echo "<br>Connect was successfully<br>";
    return $link;
}


function register($name, $pass, $email) {
    
    $name = trim(utf8_encode(htmlspecialchars($name)));
    $pass = trim(htmlspecialchars($pass));
    $email = trim(htmlspecialchars($email));
    
    if($name == '' || $pass == '' || $email == '') {
        echo "<h3 class='text-danger'>Заполните все поля</h3>";
        return false;
    }
    
    if(strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
        echo "<h3 class='text-danger>От 3 до 30 символов</h3>";
        return false;
    }
    
    // хэшируем пароль
    $pass = password_hash($pass, PASSWORD_BCRYPT);
    
    // вставляем данные из полей формы в таблицу users
    $ins = "INSERT INTO users(login, pass, email, roleid) VALUES('$name', '$pass', '$email', 2)";
    
    $link = connect();
    //var_dump($link);
    
    // выполняем запрос в MySQL на добавление данных в таблицу в users в БД travels
    mysqli_query($link, $ins);
    
    
    $err = mysqli_errno($link);
    if($err) {
        if($err == 1062) {
            echo '<h3 class="text-danger">Пользователь с таким именем уже есть!</h3>';
            return false;
        } else {
            echo '<h3 class="text-danger">Error code'.$err.'</h3>';
            return false;
        }
    }
    return true;
}


function login($login, $pass) {
    $name = trim(htmlspecialchars($login));
    $pass = trim(htmlspecialchars($pass));
    if($name == "" || $pass == "") {
        echo '<h3 style="color: red;">Fill all fields</h3>';
        return false;
    }
    
    if(strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
        echo "<h3 class='text-danger>От 3 до 30 символов</h3>";
        return false;
    }
    
    $sel = "SELECT login, pass, roleid FROM users WHERE login='$name'";
    $link = connect();
    $res = mysqli_query($link, $sel);
        
    if($row=mysqli_fetch_array($res, MYSQLI_NUM)) {
        if($name == $row[0] and password_verify($pass, $row[1])) {
            // если авторизирован пользователь т.е. клиент сайта, то он будет записан как ruser
            // если его roleid == 1, то он будет записан как radmin и ruser
            $_SESSION['ruser'] = $name;
            if($row[2] == 1) {
                $_SESSION['radmin'] = $name;
            }
            return true;
        } else {
            return false;
        }
    }
}





