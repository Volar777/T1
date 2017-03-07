<?
require "secure/session.inc.php";//подключение файла сессии
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Форма добавления товара в каталог</title>
</head>
<body>
<h1>Добавления товара в каталог</h1>
	<form action='save2cat.php' method='post' enctype='multipart/form-data'><!--форма для загрузки файла в папку "img" и его описания в БД методом POST-->
	<p>Название: <input type="text" name="title" size="100">
		<p>Автор: <input type="text" name="author" size="50">
		<p>Год издания: <input type="text" name="pubyear" size="4">
		<p>Цена: <input type="text" name="price" size="6"> руб.
	
<input type="hidden" name="MAX_FILE_SIZE" value="4096000" /><!--максимальный  размер загружаемого файла в байтах-->
<p><input type='file' name='userfile'>
<p><input type='submit' value="Добавить">

</form>
</body>
</html>