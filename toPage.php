<?php
	// подключение библиотек
	require "inc/lib.inc.php";// подключение библиотеки функций
	require "inc/config.inc.php";// подключение конфигурацеонного файла

	  $id = clearUint($_GET["id"]);//Получите модуля числа идентификатора товара, данные которого нужно загрузить на станице "page.php"
  if($id){
    savePage($id);//функция создание cookie с id продукта для загрузки данных товара на страницу "page.php"
 header("Location: page.php");//Переадресуйте пользователя на страницу "page.php"
    exit;
}
	
?>

