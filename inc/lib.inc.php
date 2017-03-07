<?php
function saveGolos($id){// Созданеи cookie голосования за товар или добаление id товара к сохраненым ранее id
  global $golos;// обращение к глобальной переменной 
  array_push($golos,$id);
  $golos1 = base64_encode(serialize($golos));// для сохранения целостности применяем base64_encode(serialize())
  setcookie("golos", $golos1, 0x7FFFFFFF);// создаем cookie "golos" с id товара, за который проголосовал посетитель на длительный срок 0x7FFFFFFF
}


function add2Golos($id){// функция проверяет голосовал ил ранее посетитель за данный товар
  global $golos;
  if(!isset($_COOKIE["golos"])){// если cookie не задана
  saveGolos($id);}// созданеи cookie голосования за товар 
  else {// если cookie есть
  $golos = unserialize(base64_decode($_COOKIE["golos"]));// разшифровака cookie
  if(!in_array($id,$golos)){// проверка наличия в массиве числа == id товара
	saveGolos($id);// добавляем текущий id в cookie, если его там нет
	return true;// и возвращаем "true"
	}	
     return false;// иначе возвращаем "false"
   }
}


function arK($data){// функция возвращает массив ключей (из массива $basket) для определения какую гиперссылку выводить "Уже в корзине" или "В корзину"
if ($data==0) return $a=[]; // функция возвращает пустой массив если в cookie нет массива сразу после оформления заказа
else return array_keys($data);// получаем массив ключей (из массива $basket)
}


function edit($id,$q){// Функция изменяет количество единиц товара  в массиве "$basket"
  global $basket;
  $basket[$id] = $q;// функция присваивает значение числа единиц товара "quantity" элемету массива с ключем == "id"
  saveBasket();
}


function golosp($id,$golp){// увеличивает положительный рейтинг на 1
    global $link;// доступ к глобальной переменной (к потоку)
   $sql = "UPDATE catalog SET golosp2=? WHERE id=?";// SQL-запрос на изменение значения
  if(!$result = mysqli_prepare($link, $sql))   return false;
  mysqli_stmt_bind_param($result, "ii", 
                         $golp,$id);// привязка переменных
	mysqli_stmt_execute($result);// выполнение запроса 
	mysqli_stmt_close($result);// закрытие БД
    return true;
  }

  
function golosm($id,$golm){// увеличивает отрицательного рейтинг на 1
    global $link;
   $sql = "UPDATE catalog SET golosm2=? WHERE id=?";// SQL-запрос на изменение значения
  if(!$result = mysqli_prepare($link, $sql))   return false;
  mysqli_stmt_bind_param($result, "ii", 
                         $golm,$id);// привязка переменных
	mysqli_stmt_execute($result);// выполнение запроса 
	mysqli_stmt_close($result);// закрытие БД
    return true;
}


  function selectItem2(){// функция возвращает содержимое каталога товаров по нужному id
  global $link;
  $id=$_COOKIE["page"];// получение id товара из cookie
  $sql = "SELECT title, author, pubyear, price, golosm2, golosp2, name, id
            FROM catalog WHERE id =$id";// SQL-запрос на выборку данных из таблицы catalog. 
  if(!$result = mysqli_query($link, $sql))
    return false;
  $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_free_result($result);
  return $items; // возвращение параметров title, author, pubyear, price, golosm2, golosp2, name, id 
}
 
 
function addItemToCatalog3($title, $author, $pubyear, $price, $name)// Функция сохраняет новый товар в таблицу catalog 
{
global $link;// обращение к глобальной переменной
  $sql = "INSERT INTO catalog(title, author, pubyear, price, name)
                      VALUES(?, ?, ?, ?, ?)";
if(!$stmt = mysqli_prepare($link, $sql))// подготовленный запрос:
    return false;
  mysqli_stmt_bind_param($stmt, "ssiis", 
                         $title, $author, $pubyear, $price, $name);// параметры для запроса
  mysqli_stmt_execute($stmt);// выполнение подготовленного запроса с переданными параметрами
  mysqli_stmt_close($stmt);// закрытие соединения с БД
  return true;
}   


function add2comm($id, $name, $comm)// добавлене записи в таблицу comments (комментариев) к товару по его id 
{
global $link;// обращение к глобальной переменной
  $sql = "INSERT INTO comments(id_catalog, name, txt)
                      VALUES(?, ?, ?)";
if(!$stmt = mysqli_prepare($link, $sql))// подготовительный запрос
    return false;
  mysqli_stmt_bind_param($stmt, "iss", 
                         $id, $name, $comm);// параметры для подготовительного запроса
  mysqli_stmt_execute($stmt);// выполненеие подготовленного запроса с переданными параметрами
  mysqli_stmt_close($stmt);// закрытие соединения с БД
  return true;
}


function savePage($id){// функция создание cookie с id продукта для загрузки данных товара на страницу "page.php"
  setcookie("page", $id);
}


  function myBasket2(){// функция возвращает все комментарии по id товара
  global $link;
  $id=$_COOKIE["page"];
  $sql = "SELECT name, txt
            FROM comments WHERE id_catalog =$id";// SQL-запрос на выборку данных из таблицы 
  if(!$result = mysqli_query($link, $sql))
    return false;
  $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_free_result($result);
  return $items;
}


function clearStr($data){// очистка текста от тегов
  global $link;
  $data = trim(strip_tags($data));
  return mysqli_real_escape_string($link, $data);// экранируем строки
}


function clearInt($data){ // получаем из текста число
  return (int)$data;
}


function clearUint($data){// получаем модульчисла
  return abs(clearInt($data));
}


function selectAllItems(){// функция возвращает все содержимое каталога товаров в виде ассоциативного массива 
  global $link;
  $sql = "SELECT id, title, author, pubyear, price, golosm2, golosp2,name
            FROM catalog";// SQL-запрос на выборку данных из таблицы catalog. 
  if(!$result = mysqli_query($link, $sql))
    return false;
  $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_free_result($result);
  return $items;
}


function saveBasket(){// Функцию сохраняет корзину с товарами в cookie
  global $basket;// обращение к глобальной переменной "$basket"
  $basket = base64_encode(serialize($basket));// Для сохранения целостности применяем "base64_encode(serialize())"
  setcookie("basket", $basket, 0x7FFFFFFF);// создаем cookie "basket" со значением $basket на длительный срок 0x7FFFFFFF
}


function basketInit(){// Функцию создает либо загружает в переменную $basket корзину с товарами, либо создает новую корзину с идентификатором заказа 
  global $basket, $count;
  if(!isset($_COOKIE["basket"])){// если cookie не задана
    $basket = ["orderid" => uniqid()];// создание идентификатора посетителя, помешенный в первую запись массива
    saveBasket();// и создать cookie
  }else{// если cookie есть
    $basket = unserialize(base64_decode($_COOKIE["basket"]));// разшифровываем "unserialize(base64_decode" содержание cookie посетителя
    $count = count($basket) - 1;// число записей в корзине( -1 , т.к. первая запись это идентификатьр гостя)
  }
}


function add2Basket($id){//	Функция добавляет товар в корзину пользователя и принимает в качестве аргумента идентификатор товара 
  global $basket;
  $basket[$id] = 1;
  saveBasket();
}


function myBasket(){// функция возвращает всю пользовательскую корзину в виде ассоциативного массива 
  global $link, $basket;// обрвщение к глоб пер
  $goods = array_keys($basket);// получаем ключи от массива(id товара)
  array_shift($goods); // извлекаем первый элемент масссива (идентификатор клиента?)
  if(!$goods)// если переменная пустая - кроме id клиента ничего не было возвращаем фолс
    return false;
  $ids = implode(",", $goods); // преобразуем массив ключей в строку с разделителями ","
  $sql = "SELECT id, author, title, pubyear, price, name 
            FROM catalog WHERE id IN ($ids)";// выводим таблицу товара с указанными $ids
  if(!$result = mysqli_query($link, $sql)) 
    return false; // если не передан объект фолс
  $items = result2Array($result); // функцию result2Array($data), которая принимает результат выполнения функции myBasket и возвращает ассоциативный массив товаров, дополненный их количеством 
  mysqli_free_result($result); 
  return $items;
}


function result2Array($data){// функцию result2Array($data), которая принимает результат выполнения функции myBasket и возвращает ассоциативный массив товаров, дополненный их количеством 
  global $basket; 
  $arr = []; 
  while($row = mysqli_fetch_assoc($data)){ 
    $row['quantity'] = $basket[$row['id']]; 
    $arr[] = $row; 
  } 
  return $arr;
}


function deleteItemFromBasket($id){ // Функция удаляет товар из корзины, принимая в качестве аргумента его идентификатор 
  global $basket;// обращение к глобальной переменной "$basket"
  unset ($basket[$id]);// Удаляет элемент массива со значением "$id"
  savebasket();// Функция сохраняет корзину с товарами в cookie 
}


function saveCustomerData($name, $email, $phone, $addr){// запись заказа в текстовый файл "admin/".ORDERS_LOG
  global $basket;// обращение к глобальной переменной "$basket"
  $oid = $basket["orderid"];// идентификатор заказа из первого элемента массива, хронящегося в cookie
  $dt = time();// временная метка
  $order = "$name|$email|$phone|$addr|$oid|$dt\n";// в переменной "$order" находиться формат записи данных в файл: имя покупателя|email покупателя|телефонный номер покупателя|адрес покупателя|идентификатор заказа|дата/время заказа
  file_put_contents("admin/".ORDERS_LOG, $order, FILE_APPEND);//запись переменной  $order в конец файла, имя которого хранится в константе ORDERS_LOG. Сам файл находится в папке eshop\admin 
  return $dt;// функция возвращает временную метку даты заказа 
}


function saveOrder($dt){// функция записывает в таблицу "orders" БД данные о заказе из корзины: title, author, pubyear, price, quantity, orderid, datetime и принимает в качестве аргумента дату и время заказа в виде временной метки 
  global $link, $basket;
  $goods = myBasket();// функция возвращает всю пользовательскую корзину в виде ассоциативного массива
  $stmt = mysqli_stmt_init($link);// соединения с БД по ссылке
  $sql = 'INSERT INTO orders (
                       title, 
                       author, 
                       pubyear, 
                       price, 
                       quantity, 
                       orderid, 
                       datetime) 
                VALUES (?, ?, ?, ?, ?, ?, ?)';
  if (!mysqli_stmt_prepare($stmt, $sql))// подготовленный запрос для предварительного разбора сервером
    return false;// если не пришел объект, то функция возвращает "false"
  foreach($goods as $item){ // перебор массива корзины с целью передачи параметров серверу для запроса 
    mysqli_stmt_bind_param($stmt, "ssiiisi", 
                         $item['title'], $item['author'],
                         $item['pubyear'], $item['price'],
                         $item['quantity'], $basket['orderid'], 
                         $dt);
    mysqli_stmt_execute($stmt);// выполнение подготовленного запроса
  }
  mysqli_stmt_close($stmt);// закрытие БД

  removeBasket();// удалите cookie пользователя
  return true;
}


function removeBasket(){// удалите cookie пользователя
  setcookie("basket", "", time()-3600);
}


function getOrders(){// функция возвращает многомерный массив с информацией о всех заказах, включая персональные данные покупателя и список его товаров
  global $link; 
  if(!is_file(ORDERS_LOG))// если нет файла с данными покупателя
    return false; 
  $orders = file(ORDERS_LOG);// получаем в виде массива персональные данные пользователей из файла
  $allorders = []; // массив, который будет возвращен функцией
  foreach ($orders as $order) { 
    list($name, $email, $phone, $address, $orderid, $date) = explode("|", $order);// разбиение записей по символу "|"
        $orderinfo = []; // создание асоциативного масива для хронения информации о заказчике
    /* Сохранение информацию о конкретном пользователе */ 
    $orderinfo["name"] = $name; 
    $orderinfo["email"] = $email; 
    $orderinfo["phone"] = $phone; 
    $orderinfo["address"] = $address; 
    $orderinfo["orderid"] = $orderid; 
    $orderinfo["date"] = $date; 
    /* SQL-запрос на выборку из таблицы orders всех товаров для конкретного покупателя */ //'$orderid'
    $sql = "SELECT title, author, pubyear, price, quantity 
              FROM orders 
              WHERE orderid = '$orderid'"; 
    /* Получение результата выборки */ 
    if(!$result = mysqli_query($link, $sql)) 
      return false; 
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result); 
    /* Сохранение результата в промежуточном массиве */ 
    $orderinfo["goods"] = $items; // Формирование масиыа 2го уровня с данными о конкретном заказчике и его заказе
    /* Добавление промежуточного массива в возвращаемый массив */ 
    $allorders[] = $orderinfo; 
  } 
  return $allorders;
}