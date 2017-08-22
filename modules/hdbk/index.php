<?php 
	include_once "../../system/common/inc.init.php"; 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, minimum-scale=1">
	<title>Планирование педприятием ОАО "Брестжилпроект"</title>

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
		.wrap-content .panel-title{
			color: #607B8B;
		}
		
		.wrap-content .panel-title a{
			text-decoration: none; 
			font-weight: bold;
			text-transform: uppercase;
		}
		
		.wrap-content .panel-body p{
			cursor: pointer;
			margin-left: 20px;
		}
		
		.wrap-content .panel-body p:hover{
			font-weight: bold;
		}
	</style>
</head>
<body>
	<!-- /***Поключение меню***/ --> 
	<?php include_once "../../system/common/inc.menu.php"; ?>
	
	<!-- /***Контент***/ -->
	<div canvas="container">
		<div class="col-md-12">
			<div class="row">
				<div class="hello-user" style="margin-top: 5px; float: right; width: 100%; text-align: center; margin-bottom: 5px;">
					<a id="simple-menu" href="#sidr"><button class="btn btn-info" style="float: left; margin-left: 15px;">&#9776; МЕНЮ</button></a>
					<button id="logout-user" class="btn btn-danger" type="button" style="float: right; margin-right: 15px;"><span class="glyphicon glyphicon glyphicon glyphicon-log-out"></button>
					<div class="user-name" style="font-size: 15px; border-bottom: 1px solid silver; font-weight: bold; padding-bottom: 20px; margin-bottom: 5px; width: 100%;">Здравствуйте, Геннадий Антонович!</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-hdd">
							<span style="text-transform: uppercase; font-weight: bold; font-size: 22px; word-spacing: -15px;">Справочники</span>
						</h3>
						
					</div>
					
					<div class="wrap-content">
						<div class="col-md-5">
							<div class="row" style="padding-right: 3px;">
								<div class="panel-group" id="accordion" style="padding: 5px 0px 0px 0px;">
									<!-- 1 панель -->
									<div class="panel panel-default">
										<!-- Заголовок 1 панели -->
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="glyphicon glyphicon-list-alt"></span>
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Планирование</a>
											</h4>
										</div>
										<div id="collapseOne" class="panel-collapse collapse in">
										<!-- Содержимое 1 панели -->
											<div class="panel-body">
												<p id="types_of_jobs_full">Виды выполняемых работ</p>
												<p id="source_of_finance_full">Источник финансирования</p>
												<p id="doc_reason_for_development_psd_full">Документ - основание на разработку ПСД</p>
												<p id="customers_full">Заказчики</p>
											</div>
										</div>
									</div>
									<!-- 2 панель -->
									<div class="panel panel-default">
										<!-- Заголовок 2 панели -->
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Персонал</a>
											</h4>
										</div>
										<div id="collapseTwo" class="panel-collapse collapse">
											<!-- Содержимое 2 панели -->
											<div class="panel-body">
												<p id="education_full">Образование</p>
												<p id="function_full">Должность</p>
												<p id="subdivision_full">Подразделение</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-7 show-full-hdbk" style="display: none;">
							<div class="row" style="margin-top: 5px;">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">
											<span class="hdbk-name" style="font-weight: bold; font-size: 14px;">Выберите справочник</span>
										</h3>
										
										<button class="btn btn-primary add-hdbk" style="float: right; margin-top: -25px;" data-tooltip="tooltip" data-placement="left" title="Добавить запись" data-toggle="modal" data-target="#modal-add-hdbk"><span class="glyphicon glyphicon-plus"></span></button>
										
									</div>
									<div class="response-hdbk-full"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Модальное окно редактирования справочников -->

	<div id="modal-edit-hdbk" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
					<h4 class="modal-title">Редактирование справочника</h4>
				</div>
				<form id="form-edit-hdbk" class="form-inline" method="post">
					<div class="modal-body"></div>
					<div class="modal-footer" style="display: inline-block; width: 100%;">
						<div class="col-md-9">
							<div class="row">
								<div class="ajax-resp"></div>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="row btn-save-hdbk">
								<button class="btn btn-primary" type="submit">Сохранить</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- Модальное окно - вопрос об удалении записи из справочника -->
	
	<div id="modal-delete-hdbk" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
					<h4 class="modal-title">Удаление записи</h4>
				</div>
				<form id="form-delete-hdbk" class="form-inline" method="post">
					<div class="modal-body"></div>
					<div class="modal-footer" style="display: inline-block; width: 100%;">
						<div class="col-md-9">
							<div class="row">
								<div class="ajax-resp"></div>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="row btn-delete-hdbk">
								<button class="btn btn-primary" type="submit">Удалить</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- Модальное окно - добавление новой записи в справочник -->
	
	<div id="modal-add-hdbk" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
					<h4 class="modal-title">Добавление записи</h4>
				</div>
				<form id="form-add-hdbk" class="form-inline" method="post">
					<div class="modal-body"></div>
					<div class="modal-footer" style="display: inline-block; width: 100%;">
						<div class="col-md-9">
							<div class="row">
								<div class="ajax-resp"></div>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="row btn-add-hdbk">
								<button class="btn btn-primary add-to-hdbk" type="submit">Добавить</button>
							</div>
						</div>
					</div>
				</form>
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
	
	<script src="<?php echo $name_host; ?>/modules/hdbk/hdbk.js"></script>
</body>
</html>