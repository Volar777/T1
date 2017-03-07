<?php
// подключение библиотек
require "inc/lib.inc.php";// подключение библиотеки функций
require "inc/config.inc.php";//подключение конфигурацеонного файла

$id = clearUint($_GET["id"]);//Получение модуля числа идентификатора товара
if($id){
 deleteItemFromBasket($id);// Функция удаляет товар из корзины, принимая в качестве аргумента его идентификатор  
header("Location: basket.php");//Переадресация на страницу "basket.php"
  exit;
}

