<?php

session_start();

require_once('auth_check.php'); // проверка авторизации пользователя

require_once('db_connect.php'); // подключение SQL-базы данных

require_once('userinfo.php'); // получение информации о пользователе

if(!isset( $_POST['step'], $_POST['standards'])) {
	header("Location: evaluation.php");
} else {
	// очистка полей
	$standard = filter_var($_POST['standards'], FILTER_SANITIZE_STRING);
	$step = filter_var($_POST['step'], FILTER_SANITIZE_STRING);
}
if($step != "2") {
	header("Location: evaluation.php");
}

// загрузка файла стандарта
$standardXML = simplexml_load_file("standards/standard".$standard.".xml");

$numberofquestions = (int) $standardXML->initialcheck->numberofquestions; // количество начальных вопросов
$numberoflevels = (int) $standardXML->levels->numberoflevels; // количество уровней верификации

// определение уровня верификации на основе ответов и выделение мер безопасности
$level = 1;
$areas = array();
for($i = 1; $i <= $numberofquestions; $i++) {
	$values = explode("-",$_POST['radios-'.$i]);
	if($values[1] == "yes" && $values[0] > $level) {
		$level = $values[0];
	}
	if($values[1] == "yes") {
		array_push($areas, $values[2]);
	}
}

// убираем повторяющиеся элементы из массива
$areas = array_unique($areas);

natsort($areas);

$finalareas = implode("-", $areas);

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
		<?php echo $standardXML->levels->name; ?><br>
		<small><?php echo $standardXML->levels->description; ?></small>
	</h3>
	<br>
	
	
	<form class="form-horizontal" id="evaluation-step3" action="evaluation4.php" method="post">
	<fieldset>
	<input type="hidden" name="step" value="3">
	<input type="hidden" name="standards" value="<?php echo $standard?>">
	<input type="hidden" name="areas" value="<?php echo $finalareas ?>">
	<!-- Multiple Radios -->
	<div class="form-group">
		<label class="col-md-2 control-label" for="radios"></label>
		<div class="col-md-7">
			<?php for($i = 0; $i < $numberoflevels; $i++): ?>
			<div class="radio">
				<label for="radios-<?php echo ($i+1)?>">
					<input type="radio" name="level" id="radios-<?php echo ($i+1)?>" value="<?php echo ($i+1) ?>" <?php if($i+1 == $level) echo "checked" ?>>
					<?php echo $standardXML->levels->level[$i]->name; ?>
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
		<?php echo $standardXML->levels->info ?></div>
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