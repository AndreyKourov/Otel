<?php
error_reporting(E_ALL);

include_once("functions.php");

// ф-я connect() возвращает объект успешного подключения к MySQL и БД travels
$link = connect();

// auto_increment - значение при добавлении новой записи будет увеличиватсья на единицу
// varchar - тип данных для текста, значение в () задает максимальную длину символов
// unique - не позволит создать запись с уже существующим именем
//primary key - первичный ключ, всегда добавляется у поля id. необходим для определения каждой записи в таблице.
//  foreign key - позволяет связать внешним ключом два столбца из разных таблиц
// on delete cascade - если в родительском столбце была удалена запись, то в дочерней они также удалятся (т.е. если я удалю страну Russia из таблицы countries, то удалятся все связанные города из таблицы cities)


$ct1 = 'CREATE TABLE countries(
id int not null auto_increment primary key,
country varchar(64) unique
)default charset="utf8"';

$ct2 = 'CREATE TABLE cities(
id int not null auto_increment primary key,
city varchar(64),
countryid int,
foreign key(countryid) references countries(id) on delete cascade,
ucity varchar(128),
unique index ucity(city, countryid)
)default charset="utf8"';

$ct3 = 'CREATE TABLE hotels(
id int not null auto_increment primary key,
hotel varchar(64),
cityid int,
foreign key(cityid) references cities(id) on delete cascade,
countryid int,
foreign key(countryid) references countries(id) on delete cascade,
stars int,
cost int,
info varchar(1024)
)default charset="utf8"';

$ct4 = 'CREATE TABLE images(
id int not null auto_increment primary key,
imagepath varchar(1024),
hotelid int,
foreign key(hotelid) references hotels(id) on delete cascade
)default charset="utf8"';

$ct5 = 'CREATE TABLE roles(
id int not null auto_increment primary key,
role varchar(32)
)default charset="utf8"';

$ct6 = 'CREATE TABLE users(
id int not null auto_increment primary key,
login varchar(64) unique,
pass varchar(128),
email varchar(128),
roleid int,
foreign key(roleid) references roles(id) on delete cascade,
discount int,
avatar mediumblob
)default charset="utf8"';


//создаем таблицы описанные выше
mysqli_query($link, $ct1);
if(mysqli_errno($link)) {
    echo 'Error code 1 ' .mysqli_errno($link).'<br>';
    exit;
}

mysqli_query($link, $ct2);
if(mysqli_errno($link)) {
    echo 'Error code 2 ' .mysqli_errno($link).'<br>';
    exit;
}

mysqli_query($link, $ct3);
if(mysqli_errno($link)) {
    echo 'Error code 3 ' .mysqli_errno($link).'<br>';
    exit;
}

mysqli_query($link, $ct4);
if(mysqli_errno($link)) {
    echo 'Error code 4 ' .mysqli_errno($link).'<br>';
    exit;
}

mysqli_query($link, $ct5);
if(mysqli_errno($link)) {
    echo 'Error code 5 ' .mysqli_errno($link).'<br>';
    exit;
}

mysqli_query($link, $ct6);
if(mysqli_errno($link)) {
    echo 'Error code 6 ' .mysqli_errno($link).'<br>';
    exit;
}
















