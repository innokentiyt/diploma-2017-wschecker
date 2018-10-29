<?php

session_start();

require_once('auth_check.php'); // проверка авторизации пользователя

require_once('db_connect.php'); // подключение SQL-базы данных

require_once('userinfo.php'); // получение информации о пользователе

?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>Главная страница</title>

    <link href="navbar.css" rel="stylesheet">
	<link id="bsdp-css" href="datepicker/css/bootstrap-datepicker3.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <!-- Static navbar -->
      <div class="navbar navbar-inverse no-print" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <span class="navbar-brand">Оценка веб-приложения</span>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.php">Главная</a></li>
			  <li><a href="evaluation.php">Проверить WebApp</a></li>
              <li><a href="edit.php">Редактировать стандарты</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
	  
	<h3>Главная страница<br><small>Выберите дальнейшие действия</small></h3>
	<br>
	
	
	
	<h4>Начало работы</h4>
	<ul style="max-width: 800px;">
		<li>Подготовьте проектную документацию вашего разрабатываемого веб-приложения. </li>
		<li>Если он отстутствует в письменной форме, то сформулируйте, какие функции ваше веб-приложение реализует.</li>
		<li>Нажмите на ссылку "Проверить WebApp", чтобы начать процесс оценки безопасности вашего проекта.</li>
	</ul>
	
	<h4>Полезная информация</h4>
	<ul style="max-width: 800px;">
		<li>OWASP.org Application Security Verification Standard 3.0.1 (рекомендовано для всех веб-приложений). <a href="https://www.owasp.org/images/3/33/OWASP_Application_Security_Verification_Standard_3.0.1.pdf">Ссылка на документ (PDF)</a>.</li>
		<li>ISO/IEC 27002:2013 Information technology -- Security techniques -- Code of practice for information security controls (неофициальный перевод на русский) (релевантно для разработки систем менеджмента пользователей). <a href="http://pqm-online.com/assets/files/pubs/translations/std/iso-mek-27002-2013.pdf">Ссылка на документ (PDF)</a>.</li>
		<li>ГОСТ Р ИСО/МЭК 27001-2006 Информационная технология. Методы и средства обеспечения безопасности. Системы менеджмента информационной безопасности. Требования (релевантно для разработки систем менеджмента пользователей). <a href="http://www.internet-law.ru/gosts/gost/5736/">Ссылка на документ (HTML)</a>. </li>
	</ul>
	
	<hr>
	<?php
	echo "<p class=\"text-muted\">".$userinfo['username']."<br>";
	echo "<small>Тип аккаунта: <b>".$userinfo['typename']."</b></small></p>";
	?>
	<p class="no-print"><a href="logout.php">Выход из системы</a> | <a href="logout.php">Регистрация нового пользователя</a></p>
    </div> <!-- /container -->
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="validator.js"></script>
  </body>
</html>