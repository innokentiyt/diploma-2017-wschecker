<?php

session_start();

require_once('auth_check.php'); // проверка авторизации пользователя

require_once('db_connect.php'); // подключение SQL-базы данных

require_once('userinfo.php'); // получение информации о пользователе

if(!isset( $_POST['step'], $_POST['standards'], $_POST['areas'], $_POST['level'])) {
	header("Location: evaluation.php");
} else {
	// очистка полей
	$standard = filter_var($_POST['standards'], FILTER_SANITIZE_STRING);
	$step = filter_var($_POST['step'], FILTER_SANITIZE_STRING);
	$areas = filter_var($_POST['areas'], FILTER_SANITIZE_STRING);
	$level = filter_var($_POST['level'], FILTER_SANITIZE_STRING);
}
if($step != "3") {
	header("Location: evaluation.php");
}


$area = explode("-",$areas);

// загрузка файла стандарта
$standardXML = simplexml_load_file("standards/standard".$standard.".xml");

$numberofareas = (int) $standardXML->areas->numberofareas; // количество областей безопасности

?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>Проверить WebApp</title>

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
      <div class="navbar navbar-inverse" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <span class="navbar-brand">Оценка веб-приложения</span>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="index.php">Главная</a></li>
			  <li class="active"><a href="evaluation.php">Проверить WebApp</a></li>
              <li><a href="edit.php">Редактировать стандарты</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
	  
	<h3>
		<?php echo $standardXML->areas->name; ?><br>
		<small><?php echo $standardXML->areas->description; ?></small>
	</h3>
	<br>
	
	<form class="form-horizontal" id="evaluation-step4" action="evaluation5.php" method="post">
	<fieldset>
	<input type="hidden" name="step" value="4">
	<input type="hidden" name="standards" value="<?php echo $standard?>">
	<input type="hidden" name="level" value="<?php echo $level ?>">
	<!-- Multiple Checkboxes -->
	<div class="form-group">
		<label class="col-md-2 control-label" for="checkboxes">Области</label>
		<div class="col-md-7">
			<?php for($i = 0; $i < $numberofareas; $i++): ?>
			<div class="checkbox">
				<label for="checkboxes-<?php echo $i ?>">
					<input type="checkbox" name="relevantarea[]" id="checkboxes-<?php echo $i ?>" value="<?php echo ($i+1) ?>" <?php if($standardXML->areas->area[$i]->mandatory == "yes") echo "checked" ?> <?php foreach($area as $m) if($m == ($i+1)) echo " checked"?>>
					<?php echo $standardXML->areas->area[$i]->name; ?>
				</label>
			</div>
			<?php endfor; ?>
		</div>
	</div>
	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-2 control-label" for="singlebutton"></label>
	  <div class="col-md-7">
		<button id="singlebutton" name="singlebutton" class="btn btn-primary">Продолжить</button>
		<br><br><div class="alert alert-info"><span class="glyphicon glyphicon-info-sign" style="margin-right: 10px" aria-hidden="true"></span>
		<?php echo $standardXML->areas->info ?></div>
	  </div>
	</div>

	</fieldset>
	</form>
	
	
	<hr>
	<?php
	echo "<p class=\"text-muted\">".$userinfo['username']."<br>";
	echo "<small>Тип аккаунта: <b>".$userinfo['typename']."</b></small></p>";
	?>
	<p><a href="logout.php">Выход из системы</a> | <a href="logout.php">Регистрация нового пользователя</a></p>
    </div> <!-- /container -->
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="validator.js"></script>
  </body>
</html>