<?php
// подключение библиотек
require "inc/lib.inc.php";// подключение библиотеки функций
require "inc/config.inc.php";//подключение конфигурацеонного файла

$q = $_POST["q"];//число единиц товара
$id = $_POST["id"];//id товара

if($id){
 edit($id,$q);// Функция изменяет количество единиц товара  в массиве "$basket"
header("Location: basket.php");// Переадресация на страницу "basket.php"
  exit;
}

