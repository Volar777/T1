<?php
	// подключение библиотек
	require "secure/session.inc.php";//подключение файла сессии
	require "../inc/lib.inc.php";// подключение библиотеки функций
	require "../inc/config.inc.php";//подключение конфигурацеонного файла
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		 move_uploaded_file($_FILES["userfile"]["tmp_name"], "../img/" . $_FILES["userfile"]["name"]);//Загрузка файла на сервер в папку "/img/"
  }
	
  $t = clearStr($_POST["title"]);// Очистка названия товара от тегов
  $a = clearStr($_POST["author"]);// Очистка автора товара от тегов
  $py = clearUint($_POST["pubyear"]);// Получение модуля числа года создания товара
  $p = clearUint($_POST["price"]);// Получение модуля числа цены товара
  $f = clearStr($_FILES["userfile"]["name"]);// Очистка название файла товара от тегов 

  if(!addItemToCatalog3($t, $a, $py, $p, $f)){//Функция сохраняет новый товар в таблицу catalog
    echo "Произошла ошибка при добавлении товара в каталог";//Вывод сообщения об ошибке если функция вернула "false"
  }else{
    header("Location: add2cat.php");//Если функция вернула "true" переадресация на файл "add2cat.php"
    exit;
  }
