<?php

session_start();

require_once('db_connect.php'); // переменная $conn

$message = 'Что-то пошло не так.';


if(!isset( $_POST['username'], $_POST['password'], $_POST['usertype'])) {
	$message = "Заполните все поля.";
	$flag = 1;
} else {
	// очистка полей
	$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
	$usertype = filter_var($_POST['usertype'], FILTER_SANITIZE_STRING);
	
	// шифрование пароля
	$password = sha1( $password );
	
	try	{
		if($usertype == "basic") {
			$usertype = 1;
		} elseif($usertype == "basic") {
			$usertype = 1; // для новых типов пользователей
		} else {
			$message = "Тип аккаунта, который вы указали, не существует.";
			$flag = 1;
			break 2;
		}
		$stmt2 = $conn->prepare("INSERT INTO users (`username`, `password`, `type`) VALUES (:username, :password, :type)");
						
		$stmt2->bindParam(':username', $username, PDO::PARAM_STR, 20);
		$stmt2->bindParam(':password', $password, PDO::PARAM_STR, 40);
		$stmt2->bindParam(':type', $usertype, PDO::PARAM_INT);
		
		$stmt2->execute();
		
		$message = "Пользователь успешно добавлен!";
		$flag = 0;
		
	} catch(Exception $e) {
		/*** check if the username already exists ***/
		if( $e->getCode() == 23000) {
			$message = 'Попытка создать дубль. Попробуйте другой логин.';
			$flag = 1;
		}
		else {
			/*** if we are here, something has gone wrong with the database ***/
			$message = 'Что-то пошло не так.';
			$flag = 2;
		}
		echo $e;
	}
}


if($flag == 1) {
	header("Location: adduser.php?error=$message");
} elseif ($flag == 2) {
	header("Location: adduser.php?success=$message");
} elseif ($flag == 0) {
	header("Location: adduser.php?success=$message");
}

?>