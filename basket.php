<?php
	require "inc/lib.inc.php";// подключение библиотеки функций
	require "inc/config.inc.php";// подключение конфигурацеонного файла
	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Корзина пользователя</title>
</head>
<body>
	<h1>Ваша корзина</h1>
		<?php
  $goods = myBasket();// функция возвращает всю пользовательскую корзину в виде ассоциативного массива

  if(!$goods){// Если функция вернула значение "false",  то выодится текст с гиперссылкой "Корзина пуста! Вернитесь в каталог"
    echo "Корзина пуста! Вернитесь в <a href='catalog.php'>каталог</a>";
    exit;// корзина пуста конц. таблицу не отрисовываем
  }else{// Иначе, если функция не вернула значение "false" выводится текст с гиперссылкой "Вернуться в каталог"
    echo "Вернуться в <a href='catalog.php'>каталог</a>";
  }
?>

<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Картинка</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
	<th>Удалить</th>
</tr>
<?php
  $i = 1; $sum = 0;// Целочисленные переменные: $i со значением 1 для подсчета порядковых номеров и $sum со значением 0 для подсчета общей суммы заказа
    foreach($goods as $item){//Преребор масива $goods по значению $item для вывода всех товаров из корзины пользователя на экран	
?>
<tr>
      <td><?=$i?></td>
	  <td><a href="toPage.php?id=<?=$item["id"]?>"><?=$item["title"]?></a></td><!--при нажатие на гиперссылку происходит передача "id" товара методом GET обработчику, для перехода на страницу товара -->
     <td width="10%"><img src="img/<?=$item["name"]?>" alt="альтернативный текст" width="100%" ></td><!--Вывод картинки товара-->
	  <td><?=$item["author"]?></td><!--Вывод автора-->
      <td><?=$item["pubyear"]?></td><!--Вывод год издания -->
      <td><?=$item["price"]?></td><!--Вывод цены товара-->
      <td>
	  <div>Количество:<!--Вывод количества единиц товара-->
	  <form action="edit.php" method="post">
			<select name="q"><!--число единиц товара -->
				<option <? if($item["quantity"]==1)echo "selected='selected'";?>>1</option>
				<option <? if($item["quantity"]==2)echo "selected='selected'";?>>2</option>
				<option <? if($item["quantity"]==3)echo "selected='selected'";?>>3</option>
				<option <? if($item["quantity"]==4)echo "selected='selected'";?>>4</option>
				<option <? if($item["quantity"]==5)echo "selected='selected'";?>>5</option>
				<option <? if($item["quantity"]==6)echo "selected='selected'";?>>6</option>
				<option <? if($item["quantity"]==7)echo "selected='selected'";?>>7</option>
				<option <? if($item["quantity"]==8)echo "selected='selected'";?>>8</option>
				<option <? if($item["quantity"]==9)echo "selected='selected'";?>>9</option>
				<option <? if($item["quantity"]==10)echo "selected='selected'";?>>10</option>
			</select>
		<input name='id' type='hidden' value="<?=$item["id"]?>"/>
		<input type="submit" value="Пересчитать"><!--При нажатие кнопки "Пересчитать" происходит передача "id" товара методом POST обработчику, для изменения колтчества единиц товара-->
		</form>			
			</div>
	  </td>
      <td>
        <a href="delete_from_basket.php?id=<?=$item["id"]//При нажатие на гиперссылку "Удалить" происходит передача "id" товара методом GET обработчику delete_from_basket.php, для удаления товара из корзины?>">Удалить</a>
      </td>
    </tr>
<?//При переборе массива товаров в корзине $goods по каждому его значению происходит увеличение значения переменной $sum на соответствующее значение (сумма текущего товара * количество товара) и значения переменной $i на единицу
    $i++;
    $sum += $item["price"] * $item["quantity"];//"price" - цена товара, "quantity" - количесто единиц товара
  }
?>
</table>

<p>Всего товаров в корзине на сумму: <?=$sum?><!--Вывод суммы заказа --> руб.</p>

<div align="center">
	<input type="button" value="Оформить заказ!"
                      onClick="location.href='orderform.php'" /><!--При нажатие на кнопку "Оформить заказ!" происходит переход на страницу оформления заказа-->
</div>
</body>
</html>
