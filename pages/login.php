<?php
if(isset($_SESSION['ruser'])) {
    echo '<form action="index.php';
    if(isset($_GET['page'])) echo '?page='.$_GET['page'];
    echo '" method="post" class="input-group">';
    echo '<h4>Hello, '.$_SESSION['ruser'].'</h4>';
    echo '<input type="submit" name="exit" value="Logout" class="btn btn-primary btn-sm">';
    echo '</form>';
    if(isset($_POST['exit'])) {
        // Удаляем сессию пользователя, в том числе и админа
        unset($_SESSION['ruser']);
        unset($_SESSION['radmin']);
        echo '<script>window.location.reload()</script>';
    }  
} else {
    // проверяем нажатие кнопки Login
    if(isset($_POST['press'])) {
        // передаем значения поля login и pass в ф-ю login в(functions.php)
        if(login($_POST['login'], $_POST['pass'])) {
            echo '<script>window.location.reload()</script>';
        } else {
            echo "<h3 class='text-danger'>Имя или пароль не совпадают</h3>";
        }
    } else {
        // т.е. после отправки формы нас будет перенаправлять на ту же страницу, на которой мы и были
        echo '<form action="index.php';
        if(isset($_GET['page'])) echo '?page='.$_GET['page'];
        echo '" method="post" class="input-group">';
        echo '<input type="text" name="login" placeholder="login" class="my-3 mx-1">';
        echo '<input type="password" name="pass" placeholder="password" class="my-3 mx-1">';
        echo '<input type="submit" name="press" value="Login" class="btn btn-primary btn-sm my-3 mx-1">';
        echo '</form>';
    }
}
?>