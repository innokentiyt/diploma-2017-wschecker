<?php

session_start();

require_once('auth_check.php'); // проверка авторизации пользователя

require_once('db_connect.php'); // подключение SQL-базы данных

require_once('userinfo.php'); // получение информации о пользователе

if(!isset( $_POST['step'], $_POST['standards'], $_POST['level'], $_POST['relevantarea'])) {
	header("Location: evaluation.php");
} else {
	// очистка полей
	$standard = filter_var($_POST['standards'], FILTER_SANITIZE_STRING);
	$step = filter_var($_POST['step'], FILTER_SANITIZE_STRING);
	$level = filter_var($_POST['level'], FILTER_SANITIZE_STRING);
}
if($step != "4") {
	header("Location: evaluation.php");
}

$area = explode("-",$areas);

$relevantarea = $_POST['relevantarea'];

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
		<?php echo $standardXML->areas->name2; ?><br>
		<small><?php echo $standardXML->areas->description2; ?></small>
	</h3>
	<br>
	
	<form class="form-horizontal" id="evaluation-step5" action="evaluation6.php" method="post">
	<fieldset>
	<input type="hidden" name="step" value="5">
	<input type="hidden" name="standards" value="<?php echo $standard?>">
	<input type="hidden" name="level" value="<?php echo $level ?>">
	<!-- Multiple Checkboxes -->
	<?php foreach($relevantarea as $ra): ?>
	<div class="form-group">
		<?php
		$numberofmeasures = $standardXML->areas->area[$ra-1]->numberofmeasures;
		?>
		<label class="col-md-2 control-label" ><?php echo $standardXML->areas->area[$ra-1]->name; ?></label>
		<div class="col-md-10" style="padding-top: 7px">
			<?php for($i=0; $i<$numberofmeasures; $i++): ?>
			<div class="form-group">
				<div class="col-md-7" style="padding-left: 15px !important">
				<?php
				if($standardXML->areas->area[$ra-1]->measures->measure[$i]->l3 == "yes" && $level == 3)
					echo $standardXML->areas->area[$ra-1]->measures->measure[$i]->description;
				if($standardXML->areas->area[$ra-1]->measures->measure[$i]->l2 == "yes" && $level == 2)
					echo $standardXML->areas->area[$ra-1]->measures->measure[$i]->description;
				if($standardXML->areas->area[$ra-1]->measures->measure[$i]->l1 == "yes" && $level == 1)
					echo $standardXML->areas->area[$ra-1]->measures->measure[$i]->description;
				?>
				
				</div>
				<div class="col-md-3">
					<div class="checkbox" style="padding-top: 0px !important">
						<label for="checkboxes-<?php echo $ra."-".$i ?>">
							<input type="checkbox" name="relevantmeasures[]" id="checkboxes-<?php echo $ra."-".$i ?>" value="<?php echo $ra."-".$i ?>" checked>
							Включить в отчет
						</label>
					</div>
				</div>
			</div>
			<?php endfor; ?>
		</div>
	</div>
	<?php endforeach; ?>
	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-2 control-label" for="singlebutton"></label>
	  <div class="col-md-7">
		<button id="singlebutton" name="singlebutton" class="btn btn-primary">Продолжить</button>
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