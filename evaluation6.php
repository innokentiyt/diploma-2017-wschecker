<?php

session_start();

require_once('auth_check.php'); // проверка авторизации пользователя

require_once('db_connect.php'); // подключение SQL-базы данных

require_once('userinfo.php'); // получение информации о пользователе

if(!isset( $_POST['step'], $_POST['standards'], $_POST['level'], $_POST['relevantmeasures'])) {
	header("Location: evaluation.php");
} else {
	// очистка полей
	$standard = filter_var($_POST['standards'], FILTER_SANITIZE_STRING);
	$step = filter_var($_POST['step'], FILTER_SANITIZE_STRING);
	$level = filter_var($_POST['level'], FILTER_SANITIZE_STRING);
}
if($step != "5") {
	header("Location: evaluation.php");
}

$relevantarea = unserialize($_POST['relevantareas']);
$relevantmeasure = $_POST['relevantmeasures'];

// загрузка файла стандарта
$standardXML = simplexml_load_file("standards/standard".$standard.".xml");

$area = array();
array_push($area, 0);
$j = 0;
foreach($relevantmeasure as $rm) {
	$values = explode("-",$rm);
	if($values[0] > $area[$j]) {
		array_push($area, $values[0]);
		$j++;
	}
}

array_shift($area);
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
      <div class="navbar navbar-inverse hidden-print" role="navigation">
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
		Отчёт<br>
		<small>об оценке требуемого уровня безопасности для веб-приложения</small>
	</h3>
	<br>
	
	<form class="form-horizontal" id="evaluation-step6" action="evaluation_submit.php" method="post">
	<fieldset>
	<input type="hidden" name="step" value="5">
	<input type="hidden" name="standards" value="<?php echo $standard?>">
	<input type="hidden" name="level" value="<?php echo $level ?>">
	<!-- Multiple Checkboxes -->
	<h4>Выбранный стандарт безопасности:</h4>
	<p><?php echo $standardXML->name ?></p>
	<br>
	<h4><?php echo $standardXML->initialcheck->name ?>:</h4>
	<p>Был определен уровень верификации <?php echo $standardXML->levels->level[(int) $level]->name; ?></p>
	<br>
	<h4>Список предлагаемых средств контроля безопасности (security measures):</h4>
	<?php foreach($area as $a): ?>
	<div class="form-group">
		<label class="col-md-2 control-label" ><?php echo $standardXML->areas->area[$a-1]->name; ?></label>
		<div class="col-md-10" style="padding-top: 7px">
			<?php foreach($relevantmeasure as $rm): ?>
				
				<?php
				$values = explode("-",$rm);
				if($values[0] == $a) {
					$t = (int) $values[1];
					echo "<div class=\"col-md-7\" style=\"padding-left: 0px !important\">".$standardXML->areas->area[$a-1]->measures->measure[$t]->description."</div>";
				}
				?>
			<?php endforeach; ?>
		</div>
	</div>
		
	<?php endforeach; ?>
	
	
	<br>
	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-2 control-label" for="singlebutton"></label>
	  <div class="col-md-7 hidden-print">
		<button id="singlebutton" name="singlebutton" class="btn btn-primary">Сохранить в системе</button>
		<input type="button" class="btn btn-primary" value="Печать" onclick="print()"></input>
	  </div>
	</div>

	</fieldset>
	</form>
	
	<hr>
	<div class="hidden-print">
	<?php
	echo "<p class=\"text-muted\">".$userinfo['username']."<br>";
	echo "<small>Тип аккаунта: <b>".$userinfo['typename']."</b></small></p>";
	?>
	<p><a href="logout.php">Выход из системы</a> | <a href="logout.php">Регистрация нового пользователя</a></p>
    </div>
	</div>
	<!-- /container -->
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="validator.js"></script>
  </body>
</html>