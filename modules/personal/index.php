<?php 
	include_once "../../system/common/inc.init.php"; 
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
			
				<button class="btn btn-default btn-show-personal" type="submit">Персонал</button>
				<button class="btn btn-default btn-show-contracts" type="submit">Контракты</button>
				<button class="btn btn-default btn-show-contract-expired" data-toggle="modal" data-target="#modal-show-contract-expired" type="submit" style="display: none;">Чекаво</button>
				
				<div class="panel panel-default">
					<div class="panel-heading panel-personal">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon glyphicon-user">
							<span style="text-transform: uppercase; font-weight: bold; font-size: 22px; word-spacing: -15px;">Персонал</span>
						</h3>
						
						<button class="btn btn-primary" style="float: right; margin-top: -30px;" data-tooltip="tooltip" data-placement="left" title="Добавить сотрудника" data-toggle="modal" data-target="#modal-add-user"><span class="glyphicon glyphicon-plus"></span></button>
						
					</div>
					
					<div class="panel-heading panel-contracts">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon glyphicon-user">
							<span style="text-transform: uppercase; font-weight: bold; font-size: 22px; word-spacing: -15px;" class="label-personal">Контракты</span>
						</h3>
					</div>
					
					<div class="table-personal">
						<div class="table-responsive">
							<table class="table table-hover table-bordered" style="width: 100%;">
								<thead style="background: rgba(0,0,0,.3);">
									<th style="text-align: center;">Ф.И.О.</th>
									<th style="text-align: center;">Пол</th>
									<th style="text-align: center;">Дата рождения</th>
									<th style="text-align: center;">Образование</th>
									<th style="text-align: center;">Должность</th>
									<th style="text-align: center;">Дата приёма</th>
									<th style="text-align: center;"><span class="glyphicon glyphicon-edit"></span></th>
									<th style="text-align: center;"><span class="glyphicon glyphicon-trash"></span></th>
								</thead>
								<tbody class="personal-data"></tbody>
							</table>
						</div>
					</div>
					<div class="table-contracts">
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<thead style="background: rgba(0,0,0,.3);">
									<tr>
										<td rowspan="2" style="text-align: center; font-weight: bold;">Ф.И.О.</td>
										<td rowspan="2" style="text-align: center; font-weight: bold;">№ контракта</td>
										<td colspan="2" style="text-align: center; font-weight: bold;">Контракт</td>
										<td colspan="3" style="text-align: center; font-weight: bold;">До конца контракта</td>
										<td colspan="2" style="text-align: center; font-weight: bold;">Контракт продлен</td>
										<td rowspan="2" style="text-align: center;"><span class="glyphicon glyphicon-edit"></span></td>
									</tr>
									<tr>
										<td rowspan="1" style="text-align: center; font-weight: bold;">Дата начала</td>
										<td rowspan="1" style="text-align: center; font-weight: bold;">Дата окончания</td>
										<td rowspan="1" style="text-align: center; font-weight: bold;">Годы</td>
										<td rowspan="1" style="text-align: center; font-weight: bold;">Месяцы</td>
										<td rowspan="1" style="text-align: center; font-weight: bold;">Дни</td>
										<td rowspan="1" style="text-align: center; font-weight: bold;">С какого</td>
										<td rowspan="1" style="text-align: center; font-weight: bold;">По какое</td>
									</tr>
								</thead>
								<tbody class="contracts-data"></tbody>
							</table>
						</div>
					</div>

				</div>
				
				<hr>
				
				<div class="statistic-data">
				
					<div class="panel panel-default statistics">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="glyphicon glyphicon-file">
								<span style="text-transform: uppercase; font-weight: bold; font-size: 22px; word-spacing: -15px;">Статиcтические данные</span>
							</h3>
						</div>
						
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead style="background: rgba(0,0,0,.3);">
									<tr>
										<td rowspan="3" style="text-align: center; font-weight: bold; width: 280px;">Наименование показателя</td>
										<td rowspan="3" style="text-align: center; font-weight: bold;">Код строки</td>
										<td rowspan="3" style="text-align: center; font-weight: bold;">Cписочная численность работников на конец отчётного года (сумма граф 2,6)</td>
										<td colspan="5" style="text-align: center; font-weight: bold;">В том числе</td>
										<td rowspan="3" style="text-align: center; font-weight: bold;">Из графы 1 - женщины</td>
										<td rowspan="3" style="text-align: center; font-weight: bold;">Из графы 3 - руководитель юридического лица, обособленного подразделения</td>
									</tr>
									<tr>
										<td rowspan="2" style="text-align: center; font-weight: bold;">Служащие (сумма граф 3-5)</td>
										<td colspan="3" style="text-align: center; font-weight: bold;">Из них</td>
										<td rowspan="2" style="text-align: center; font-weight: bold;">Рабочие</td>
									</tr>
									<tr>
										<td style="text-align: center; font-weight: bold;">Руководитель</td>
										<td style="text-align: center; font-weight: bold;">Специалист</td>
										<td style="text-align: center; font-weight: bold;">Другие служащие</td>
									</tr>
								</thead>
									
								<tbody>
									<tr style="background: rgba(0,0,0,.1);">
										<td style="text-align: center;">А</td>
										<td style="text-align: center;">Б</td>
										<td style="text-align: center;">1</td>
										<td style="text-align: center;">2</td>
										<td style="text-align: center;">3</td>
										<td style="text-align: center;">4</td>
										<td style="text-align: center;">5</td>
										<td style="text-align: center;">6</td>
										<td style="text-align: center;">7</td>
										<td style="text-align: center;">8</td>
									</tr>
									
									<tr>
										<td style="text-align: left; border-bottom: 1px solid white;">Всего сумма строк (02-06 или 07-17)....</td>
										<td style="text-align: center; vertical-align: bottom;">01</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_01_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_01_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_01_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_01_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_01_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_01_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_01_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_01_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; border-bottom: 1px solid white;"><b>В том числе имеют образование:</b><br><span style="padding-left: 18px;">высшее....</span></td>
										<td style="text-align: center; vertical-align: bottom;">02</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_02_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_02_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_02_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_02_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_02_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_02_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_02_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_02_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">средне специальное....</td>
										<td style="text-align: center; vertical-align: bottom;">03</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_03_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_03_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_03_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_03_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_03_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_03_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_03_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_03_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">Профессионально техническое....</td>
										<td style="text-align: center; vertical-align: bottom;">04</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_04_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_04_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_04_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_04_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_04_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_04_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_04_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_04_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">Обще средние....</td>
										<td style="text-align: center; vertical-align: bottom;">05</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_05_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_05_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_05_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_05_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_05_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_05_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_05_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_05_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">Обще базовое....</td>
										<td style="text-align: center; vertical-align: bottom;">06</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_06_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_06_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_06_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_06_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_06_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_06_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_06_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_06_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; border-bottom: 1px solid white;"><b>Из строки 01 - имеют возраст, лет:</b><br><span style="padding-left: 18px;">до 16....</span></td>
										<td style="text-align: center; vertical-align: bottom;">07</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_07_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_07_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_07_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_07_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_07_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_07_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_07_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_07_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">16-17....</td>
										<td style="text-align: center; vertical-align: bottom;">08</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_08_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_08_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_08_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_08_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_08_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_08_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_08_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_08_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">18-24....</td>
										<td style="text-align: center; vertical-align: bottom;">09</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_09_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_09_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_09_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_09_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_09_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_09_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_09_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_09_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">25-29....</td>
										<td style="text-align: center; vertical-align: bottom;">10</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_10_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_10_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_10_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_10_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_10_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_10_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_10_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_10_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">30....</td>
										<td style="text-align: center; vertical-align: bottom;">11</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_11_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_11_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_11_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_11_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_11_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_11_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_11_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_11_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">31....</td>
										<td style="text-align: center; vertical-align: bottom;">12</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_12_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_12_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_12_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_12_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_12_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_12_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_12_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_12_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">32-39....</td>
										<td style="text-align: center; vertical-align: bottom;">13</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_13_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_13_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_13_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_13_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_13_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_13_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_13_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_13_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">40-49....</td>
										<td style="text-align: center; vertical-align: bottom;">14</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_14_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_14_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_14_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_14_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_14_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_14_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_14_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_14_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">50-54....</td>
										<td style="text-align: center; vertical-align: bottom;">15</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_15_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_15_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_15_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_15_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_15_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_15_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_15_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_15_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">55-59....</td>
										<td style="text-align: center; vertical-align: bottom;">16</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_16_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_16_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_16_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_16_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_16_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_16_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_16_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_16_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left; padding-left: 25px; border-bottom: 1px solid white;">60 лет и страрше....</td>
										<td style="text-align: center; vertical-align: bottom;">17</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_17_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_17_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_17_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_17_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_17_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_17_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_17_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_17_8"></td>
									</tr>
									
									<tr>
										<td style="text-align: left;">Из строки 01 - женщины....</td>
										<td style="text-align: center; vertical-align: bottom;">18</td>
										<td style="text-align: center; vertical-align: bottom;" name="str_18_1"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_18_2"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_18_3"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_18_4"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_18_5"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_18_6"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_18_7"></td>
										<td style="text-align: center; vertical-align: bottom;" name="str_18_8"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
				</div>
			</div>
		</div>

	</div>
	
	<!-- Модальные окна -->				
	<div id="modal-add-user" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
					<h4 class="modal-title">Добавление нового сотрудника</h4>
				</div>
				<form id="form-add-user" class="form-inline" method="post">
					<div class="modal-body">
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="user_f" placeholder="Фамилия"></div>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="user_i" placeholder="Имя"></div>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="user_o" placeholder="Отчество" required="required"></div>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="date" name="user_dob" placeholder="Дата рождения"></div>

						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="user_gender" data-placeholder="Выберите пол"></select>
						</div>

						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="user_education" data-placeholder="Выберите образование"></select>
						</div>
						
						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="user_subdivision" data-placeholder="Выберите подразделение"></select>
						</div>
						
						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="user_category" data-placeholder="Выберите категорию"></select>
						</div>
						
						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="user_function" data-placeholder="Выберите должность"></select>
						</div>
						
						<div class="form-group" style="width: 100%;"><input class="form-control" style="width: 100%;" type="date" name="user_receipt" placeholder="Дата приёма"></div>
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
	
	<!-- Редактирование информации о сотруднике -->
	<div id="modal-edit-user" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
					<h4 class="modal-title">Редактирование сотрудника</h4>
				</div>
				<form id="form-edit-user" class="form-inline" method="post">
					<div class="modal-body">
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="user_f" placeholder="Фамилия" value=""></div>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="user_i" placeholder="Имя" value=""></div>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="user_o" placeholder="Отчество" value=""></div>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="date" name="user_dob" placeholder="Дата рождения" value=""></div>
						
						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="user_gender" data-placeholder="Выберите пол"></select>
						</div>
						
						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="user_education" data-placeholder="Выберите образование"></select>
						</div>
						
						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="user_subdivision" data-placeholder="Выберите подразделение"></select>
						</div>
						
						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="user_category" data-placeholder="Выберите категорию"></select>
						</div>
						
						<div class="form-group" style="width: 100%; margin-bottom: 10px;">
							<select class="chosen-select" name="user_function" data-placeholder="Выберите должность"></select>
						</div>
						
						<div class="form-group" style="width: 100%;"><input class="form-control" style="width: 100%;" type="date" name="user_receipt" placeholder="Дата приёма" value=""></div>
						
						<input type="hidden" name="user_id" value="">
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
	
	<!-- Редактирование информации по контракту-->
	<div id="modal-edit-contract" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"><button class="close close-modal-edit-contract" type="button" data-dismiss="modal">×</button>
					<h4 class="modal-title">Редактирование информации о контракте</h4>
				</div>
				<form id="form-edit-contract" class="form-inline" method="post">
					<div class="modal-body">
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="user_f" placeholder="Фамилия" value=""></div>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="user_i" placeholder="Имя" value=""></div>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="user_o" placeholder="Отчество" value=""></div>
						
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="text" name="contract_num" placeholder="Номер контракта"></div>
						
						<label for="contract_date_begin" style="font-size: 85%;">Дата начала контракта:</label>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="date" name="contract_date_begin" placeholder="Дата начала контракта" value=""></div>
						<label for="contract_date_end" style="font-size: 85%;">Дата окончания контракта:</label>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="date" name="contract_date_end" placeholder="Дата окончания контракта" value=""></div>
						
						<label for="contract_extend_begin" style="font-size: 85%;">Контракт продлен (с какого):</label>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="date" name="contract_extend_begin" placeholder="Контракт продлен (с какого)" value=""></div>
						<label for="contract_extend_end" style="font-size: 85%;">Контракт продлен (по какое):</label>
						<div class="form-group" style="width: 100%; margin-bottom: 10px;"><input class="form-control" style="width: 100%;" type="date" name="contract_extend_end" placeholder="Контракт продлен (по какое)" value=""></div>
						
						<input type="hidden" name="user_id" value="">
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
	
	<!-- Вывод ФИО сотрудников, у которых оканчивается контракт-->
	<div id="modal-show-contract-expired" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"><button class="close close-modal-show-contract-expired" type="button" data-dismiss="modal">×</button>
					<h4 class="modal-title">Истечение срока действия контракта</h4>
				</div>
				<div class="modal-contracts-head" style="padding: 19px; font-weight: bold; font-size: 16px;">
					Внимание! У следующих сотрудников менее, чем через полтора месяца истекает срок контракта!
				</div>
				<div class="modal-text" style="padding: 19px; padding-top: 5px; line-height: 2;"></div>
				
				<div class="modal-footer">
					<div class="col-md-12">
						<button class="btn btn-primary" type="button" data-dismiss="modal">Закрыть</button>
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
	
	<script src="<?php echo $name_host; ?>/modules/personal/personal.js"></script>
</body>
</html>