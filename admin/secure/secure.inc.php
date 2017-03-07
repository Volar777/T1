<?
const FILE_NAME = ".htpasswd";// Создание константу для хранения паролей пользователей FILE_NAME со значением .htpasswd 

function getHash($password){

  $hash = password_hash($password, PASSWORD_BCRYPT);// Генерация стойкого хэша со случайной солью. 
  return $hash; 
}

function checkHash($password, $hash){ 
  return password_verify($password, $hash); 
}

function saveUser($login, $hash){
  $str = "$login:$hash\n"; 
  if(file_put_contents(FILE_NAME, $str, FILE_APPEND))//записываем логин и хешь в файл ".htpasswd" 
    return true; 
  else 
    return false; 
}

function userExists($login){
  if(!is_file(FILE_NAME)) //существует ли файл
    return false; 
  $users = file(FILE_NAME); // Читаем файл построчно в массив

  foreach($users as $user){ //перебор файла с логинами и пароляим
    if(strpos($user, $login.':') !== false)//strpos --  Возвращает позицию первого вхождения подстроки 
      return trim($user); 
  } 
  return false; 
} 

function logOut(){

  session_destroy(); 
  header('Location: secure/login.php'); 
  exit; 
}