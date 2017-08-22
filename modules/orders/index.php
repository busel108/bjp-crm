<?php
	session_start();
 
	//include_once "../../system/common/inc.init.php"; 
	 
	$access = 1; 
	
	if (!isset($_SESSION["user"]))
		header("Location: ../../../index.php");
	else{
		$name_host = "http://" . $_SERVER["SERVER_NAME"]."/bzhp";
		
		$privateFIO = $_SESSION["user"]["user_f"] . ' ' . $_SESSION["user"]["user_i"] . '. ' . $_SESSION["user"]["user_o"];
		$privateSubdivision = $_SESSION["user"]["subdivision_name"];
		$privateFunction = $_SESSION["user"]["function_name"];
		//$privateAccess = $_SESSION["user"]["access"];
	}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, minimum-scale=1">
	<title>Отдел кадров ОАО "Брестжилпроект"</title>

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
					<div class="panel-heading panel-personal">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon glyphicon-user">
							<span style="text-transform: uppercase; font-weight: bold; font-size: 22px; word-spacing: -15px;">Выполнение документов</span>
						</h3>
						
						<button class="btn btn-primary" style="float: right; margin-top: -30px;" data-tooltip="tooltip" data-placement="left" title="Добавить документ" data-toggle="modal" data-target="#modal-add-order"><span class="glyphicon glyphicon-plus"></span></button>
						
					</div>

					<div class="table-orders">
						<div class="table-responsive">
							<table class="table table-hover table-bordered" style="width: 100%;">
								<thead style="background: rgba(0,0,0,.3);">
									<th style="text-align: center; vertical-align: top;">Тип документа</th>
									<th style="text-align: center; vertical-align: top;">Дата поступления</th>
									<th style="text-align: center; vertical-align: top;">Регистрационный номер</th>
									<th style="text-align: center; vertical-align: top;">Тема документа</th>
									<th style="text-align: center; vertical-align: top;">Корреспондент</th>
									<th style="text-align: center; vertical-align: top;">Просмотр документа</th>
									<th style="text-align: center;"><span class="glyphicon glyphicon-search"></span></th>
									<th style="text-align: center;"><span class="glyphicon glyphicon-edit"></span></th>
									<th style="text-align: center;"><span class="glyphicon glyphicon-trash"></span></th>
								</thead>
								<tbody class="orders-data"></tbody>
							</table>
						</div>
					</div>
					
				</div>
				
				<hr>
			</div>
		</div>

	</div>
	
	<!-- Модальные окна -->				
	<div id="modal-add-order" class="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
					<h4 class="modal-title">Добавление нового документа</h4>
				</div>
				<form id="form-add-order" class="form-inline" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<label>Тип документа</label><br>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="doc_type" data-placeholder="Тип документа"></select>
						</div>
					
						<label>Дата поступления</label><br>
						<div class="form-group" style="width: 100%;"><input class="form-control" style="width: 100%;" type="date" name="income_date" placeholder="Дата поступления"></div>
						<p><p>
						
						<label>Регистрационный номер</label><br>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="reg_num" placeholder="Регистрационный номер"></div>
						<label>Тема документа</label><br>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="topic" placeholder="Тема обращения"></div>
						
						<label>Корреспондент</label><br>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="corr" data-placeholder="Корреспондент"></select>
						</div>
						
						<label>Файл документа</label><br>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<input type="file" class="btn btn-default" name="file-doc" data-placeholder="Документ"></input>
						</div>
						<input type="hidden" name="action" value="form-add-order">
					</div>
					<div class="modal-footer" style="display: inline-block; width: 100%;">
						<div class="col-md-9">
							<div class="row">
								<div class="ajax-resp"></div>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="row">
								<button class="btn btn-primary" type="submit">Сохранить</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- Редактирование информации о поручении -->
	<div id="modal-edit-order" class="modal">
		<div class="modal-dialog modal-lg" style="width: 100%; height: 1000px; margin-top: 3px; margin-bottom: 0px; padding-left: 0px;">
			<div class="modal-content" style="border-radius: 0px;">
				<div class="modal-header" style="background: #EEE9E9;"><button class="close" type="button" data-dismiss="modal">×</button>
					<h4 class="modal-title" style="margin-left: 6px;">РЕДАКТИРОВАНИЕ ПОРУЧЕНИЯ №<span id="redact"></span></h4>
				</div>
				<form id="form-edit-order" class="form-inline" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<ul class="nav nav-tabs">
							<li id="edit-order-nav"><a href="#">Редактирование документа</a></li>
							<li id="add-exec-nav"><a href="#">Добавить исполнителей</a></li>
						</ul>
						<div id="show-object" style="width: 100%; height: 100%; float: left; overflow-y: scroll;">
							<div class="edit-order-div" style="width: 100%; float: left; height: 600px; display: block;">
								<label>Тип документа</label><br>
								<div class="form-group" style="width: 100%; margin-bottom: 10px;">
									<select class="chosen-select" name="doc_type" data-placeholder="Тип документа"></select>
								</div>
							
								<label>Дата поступления</label><br>
								<div class="form-group" style="width: 100%;"><input class="form-control" style="width: 100%;" type="date" name="income_date" placeholder="Дата поступления"></div>
								<p><p>
								
								<label>Регистрационный номер</label><br>
								<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="reg_num" placeholder="Регистрационный номер"></div>
								<label>Тема поручения</label><br>
								<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="topic" placeholder="Тема обращения"></div>
								
								<label>Корреспондент</label><br>
								<div class="form-group" style="width: 100%; margin-bottom: 10px;">
									<select class="chosen-select" name="corr" data-placeholder="Корреспондент"></select>
								</div>
								
								<div class="col-md-3">
									<div class="row">
										<button class="btn btn-primary" type="submit">Сохранить</button>
									</div>
								</div>
								
								<input type="hidden" name="order_id" value="">
							</div>
							<div class="add-exec-div" style="width: 100%; height: 600px; float: left; display: none;">
								<label><h3>Исполнители</h3></label>
								<button class="btn btn-primary" style="margin-left: 20px;" id="add-executor-btn" type="button">Добавить исполнителя</button>
								<div id="startup">Для данного документа поручения не добавлены.</div><p>
								<div class="exec-add">
								</div>
								
								<div class="col-md-3">
									<div class="row">
										<button class="btn btn-primary" type="submit">Сохранить</button>
									</div>
								</div>
						
								<input type="hidden" name="order_id" value="">
								<input type="hidden" name="counter" value="1">
								<input type="hidden" name="action" value="form-update-order">
							</div>
						</div>
					</div>
					<div class="modal-footer" style="display: inline-block; width: 100%;">
						<div class="col-md-9">
							<div class="row">
								<div class="ajax-resp"></div>
							</div>
						</div>
						
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- Просмотр информации о поручениях и исполнителях -->
	<div id="modal-view-order" class="modal">
		<div class="modal-dialog modal-lg" style="width: 100%; height: 1000px; margin-top: 3px; margin-bottom: 0px; padding-left: 0px;">
			<div class="modal-content" style="border-radius: 0px;">
				<div class="modal-header" style="background: #EEE9E9;"><button class="close" type="button" data-dismiss="modal">×</button>
					<h4 class="modal-title" style="margin-left: 6px;">ПРОСМОТР ДОКУМЕНТА №<span id="prosmotr"></span></h4>
				</div>
				<form id="form-view-order" class="form-inline" method="post">
					<div class="modal-body">
						<ul class="nav nav-tabs">
							<li id="view-order-nav"><a href="#">Просмотр документа</a></li>
							<li id="view-exec-nav"><a href="#">Просмотр поручений</a></li>
						</ul>
					
						<div id="show-object" style="width: 100%; height: 100%; float: left; overflow-y: scroll;">
							<div class="view-order-div" style="width: 100%; float: left; height: 600px; display: block;">
								<div class="table-one-order">
									<div class="table-responsive">
										<table class="table table-hover table-bordered" style="width: 50%;">
											<tbody class="one-order"></tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="view-exec-div" style="width: 100%; height: 600px; float: left; display: none;">
								<div class="table-executors" style="display: none;">
								<div class="table-responsive">
									<table class="table table-hover table-bordered" style="width: 100%;">
										<thead style="background: rgba(0,0,0,.3);">
											<th style="text-align: center; vertical-align: top;">№</th>
											<th style="text-align: center; vertical-align: top;">Должность</th>
											<th style="text-align: center; vertical-align: top;">ФИО исполнителя</th>
											<th style="text-align: center; vertical-align: top;">Дата исполнения</th>
											<th style="text-align: center; vertical-align: top;">Отметка об исполнении</th>
											<th style="text-align: center; vertical-align: top;">Документ ответа</th>
										</thead>
										<tbody class="executors-data"></tbody>
									</table>
								</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer" style="display: inline-block; width: 100%;">
						<div class="col-md-9">
							<div class="row">
								<div class="ajax-resp"></div>
							</div>
						</div>
						
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- Вывод ФИО сотрудников, у которых до окончания выполнения поручения осталось 2 дня и меньше-->
	<div id="modal-show-exec-expired" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"><button class="close close-modal-show-contract-expired" type="button" data-dismiss="modal">×</button>
					<h4 class="modal-title">Уведомление о сроках исполнения поручений</h4>
				</div>
				<div class="modal-contracts-head" style="padding: 19px; font-weight: bold; font-size: 16px;">
					Внимание! У следующих сотрудников менее, чем через два дня истекает срок выполнения поручения!
				</div>
				<div class="modal-text" style="padding: 19px; padding-top: 5px; line-height: 2;"><div class="exec-expired-text"></div></div>
				
				<div class="modal-footer">
					<div class="col-md-12">
						<button class="btn btn-primary" type="button" data-dismiss="modal">Закрыть</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<button class="btn btn-default btn-show-exec-expired" data-toggle="modal" data-target="#modal-show-exec-expired" type="submit" style="display: none;">Чекаво</button>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="<?php echo $name_host; ?>/assets/js/jquery-3.1.1.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?php echo $name_host; ?>/system/sidr/dist/jquery.sidr.min.js"></script>
	<script src="<?php echo $name_host; ?>/assets/js/bootstrap.min.js"></script>
	<script src="<?php echo $name_host; ?>/assets/js/chosen.min.js"></script>
	<script src="<?php echo $name_host; ?>/assets/js/common.js"></script>
	
	<script src="<?php echo $name_host; ?>/modules/orders/orders.js"></script>
</body>
</html>