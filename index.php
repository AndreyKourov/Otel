<?php
error_reporting(E_ALL);
session_start();
include_once("pages/functions.php");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Tours site(site2)</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
</head>
<body>
   <div class="container">
       <div class="row">
           <header class="col-12">
               <?php include_once("pages/login.php"); ?>
           </header>
       </div>
       <div class="row">
           <nav class="col-12 mb-5">
              <?php include_once("pages/menu.php"); ?>               
           </nav>
       </div>
       <div class="row">
           <section class="col-12">
              <?php 
               if(isset($_GET['page'])) {
                   $page = $_GET['page'];
                   if($page == 1) {include_once('pages/tours.php');}
                   if($page == 2) {include_once('pages/comments.php');}
                   if($page == 3) {include_once('pages/registration.php');}
                   if($page == 4 && isset($_SESSION['radmin'])) {include_once('pages/admin.php');}
                   if($page == 5 && isset($_SESSION['radmin'])) {include_once('pages/private.php');}
               }
               ?>               
           </section>
       </div>
       <footer class="row">Step academy &copy; 2020</footer>
   </div>
    
    <script src="https://use.fontawesome.com/5265fdf927.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>