<?php 
	include_once "../../../system/common/inc.init.php"; 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, minimum-scale=1">
	<title>Планирование педприятием ОАО "Брестжилпроект" - УРОВЕНЬ 1</title>

	<!-- Bootstrap -->
	<link href="<?php echo $name_host; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $name_host; ?>/assets/css/chosen/chosen.min.css" rel="stylesheet">
	<link href="<?php echo $name_host; ?>/assets/css/slidebars.min.css" rel="stylesheet">
	<link href="<?php echo $name_host; ?>/assets/css/style.css" rel="stylesheet">
	<link href="<?php echo $name_host; ?>/system/sidr/dist/stylesheets/jquery.sidr.light.min.css" rel="stylesheet">
	<!--<link href="https://fonts.googleapis.com/css?family=Exo+2|Lobster|PT+Sans" rel="stylesheet"> -->
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
		#working_obj, #types_of_jobs_obj, #all_info_obj{
			width: 100%; 
			float: left; 
			display: none;
		}
	</style>
</head>
<body>
	<!-- /***Поключение меню***/ --> 
	<?php include_once "../../../system/common/inc.menu.php"; ?>
	<!-- /***Контент***/ -->
	<div canvas="container" style="height: 100%; overflow: auto; float: left;">
		<div class="col-md-12">
			<div class="row">
				<div class="hello-user" style="margin-top: 5px; float: right; width: 100%; text-align: center; margin-bottom: 5px;">
					<a id="simple-menu" href="#sidr"><button class="btn btn-info" style="float: left; margin-left: 15px;">&#9776; МЕНЮ</button></a>
					<button id="logout-user" class="btn btn-danger" type="button" style="float: right; margin-right: 15px;"><span class="glyphicon glyphicon glyphicon glyphicon-log-out"></button>
					<div class="user-name" style="font-size: 15px; border-bottom: 1px solid silver; font-weight: bold; padding-bottom: 20px; margin-bottom: 5px; width: 100%;">Здравствуйте, Геннадий Антонович!</div>
				</div>
			</div>
		</div>
		
		<div style="width: 100%; float: left;">
			<div class="col-md-12 col-lg-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-list-alt" style="font-size: 70%;"></span>
							<span style="text-transform: uppercase; font-weight: bold; font-size: 90%;">Планирование работы Подразделений</span>
						</h3>
						
						<div style="width: 100%; margin-top: 10px;">
							<select class="chosen-select" name="subdivision_list" data-placeholder="Выберите подразделение"></select>
						</div>
					</div>	
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-list-alt" style="font-size: 70%;"></span>
							<span style="text-transform: uppercase; font-weight: bold; font-size: 90%;">Объекты в работе</span>
						</h3>
						
						<div id="show_obj_list" style="width: 100%; margin-top: 10px;"></div>
					</div>	
				</div>
			</div>
			
			<div id="view-obj" style="width: 100%; display: none;">
				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="glyphicon glyphicon-list-alt" style="font-size: 70%;"></span>
								<span style="text-transform: uppercase; font-weight: bold; font-size: 90%;">Просмотр объекта</span>
							</h3>
							
							<div id="response-view-obj" style="width: 100%; margin-top: 10px;"></div>
						</div>	
					</div>
					<p>
				<div id="container"></div>
				</div>
			</div>
			
			<div id="edit-obj" style="width: 100%; display: none;">
				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="glyphicon glyphicon-list-alt" style="font-size: 70%;"></span>
								<span style="text-transform: uppercase; font-weight: bold; font-size: 90%;">Редактирование объекта</span>
							</h3>
							
							<div id="response-edit-obj" style="width: 100%; margin-top: 10px;"></div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="<?php echo $name_host; ?>/assets/js/jquery-3.1.1.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?php echo $name_host; ?>/system/sidr/dist/jquery.sidr.min.js"></script>
	<script src="<?php echo $name_host; ?>/assets/js/bootstrap.min.js"></script>
	<script src="<?php echo $name_host; ?>/assets/js/chosen.min.js"></script>
	<script src="<?php echo $name_host; ?>/assets/js/common.js"></script>
	
	<script src="<?php echo $name_host; ?>/assets/highcharts/code/highcharts.js"></script>
	<script src="<?php echo $name_host; ?>/assets/highcharts/code/modules/exporting.js"></script>

	<script src="<?php echo $name_host; ?>/modules/planning/3/planning_3.js"></script>
</body>
</html>