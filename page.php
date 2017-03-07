<?php
	require "inc/lib.inc.php";// подключение библиотеки функций
	require "inc/config.inc.php";// подключение конфигурацеонного файла
	$goods2 = selectItem2();// функция возвращает содержимое каталога товаров по нужному id
	$goods3 = myBasket2();//  функция возвращает все комментарии по id товара

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Страница товара</title>
</head>
<body>
<center>
<h3>Страница товара</h3>
<a href="catalog.php">Вернуться в каталог</a> Товаров в <a href="basket.php">корзине</a>: <?= $count?><br><br>

<?php
$ark = arK($basket);// функция возвращает массив ключей (из массива $basket) для определения какую гиперссылку выводить "Уже в корзине" или "В корзину"
  foreach($goods2 as $item){//вывод всех атрибутов товара
  ?>
<table  bgcolor="#BDBDBD" border="0" cellpadding="5" cellspacing="0" width="50%">
<tr>
	<th width="50%"><img src="img/<?=$item["name"]?>" alt="Файл временно отсутствует" width="100%" ></th>
	<th style="text-align: left; padding: 20px;">
	Название <?=$item["title"]?><br><br>
	Автор <?=$item["author"]?><br>
	Год <?=$item["pubyear"]?><br>
	Цена <?=$item["price"]?><br>
	<br><a href="add2basketPage.php?id=<?=$item["id"] //гиперссылка для передачи "id" товара методом GET обработчику add2basket.php для добавления товара в корзину?>"><!-- корзину--><?if (in_array($item["id"], $ark)) echo "Уже в корзине"; else echo "В корзину";?></a><br><br>
		 <a href="golospPage.php?id=<?=$item["id"]?>&golp=<?=$item["golosp2"]+1?>">+ <?=$item["golosp2"]?></a><!--При нажатие на гиперссылку происходит передача "id" товара методом GET обработчику, для изменения рейтинга товара +1(для каждого товара можно изменить рейтинг +1 или -1 можно только один раз)--> 
	     /<a href="golospPage.php?id=<?=$item["id"]?>&golm=<?=$item["golosm2"]+1?>">- <?=$item["golosm2"]?></a><!--При нажатие на гиперссылку происходит передача "id" товара методом GET обработчику, для изменения рейтинга товара -1(для каждого товара можно изменить рейтинг +1 или -1 можно только один раз)-->
		</th>
	  </tr>
</table>
  <?
  } 
?>
</center>
<br>
<h3>Комментарии о товаре (Вы можете оставить свой комментарий)</h3><!--Форма для вввода комментария о товаре-->
	<form action="add2comm.php" method="post">
		<p>Ваше имя: <input type="text" name="name" size="30">
		<p>Комментарий: <input type="text" name="comm" size="150">
		<p><input type="submit" value="Добавить"><!--Передача методом  "post" атрибутов комметария обработчику "add2comm.php"-->
	</form>
<table>
<?php
$i=1;
  foreach($goods3 as $item){//Преребор масива $goods3 по значению $item для вывода всех комментариев по данному товару на экран
  ?>
    <tr>
	  <td><?=$i++?> . <?=$item["name"]?></td>
	</tr>
	<tr>
	  <td><?=$item["txt"]?></td>
      </td>
    </tr>
	<tr><td><br></td></tr>
  <?
  } 
?>
	</table>

</body>
</html>