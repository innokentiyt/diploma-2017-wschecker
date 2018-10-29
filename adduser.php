<?php

/*** begin our session ***/
session_start();

require_once('db_connect.php');

/*** set a form token ***/
$form_token = md5( uniqid('auth', true) );

/*** set the session form token ***/
$_SESSION['form_token'] = $form_token;
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>Регистрация</title>

    <link href="navbar.css" rel="stylesheet">

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
	  
	<center><h3>Регистрация нового пользователя</h3></center>
	<hr>
	<!-- уведомления -->
	<?php if(isset($_GET['error'])): ?>
	<div class="alert alert-danger">
        <strong><?php echo $_GET['error'] ?></strong>
    </div>
	<?php endif; ?>
	
	<?php if(isset($_GET['success'])): ?>
	<div class="alert alert-success">
        <strong><?php echo $_GET['success'] ?></strong>
    </div>
	<?php endif; ?>

	<form class="form-horizontal" id="form" role="form" data-toggle="validator" action="adduser_submit.php" method="post">
	  <div class="form-group">
		<label for="username" class="col-sm-2 control-label">Логин</label>
		<div class="col-sm-10">
		  <input type="text" class="form-control" id="username" data-minlength="4" maxlength="20" name="username" placeholder="Придумайте логин (минимум 4 символа, латинские буквы, цифры, черточка, подчеркивание)" pattern="^([-_A-z0-9]){4,20}$" required>
		</div>
	  </div>
	  <div class="form-group">
		<label for="password" class="col-sm-2 control-label">Пароль</label>
		<div class="col-sm-10">
		  <input type="password" class="form-control" id="password" data-minlength="6" maxlength="40" name="password" placeholder="Придумайте пароль (минимум 6 символов, латинские буквы, цифры, черточка, подчеркивание)" pattern="^([-_A-z0-9]){6,40}$" required>
		</div>
	  </div>
	  <div class="form-group">
		<label for="password-2" class="col-sm-2 control-label"></label>
		<div class="col-sm-10">
		  <input type="password" class="form-control" id="password-2" data-minlength="6" maxlength="40" placeholder="Введите пароль ещё раз" required data-match="#password" pattern="^([-_A-z0-9]){6,40}$">
		</div>
	  </div>
	  <div class="form-group">
		<label for="usertype" class="col-sm-2 control-label">Тип аккаунта</label>
		<div class="col-sm-10">
			<select class="form-control" id="usertype" name="usertype" required>
				<?php
				
					$stmt = $conn->query('SELECT name FROM types');
					while ($row = $stmt->fetch()) {
						echo "<option>".$row['name']."</option>";
					}
				
					$conn = null;
				?>
			</select>
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		  <button type="submit" class="btn btn-default">Регистрация</button>
		  <p><br><a href="login.php">Назад на страницу входа</a></p>
		</div>
	  </div>
	</form>


    </div> <!-- /container -->
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="validator.js"></script>
  </body>
</html>