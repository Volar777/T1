<?php
	require "inc/lib.inc.php";// подключение библиотеки функций
	require "inc/config.inc.php";// подключение конфигурацеонного файла
	
$n = clearStr($_POST["name"]);
  $e = clearStr($_POST["email"]);
  $p = clearStr($_POST["phone"]);
  $a = clearStr($_POST["address"]);
  // Получение из переменой "$_POST" значений, которые были переданы веб-формой "orderform.php", при оформление заказа: "name", "email", "phone", "address" и очистка от тегов
  
  $dt = saveCustomerData($n, $e, $p, $a);//вызов функции для сохранениея заказа в файл// Запишите значение переменной $order в файл, имя которого хранится в константе ORDERS_LOG. Файл должен храниться в папке eshop\admin! 
  
  saveOrder($dt);//Функция записывает в таблицу "orders" БД данные о заказе из корзины: title, author, pubyear, price, quantity, orderid, datetime и принимает в качестве аргумента дату и время заказа в виде временной метки 

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Сохранение данных заказа</title>
</head>
<body>
	<p>Ваш заказ принят.<br> Благодарим Вас за Ваш заказ!</p>
	<p><a href="catalog.php">Вернуться в каталог товаров</a></p>
</body>
</html>