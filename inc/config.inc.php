<?php
const DB_HOST = "localhost"; //константы для хранения адреса сервера баз данных mySQL 
const DB_LOGIN = "root";//пользователь
const DB_PASSWORD = "";//пусой пароль
const DB_NAME = "eshopg";//имя базы данных

const ORDERS_LOG = "orders.log";//имя файла для хранения данных о заказчиках

$basket = []; // Корзина покупателя
$count = 0; // Кол-во товаров в корзине
$golos=[];// пустой массив для голосования за товар

$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);//установка соединения с БД
if(!$link){
  echo "Магазин не работает.";
  exit;
}//проверка на подключение
basketInit();//  Функцию создает либо загружает в переменную $basket корзину с товарами, либо создает новую корзину с идентификатором заказа 

