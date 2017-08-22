<?php

session_start();
$success = ""; $error = ""; 

$fios = NULL;
$jobs = NULL;
$monthsYears = NULL;
$percents = NULL;

function ajax_response($success, $error){
	$arrMsg = array(
		"success" => $success, 
		"error" => $error
	);
	
	$arrMsgEncode = json_encode($arrMsg);
	return $arrMsgEncode;
}

function db_connect($query, $data, $view){
	$DB_HOST = 'localhost';
	$DB_NAME = 'bjp';
	$DB_USER = 'root';
	$DB_PASS = '';
	$DB_CHARSET = 'UTF8';

	$dsn = "mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME . ";charset=" . $DB_CHARSET;
	$db = new PDO($dsn, $DB_USER, $DB_PASS);
	
	$sth = $db->prepare($query);
	$rez = $sth->execute($data);
	
	switch( $view ){
		case 'select': $rez = $sth->fetchAll(PDO::FETCH_ASSOC); break;
		case 'create': $rez = $db->lastInsertId(); break;
		case 'insert': $rez = $db->lastInsertId(); break;	
		case 'update': ; break;
	}
		
	return $rez;
}

function select_input($data, $input_v = "", $html = '<option value="0"></option>'){
	if( !empty($data) ){
		foreach($data as $value){
			if( $input_v == $value['id'] ){
				$html .= '<option value="'.$value['id'].'" selected>'.$value['value'].'</option>';
			}
			else{ $html .= '<option value="'.$value['id'].'">'.$value['value'].'</option>'; }
		}
	}

	return $html;
}

function obj_list($data, $html = ""){
	$html .= '<table class="table table-hover table-bordered" style="width: 100%; margin-bottom: 0px;">
			<thead style="background: rgba(0,0,0,.3);">
				<th style="text-align: center; vertical-align: top;">Номер объекта</th>
				<th style="text-align: center; vertical-align: top;">Наименование объекта</th>
				<th style="text-align: center; vertical-align: top;">ГИП</th>
				<th style="text-align: center; vertical-align: top;">ГАП</th>
				<th style="text-align: center; vertical-align: top; width: 40px;"><span class="glyphicon glyphicon-search"></span></th>
				<th style="text-align: center; vertical-align: top; width: 40px;"><span class="glyphicon glyphicon-edit"></span></th>
			</thead><tbody>';
	
	foreach( $data["obj_info"] as $value ){
		$arrFioGIP = explode(" ", $value["gip"]);
		$arrFioGAP = explode(" ", $value["gap"]);
		
		$html .= '<tr class="obj-color obj-color-'.$value["id"].'">
			<td style="text-align: center; vertical-align: middle; width: 180px;">'.$value["v1_lv1"].'</td>
			<td style="text-align: left; vertical-align: middle;">'.$value["v2_lv1"].'</td>
			<td style="text-align: center; vertical-align: middle; width: 150px;">'.$arrFioGIP[0].' '. mb_substr($arrFioGIP[1],0,1,"UTF-8") . '. ' . mb_substr($arrFioGIP[2],0,1,"UTF-8") . '.</td>
			<td style="text-align: center; vertical-align: middle; width: 150px;">'.$arrFioGAP[0].' '. mb_substr($arrFioGAP[1],0,1,"UTF-8") . '. ' . mb_substr($arrFioGAP[2],0,1,"UTF-8") . '.</td>
			<td style="text-align: left; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default btn-view-obj" data-obj-id="'.$value["id"].'" data-subdivision-id="'.$value["subdivision_id"].'"><span class="glyphicon glyphicon-search"></span></button></td>
			<td style="text-align: left; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default btn-edit-obj" data-obj-id="'.$value["id"].'" data-subdivision-id="'.$value["subdivision_id"].'"><span class="glyphicon glyphicon-edit"></span></button></td>
		</tr>';
	}

	$html .= '</tbody></table>';
	
	return $html;
}

/*
function view_object($data, $html = ""){
	$monthArray = ["01" => "Январь", "02" => "Февраль", "03" => "Март", "04" => "Апрель", "05" => "Май", "06" => "Июнь", "07" => "Июль", "08" => "Август", "09" => "Сентябрь", "10" => "Октябрь", "11" => "Ноябрь", "12" => "Декабрь"];
	
	
	$html .= '<table class="table table-hover table-bordered" style="width: 100%;">';
	$name_input = ""; $value_input = "";
	
	foreach( $data["types_of_jobs"] as $value_jobs ){
		$vl_2 = $value_jobs["value_input"] == '0000-00-00'?"Пусто":date("d.m.Y", strtotime($value_jobs["value_input"]));
		
		$name_input .= '<td style="text-align: center; vertical-align: middle;">'.$value_jobs["name_input"].'</td>';
		$value_input .= '<td style="text-align: center; vertical-align: middle;">'.$vl_2.'</td>';
	}

	$html .= '<thead style="background: rgba(0,0,0,.3); font-weight: bold;">
			<tr>'.$name_input.'</tr>
		</thead>
		<tbody>
			<tr>'.$value_input.'</tr>
		</tbody>
	</table>';

	$count_user = count($data["exec_user_jobs"]);
	
	$j = 0;
	$i = 0;
	$flag = FALSE;
	$percentTotal = 0; //накопление процентов
	
	$void_html = "";
	$res_html = "";
	
	foreach( $data["exec_user_jobs"] as $value ){	
		
		$month = $monthArray[parsePercent($value["obj_id"], $value["id"], "month", 1)];
		$year = parsePercent($value["obj_id"], $value["id"], "year", 1);
		
		if (!$flag)
		{	
			$colspan = parsePercent($value["obj_id"], $value["id"], "count", 0) * 2;
			
			$html .= '<table class="table table-hover table-bordered" style="width: 100%; margin-bottom: 0px;">
			<thead style="background: rgba(0,0,0,.3); font-weight: bold;">
			<tr>
				<td style="text-align: center; vertical-align: middle;" colspan="2">Исполнители</td>
				<td style="text-align: center; vertical-align: middle;" colspan="'.$colspan.'">% выполнения по объекту</td>
			</tr>';
		
			$html .=	'<tr>
					<td style="text-align: center; vertical-align: middle;" colspan="2"></td>
					<td style="text-align: center; vertical-align: middle;" colspan="2">'.$month." ".$year." года".'</td>
				</tr>';
		
			$html .= '<tr>
					<td style="text-align: center; vertical-align: middle;">Фамилии</td>
					<td style="text-align: center; vertical-align: middle;">Выполняемая работа</td>
					<td style="text-align: center; vertical-align: middle;">% выполнения работ</td>
					<td style="text-align: center; vertical-align: middle;">% выполнения объекта</td>
				</tr>
			</thead><tbody>';
		}
		
		$flag = TRUE;
		
		$percentTotal += parsePercent($value["obj_id"], $value["id"], "percent", 1);
		
		if ($i == $count_user - 1) {
			$res_td = '<td style="text-align: center; vertical-align: middle;" rowspan="'.$count_user.'">'.round($percentTotal / $count_user).'</td>';
		}
		if ($i < $count_user - 1)
		{ $void_td = ""; }
		
		if (!empty($data["select_job_percent"][$i]["name_jobs"]))
			$current_user_job = $data["select_job_percent"][$i]["name_jobs"];
		else
			$current_user_job = "";
			
		$k = 1;	
			
		if ($i == $count_user - 1)
		{
			$res_html = '<tr>
			<td style="text-align: left; vertical-align: middle; width: 160px;">'.$value["user_f"].' ' . mb_substr($value["user_i"],0,1,"UTF-8") . '. ' . mb_substr($value["user_o"],0,1,"UTF-8").'.</td>
			<td style="text-align: center; vertical-align: middle;">'.$current_user_job.'</td>
			<td style="text-align: center; vertical-align: middle;">'.parsePercent($value["obj_id"], $value["id"], "percent", $k).'</td>
			'.$res_td.'
			</tr>';
		}
		else if ($i < $count_user - 1)
		{
			$void_html .= '<tr>
			<td style="text-align: left; vertical-align: middle; width: 160px;">'.$value["user_f"].' ' . mb_substr($value["user_i"],0,1,"UTF-8") . '. ' . mb_substr($value["user_o"],0,1,"UTF-8").'.</td>
			<td style="text-align: center; vertical-align: middle;">'.$current_user_job.'</td>
			<td style="text-align: center; vertical-align: middle;">'.parsePercent($value["obj_id"], $value["id"], "percent", $k).'</td>
			'.$void_td.'
			</tr>';
		}
		
		$j++;
		$i++;
	}
	
	$html .= $res_html.$void_html.'</tbody></table>';
	
	return $html;
}
*/

//-------------------------------------------------------------------------------------------------------------------------------

function view_object($data, $html = ""){
	$monthArray = ["01" => "Январь", "02" => "Февраль", "03" => "Март", "04" => "Апрель", "05" => "Май", "06" => "Июнь", "07" => "Июль", "08" => "Август", "09" => "Сентябрь", "10" => "Октябрь", "11" => "Ноябрь", "12" => "Декабрь"];
	$percentTotal = NULL; //для подсчета процентов
	
	$html .= '<table class="table table-hover table-bordered" style="width: 100%;">';
	$name_input = ""; $value_input = "";
	
	foreach( $data["types_of_jobs"] as $value_jobs ){
		$vl_2 = $value_jobs["value_input"] == '0000-00-00'?"Пусто":date("d.m.Y", strtotime($value_jobs["value_input"]));
		
		$name_input .= '<td style="text-align: center; vertical-align: middle;">'.$value_jobs["name_input"].'</td>';
		$value_input .= '<td style="text-align: center; vertical-align: middle;">'.$vl_2.'</td>';
	}

	$html .= '<thead style="background: rgba(0,0,0,.3); font-weight: bold;">
			<tr>'.$name_input.'</tr>
		</thead>
		<tbody>
			<tr>'.$value_input.'</tr>
		</tbody>
	</table>';

	$count_user = count($data["exec_user_jobs"]);
	$i = 0;
	
	//заполнение массива с ФИО vrcent($value["obj_id"], $value["id"], "count", 0);
		
	foreach( $data["exec_user_jobs"] as $value )
	{	
		$fios[] = $value["user_f"]." ".mb_substr($value["user_i"],0,1,"UTF-8"). '. '.mb_substr($value["user_o"],0,1,"UTF-8");
		
		if (!empty($data["select_job_percent"][$i]["name_jobs"]))
			$jobs[] = $data["select_job_percent"][$i]["name_jobs"];
		else
			$jobs[] = "";
		
		$count_months = parsePercent($value["obj_id"], $value["id"], "count", 0);
		
		$i++;
	}
	
	if ($count_months > 1)
	{
		for ($i = 0; $i < $count_months; $i++)
		{	
			$percentTotal[$i] = 0;
	
			$flag= FALSE;
			foreach ($data["exec_user_jobs"] as $value)
			{
					$percent[$i][] = parsePercent($value["obj_id"], $value["id"], "percent", $i);
					$percentTotal[$i] = $percentTotal[$i] + parsePercent($value["obj_id"], $value["id"], "percent", $i);
					
					if (!$flag)
					{
						$monthYear[] = $monthArray[parsePercent($value["obj_id"], $value["id"], "month", $i)]." ".parsePercent($value["obj_id"], $value["id"], "year", $i);
						$flag = TRUE;
					}
			}
		}
	}
	else if ($count_months == 1)
	{
		$flag = FALSE;
		foreach ($data["exec_user_jobs"] as $value)
		{
			$percent[] = parsePercent($value["obj_id"], $value["id"], "percent", 0);
			$percentTotal = $percentTotal + parsePercent($value["obj_id"], $value["id"], "percent", 0);
			
			if (!$flag)
			{
				$monthYear[] = $monthArray[parsePercent($value["obj_id"], $value["id"], "month", 0)]." ".parsePercent($value["obj_id"], $value["id"], "year", 0);
				$flag = TRUE;
			}
		}
	}
	
	//-------------------------------------------------
	//Вывод html
	
	//Вывод шапки таблицы
	
	$colspan = $count_months * 2;
	
	$html .= '<table class="table table-hover table-bordered" style="width: 100%; margin-bottom: 0px;">
	<thead style="background: rgba(0,0,0,.3); font-weight: bold;">
	<tr>
		<td style="text-align: center; vertical-align: middle;" colspan="2">Исполнители</td>
		<td style="text-align: center; vertical-align: middle;" colspan="'.$colspan.'">% выполнения по объекту</td>
	</tr>';
	
	$html .= '<tr>';
	
	$flag = FALSE;
	
	for ($i = 0; $i < $count_months; $i++)
	{
		if (!$flag)
		{
			$html .= '<td style="text-align: center; vertical-align: middle;" colspan="2"></td>';
			$flag = TRUE;
		}
		
		$html .= '<td style="text-align: center; vertical-align: middle;" colspan="2">'.array_shift($monthYear).'</td>';
	}
	
	$html .= '</tr>';
	
	$html .= '<tr>
					<td style="text-align: center; vertical-align: middle;">Фамилии</td>
					<td style="text-align: center; vertical-align: middle;">Выполняемая работа</td>';

	for ($i = 0; $i < $count_months; $i++)
		$html .= '<td style="text-align: center; vertical-align: middle;">% выполнения работ</td>
					<td style="text-align: center; vertical-align: middle;">% выполнения объекта</td>';
					
	$html .= '</tr></thead><tbody>';				
					
	//Вывод содержимого таблицы
	
	
	$k = 0;
	$totalPercentFlag = FALSE;
	
	for ($i = 0; $i < $count_user; $i++)
	{
		$html .= '<tr>';
		
		$percentFlag = FALSE;
		$flag = FALSE;
		foreach($percent as $key => $value)
		{
			if (!$flag)
			{
				$html .= '<td style="text-align: left; vertical-align: middle; width: 160px;">'.array_pop($fios).'.</td>
						<td style="text-align: center; vertical-align: middle;">'.array_pop($jobs).'</td>';
				$flag = TRUE;
			}	
			
			if ($count_months > 1)
				$html .= '<td style="text-align: center; vertical-align: middle;">'.array_pop($percent[$key]).'</td>';
			else if (($count_months == 1) && (!$percentFlag))
			{
				$html .= '<td style="text-align: center; vertical-align: middle;">'.array_pop($percent).'</td>';
				$percentFlag = TRUE;
			}
			
			if (($i == 0) && ($count_months > 1))
			{
				$html .= '<td style="text-align: center; vertical-align: middle;" rowspan="'.$count_user.'">'.round($percentTotal[$k] / $count_user).'</td>'; 
				$k++;
			}
			else if (($i == 0) && ($count_months == 1) && (!$totalPercentFlag))
			{
				$html .= '<td style="text-align: center; vertical-align: middle;" rowspan="'.$count_user.'">'.round($percentTotal / $count_user).'</td>'; 
				$totalPercentFlag = TRUE;
			}
		}
	
		$html .= '</tr>';
	}			
					
	$html .= '</tbody></table>';
	
	
	return $html;
}

//---------------------------------------------------------------------------------------------------------------------------
/*
function edit_object($data, $html = ""){
	$html .= '<table class="table table-hover table-bordered" style="width: 100%;">';
	$name_input = ""; $value_input = "";
	foreach( $data["types_of_jobs"] as $value_jobs ){
		$vl_2 = $value_jobs["value_input"] == '0000-00-00'?"Пусто":date("d.m.Y", strtotime($value_jobs["value_input"]));
		
		$name_input .= '<td style="text-align: center; vertical-align: middle;">'.$value_jobs["name_input"].'</td>';
		$value_input .= '<td style="text-align: center; vertical-align: middle;">'.$vl_2.'</td>';
	}
	$html .= '<thead style="background: rgba(0,0,0,.3); font-weight: bold;">
			<tr>'.$name_input.'</tr>
		</thead>
		<tbody>
			<tr>'.$value_input.'</tr>
		</tbody>
	</table>';

	$html .= '<table class="table table-hover table-bordered" style="width: 100%; margin-bottom: 0px;">
	<thead style="background: rgba(0,0,0,.3); font-weight: bold;">
		<tr>
			<td style="text-align: center; vertical-align: middle;" colspan="2">Исполнители</td>
			<td style="text-align: center; vertical-align: middle;" colspan="2">% выполнения по объекту</td>
		</tr>
		<tr>
			<td style="text-align: center; vertical-align: middle;">Фамилии</td>
			<td style="text-align: center; vertical-align: middle;">Выполняемая работа</td>
			<td style="text-align: center; vertical-align: middle;">% выполнения работ</td>
			<td style="text-align: center; vertical-align: middle;">% выполнения объекта</td>
		</tr>
	</thead><tbody>';
	
	$count_user = count($data["exec_user_jobs"]); $j = 1;
	$i = 0;
	foreach( $data["exec_user_jobs"] as $value ){
		if ( $j == 1 ) {
			$last_td = '<td style="text-align: center; vertical-align: middle;" rowspan="'.$count_user.'"></td>';
		}
		else{ $last_td = ""; }
		
		if (!empty($data["select_job_percent"][$i]["name_jobs"]))
			$current_user_job = $data["select_job_percent"][$i]["name_jobs"];
		else
			$current_user_job = "";
		
		if (!empty($data["select_job_percent"][$i]["percent_jobs"]))
			$current_user_percent = $data["select_job_percent"][$i]["percent_jobs"];
		else
			$current_user_percent = 0;
			
		$html .= '<tr>
			<td style="text-align: left; vertical-align: middle; width: 160px;">'.$value["user_f"].' ' . mb_substr($value["user_i"],0,1,"UTF-8") . '. ' . mb_substr($value["user_o"],0,1,"UTF-8").'.</td>
			<td style="text-align: center; vertical-align: middle;">
				<table style="width: 100%;">
					<tr>
						<td><input class="form-control" id="input-add-name-jobs-'.$value["id"].'" style="width: 100%;" type="text" name="name_jobs" placeholder="Название работы" value="'.$current_user_job.'"></td>
						<td><button class="btn btn-default btn-add-name-jobs" data-user-id="'.$value["id"].'" data-obj-id="'.$value["obj_id"].'" style="" data-id="" data-toggle="modal" data-target="#modal-add-name-jobs-result"><span class="glyphicon glyphicon-edit"></span></button></td>
					</tr>
				</table>
			</td>
			<td style="text-align: center; vertical-align: middle;">
				<table style="width: 100%;">
					<tr>
						<td><input class="form-control" id="input-add-percent-'.$value["id"].'" style="width: 100%;" type="text" name="name_jobs" placeholder="% выполнения работы" value="'.$current_user_percent.'"></td>
						<td><button class="btn btn-default btn-add-percent" data-user-id="'.$value["id"].'" data-obj-id="'.$value["obj_id"].'" data-toggle="modal" data-target="#modal-add-percent-result"><span class="glyphicon glyphicon-edit"></span></button></td>
					</tr>
				</table>
			</td>
			'.$last_td.'
		</tr>';
		
		$j++;
		$i++;
	}
	
	$html .= '</tbody></table>';
	
	return $html;
}
*/

//-------------------------------------------------------------------------------------------------

function edit_object($data, $html = "")
{	
	$monthArray = ["01" => "Январь", "02" => "Февраль", "03" => "Март", "04" => "Апрель", "05" => "Май", "06" => "Июнь", "07" => "Июль", "08" => "Август", "09" => "Сентябрь", "10" => "Октябрь", "11" => "Ноябрь", "12" => "Декабрь"];
	$percentTotal = NULL; //для подсчета процентов
	
	$html .= '<table class="table table-hover table-bordered" style="width: 100%;">';
	$name_input = ""; 
	$value_input = "";
	
	foreach( $data["types_of_jobs"] as $value_jobs ){
		$vl_2 = $value_jobs["value_input"] == '0000-00-00'?"Пусто":date("d.m.Y", strtotime($value_jobs["value_input"]));
		
		$name_input .= '<td style="text-align: center; vertical-align: middle;">'.$value_jobs["name_input"].'</td>';
		$value_input .= '<td style="text-align: center; vertical-align: middle;">'.$vl_2.'</td>';
	}

	$html .= '<thead style="background: rgba(0,0,0,.3); font-weight: bold;">
			<tr>'.$name_input.'</tr>
		</thead>
		<tbody>
			<tr>'.$value_input.'</tr>
		</tbody>
	</table>';

	$count_user = count($data["exec_user_jobs"]);
	$i = 0;
	
	//заполнение массива с ФИО и работами
	foreach( $data["exec_user_jobs"] as $value )
	{	
		$fios[] = $value["user_f"]." ".mb_substr($value["user_i"],0,1,"UTF-8"). '. '.mb_substr($value["user_o"],0,1,"UTF-8");
		
		if (!empty($data["select_job_percent"][$i]["name_jobs"]))
			$jobs[] = $data["select_job_percent"][$i]["name_jobs"];
		else
			$jobs[] = "";
		
		$count_months = parsePercent($value["obj_id"], $value["id"], "count", 0);
		$last_month = parsePercent($value["obj_id"], $value["id"], "month", $count_months-1);
		
		$i++;
	}
	
	if ($last_month != date("m"))
	{
		$count_months++;
		
		foreach($data["exec_user_jobs"] as $value)
		{	
			$string_buf = "";
		
				$select_result = db_connect("SELECT `percent_jobs` FROM `users_percent` WHERE `obj_id`=:idObj AND `user_id`=:idUser", [":idObj" => $value["obj_id"], ":idUser" => $value["id"]], "select");
				
				for ($l = 0; $l < $count_months; $l++)
				{
					if ($l < ($count_months-1))
					{				
						$percent_buf = parsePercent($value["obj_id"], $value["id"], "percent", $l);
						$month_buf = parsePercent($value["obj_id"], $value["id"], "month", $l);
						$year_buf = parsePercent($value["obj_id"], $value["id"], "year", $l);
						
						$string_buf .= $month_buf.".".$year_buf."-".$percent_buf.";";
					}
					if ($l == $count_months-1)
					{
						$percent_buf = parsePercent($value["obj_id"], $value["id"], "percent", $l-1);
						$month_buf = date("m");
						$year_buf = date("Y");
						
						$string_buf .= $month_buf.".".$year_buf."-".$percent_buf.";";
					}
			
				}
			db_connect("UPDATE `users_percent` SET `percent_jobs`=:percent WHERE `obj_id`=:idObj AND `user_id`=:idUser", [":percent" => $string_buf, ":idObj" => $value["obj_id"], ":idUser" => $value["id"]], "update");
			
		}
	}

	$id_rab = array();
	$id_obj = array();
	
	if ($count_months > 1)
	{
		for ($i = 0; $i < $count_months; $i++)
		{	
			$percentTotal[$i] = 0;
	
			$flag = FALSE;
			foreach ($data["exec_user_jobs"] as $value)
			{
					$percent[$i][] = parsePercent($value["obj_id"], $value["id"], "percent", $i);
					$percentTotal[$i] = $percentTotal[$i] + parsePercent($value["obj_id"], $value["id"], "percent", $i);
					
					if ($i == 0)
					{
						array_push($id_rab, $value["id"]);
						array_push($id_obj, $value["obj_id"]);
					}
					
					if (!$flag)
					{
						$monthYear[] = $monthArray[parsePercent($value["obj_id"], $value["id"], "month", $i)]." ".parsePercent($value["obj_id"], $value["id"], "year", $i);
						$flag = TRUE;
					}
			}
		}
	}
	else if ($count_months == 1)
	{
		$flag = FALSE;
		foreach ($data["exec_user_jobs"] as $value)
		{
			$percent[] = parsePercent($value["obj_id"], $value["id"], "percent", 0);
			$percentTotal = $percentTotal + parsePercent($value["obj_id"], $value["id"], "percent", 0);
			
			array_push($id_rab, $value["id"]);
			array_push($id_obj, $value["obj_id"]);
			
			if (!$flag)
			{
				$monthYear[] = $monthArray[parsePercent($value["obj_id"], $value["id"], "month", 0)]." ".parsePercent($value["obj_id"], $value["id"], "year", 0);
				$flag = TRUE;
			}
		}
	}
	
	//-------------------------------------------------
	//Вывод html
	
	//Вывод шапки таблицы
	
	$colspan = $count_months * 2;
	
	$html .= '<form id="form-add-jobs-percent" class="form-inline" method="post">';
	
	$html .= '<table class="table table-hover table-bordered" style="width: 100%; margin-bottom: 0px;">
	<thead style="background: rgba(0,0,0,.3); font-weight: bold;">
	<tr>
		<td style="text-align: center; vertical-align: middle;" colspan="2">Исполнители</td>
		<td style="text-align: center; vertical-align: middle;" colspan="'.$colspan.'">% выполнения по объекту</td>
	</tr>';
	
	$html .= '<tr>';
	
	$flag = FALSE;
	
	for ($i = 0; $i < $count_months; $i++)
	{
		if (!$flag)
		{
			$html .= '<td style="text-align: center; vertical-align: middle;" colspan="2"></td>';
			$flag = TRUE;
		}
		
		$html .= '<td style="text-align: center; vertical-align: middle;" colspan="2">'.array_shift($monthYear).'</td>';
	}
	
	$html .= '</tr>';
	
	$html .= '<tr>
					<td style="text-align: center; vertical-align: middle;">Фамилии</td>
					<td style="text-align: center; vertical-align: middle;">Выполняемая работа</td>';

	for ($i = 0; $i < $count_months; $i++)
		$html .= '<td style="text-align: center; vertical-align: middle;">% выполнения работ</td>
					<td style="text-align: center; vertical-align: middle;">% выполнения объекта</td>';
					
	$html .= '</tr></thead><tbody>';				
					
	//Вывод содержимого таблицы
	
	$m = 1; //для использования в именах инпутов
	$totalPercentFlag = FALSE;
	
	for ($i = 0; $i < $count_user; $i++)
	{
		$k = 0;
		$percentFlag = FALSE;
		$html .= '<tr>';
		
		$id_rab_tmp = array_pop($id_rab);
		$id_obj_tmp = array_pop($id_obj);
		
		$flag = FALSE;
		foreach($percent as $key => $value)
		{
			
			if (!$flag)
			{	
				$html .= '<td style="text-align: left; vertical-align: middle; width: 160px;">'.array_pop($fios).'.</td>
						<td style="text-align: center; vertical-align: middle;">
							<table style="width: 100%;">
								<tr>
									<td><input class="form-control" data-user-id="'.$id_rab_tmp.'" data-obj-id="'.$id_obj_tmp.'" id="add-name-jobs-'.$id_rab_tmp.'" style="width: 100%;" type="text" name="name_jobs_'.$m.'" placeholder="Название работы" value="'.array_pop($jobs).'">
									<input style="display: none;" name="hidden_name_jobs_percent_'.$m.'" value="'.$id_rab_tmp.'">
									</td>
							<!--		<td><button class="btn btn-default btn-add-name-jobs" data-user-id="'.$id_rab_tmp.'" data-obj-id="'.$id_obj_tmp.'" style="" data-id="" data-toggle="modal" data-target="#modal-add-name-jobs-result"><span class="glyphicon glyphicon-edit"></span></button></td> -->
								</tr>
							</table>
						</td>';
				$flag = TRUE;  
			}	
			
			if ($count_months > 1)
			{
				
				if ($k == count($percent)-1)
				{
					$html .= '<td style="text-align: center; vertical-align: middle;">
					<table style="width: 100%;">
						<tr>
							<td><input class="form-control" data-user-id="'.$id_rab_tmp.'" data-obj-id="'.$id_obj_tmp.'" id="add-percent-'.$id_rab_tmp.'" style="width: 100%;" type="text" name="name_percent_'.$m.'" placeholder="% выполнения работы" value="'.array_pop($percent[$key]).'">
							</td>
						<!--	<td><button class="btn btn-default btn-add-percent" data-user-id="'.$id_rab_tmp.'" data-obj-id="'.$id_obj_tmp.'" data-toggle="modal" data-target="#modal-add-percent-result"><span class="glyphicon glyphicon-edit"></span></button></td> -->
						</tr>
					</table>
					</td>';
				}
				else
					$html .= '<td style="text-align: center; vertical-align: middle;">'.array_pop($percent[$key]).'</td>';
			}		
			if (($count_months == 1) && (!$percentFlag))
			{
				$html .= '<td style="text-align: center; vertical-align: middle;">
				<table style="width: 100%;">
					<tr>
						<td><input class="form-control" data-user-id="'.$id_rab_tmp.'" data-obj-id="'.$id_obj_tmp.'" id="add-percent-'.$id_rab_tmp.'" style="width: 100%;" type="text" name="name_percent_'.$m.'" placeholder="% выполнения работы" value="'.array_pop($percent).'">
						</td>
					<!--	<td><button class="btn btn-default btn-add-percent" data-user-id="'.$id_rab_tmp.'" data-obj-id="'.$id_obj_tmp.'" data-toggle="modal" data-target="#modal-add-percent-result"><span class="glyphicon glyphicon-edit"></span></button></td> -->
					</tr>
				</table>
				</td>';
				$percentFlag = TRUE;
			} 

			if (($i == 0) && ($count_months > 1))
			{
				$html .= '<td style="text-align: center; vertical-align: middle;" rowspan="'.$count_user.'">'.round($percentTotal[$k] / $count_user).'</td>'; 
			}
			else if (($i == 0) && ($count_months == 1) && (!$totalPercentFlag))
			{
				$html .= '<td style="text-align: center; vertical-align: middle;" rowspan="'.$count_user.'">'.round($percentTotal / $count_user).'</td>'; 
				$totalPercentFlag = TRUE;
			} 
			$k++;
		}
	
		$html .= '</tr>';
		$m++;
	}								
		
	$html .= '</tbody></table>
	<input style="display: none;" name="hidden_obj_id" value="'.$id_obj_tmp.'">
	<input style="display: none;" name="hidden_count" value="'.$count_user.'">
	<button class="btn btn-primary" type="submit">Сохранить</button>
	</form>';
	
	return $html;
}


function saveUserPercent($percent) {
	$userPercent = date("m").".".date("Y")."-".$percent.";";
	
	return $userPercent;
	
}

function parsePercent($idObj, $idUser, $toReturn, $key) {
	$percentRow = db_connect("SELECT * FROM `users_percent` WHERE `obj_id`=:obj_id AND `user_id`=:user_id LIMIT 1", [":obj_id" => $idObj, ":user_id" => $idUser], "select");
	
	$allPercentsUsers = explode(";", $percentRow[0]["percent_jobs"]);

	$percent = array();
	$month = array();
	$year = array();
	
	for ($i = 0; $i < count($allPercentsUsers); $i++)
	{
		if (!empty($allPercentsUsers[$i]))
		{
			$datePercent = explode("-", $allPercentsUsers[$i]);
			array_push($percent, $datePercent[1]);

			$monthYear = explode(".", $datePercent[0]);
			array_push($month, $monthYear[0]);
			array_push($year, $monthYear[1]);
		}
	}	
	
	switch ($toReturn)
	{
		case "month": return $month[$key];
		case "year": return $year[$key];
		case "percent": return $percent[$key];
		case "count": return count($percent);
	}
}


switch( $_POST['action'] ){
	case 'start_load':
		$success["subdivision_list"] = select_input(db_connect("SELECT `id`, `subdivision_name` AS value FROM `hdbk_user_subdivision` WHERE `part_in_design` = :part_in_design", [":part_in_design" => 1], "select"));
		//saveUserPercent("1", "1", "2", "55");
		//$success["percent"] = parsePercent("1", "1");
		echo ajax_response($success, $error);
	break;
	
	case 'obj_list':
		$subdivision_id = $_POST["data"];
		$data["obj_info"] = db_connect("SELECT t1.`subdivision_id`, t2.`id`, t2.`v1_lv1`, t2.`v2_lv1`, t3.`fio` as gip, t4.`fio` as gap FROM `obj_types_of_jobs` as t1 LEFT JOIN `obj_info` as t2 ON t1.`obj_id` = t2.`id` LEFT JOIN `users_data` as t3 ON t2.`v4_1_lv1` = t3.`id` LEFT JOIN `users_data` as t4 ON t2.`v4_2_lv1` = t4.`id` WHERE t1.`subdivision_id` = :subdivision_id AND t2.`id` IS NOT NULL GROUP BY t1.`obj_id`", [":subdivision_id" => $subdivision_id], "select");

		$success["obj_list"] = obj_list($data);

		echo ajax_response($success, $error);
	break;
	
	case 'btn_view_obj':
		$obj_id = $_POST['data']['obj_id'];
		$subdivision_id = $_POST['data']["subdivision_id"];

		$data["types_of_jobs"] = db_connect("SELECT `name_input`, `value_input` FROM `obj_types_of_jobs` WHERE `obj_id` = :obj_id AND `subdivision_id` = :subdivision_id", [":subdivision_id" => $subdivision_id, ":obj_id" => $obj_id], "select");
		$data["exec_user_jobs"] = db_connect("SELECT t1.`user_f`, `user_o`, `user_i`, t2.`obj_id`, t1.`id` FROM `users_data` as t1 LEFT JOIN `obj_types_of_jobs` as t2 ON t1.`user_subdivision` = t2.`subdivision_id` WHERE t2.`obj_id` = :obj_id AND t2.`subdivision_id` = :subdivision_id GROUP BY t1.`id`", [":subdivision_id" => $subdivision_id, ":obj_id" => $obj_id], "select");
		
		$data["select_job_percent"] = db_connect("SELECT `id`, `user_id`, `name_jobs`, `percent_jobs` FROM `users_percent` WHERE `subdivision_id`=:subdivision_id GROUP BY `user_id`", [":subdivision_id" => $subdivision_id], "select");
		
		$success["user_subdivision"] = view_object($data);
		
		echo ajax_response($success, $error);
	break;
	
	case 'btn_edit_obj':
		$obj_id = $_POST['data']['obj_id'];
		$subdivision_id = $_POST['data']["subdivision_id"];

		$data["types_of_jobs"] = db_connect("SELECT `name_input`, `value_input` FROM `obj_types_of_jobs` WHERE `obj_id` = :obj_id AND `subdivision_id` = :subdivision_id", [":subdivision_id" => $subdivision_id, ":obj_id" => $obj_id], "select");
		$data["exec_user_jobs"] = db_connect("SELECT t1.`user_f`, `user_o`, `user_i`, t2.`obj_id`, t1.`id` FROM `users_data` as t1 LEFT JOIN `obj_types_of_jobs` as t2 ON t1.`user_subdivision` = t2.`subdivision_id` WHERE t2.`obj_id` = :obj_id AND t2.`subdivision_id` = :subdivision_id GROUP BY t1.`id`", [":subdivision_id" => $subdivision_id, ":obj_id" => $obj_id], "select");
		
		$data["select_job_percent"] = db_connect("SELECT `id`, `user_id`, `name_jobs`, `percent_jobs` FROM `users_percent` WHERE `subdivision_id`=:subdivision_id GROUP BY `user_id`", [":subdivision_id" => $subdivision_id], "select");
		
		$success["user_subdivision"] = edit_object($data);
		
		echo ajax_response($success, $error);
	break;
	
	case 'add_name_jobs':
		$user_id = $_POST['data']['user_id'];
		$obj_id = $_POST['data']['obj_id'];
		$name_job = $_POST['data']['name_job'];
		
		$select_result = db_connect("SELECT * FROM `users_percent` WHERE `obj_id`=:idObj AND `user_id`=:idUser LIMIT 1", [":idObj" => $obj_id, ":idUser" => $user_id], "select");
		
		if (isset($select_result[0]["user_id"]))
			db_connect("UPDATE `users_percent` SET `name_jobs`=:nameJob WHERE `user_id`=:idUser AND `obj_id`=:idObj", [":nameJob" => $name_job, "idObj" => $obj_id, ":idUser" => $user_id], "update");
		else
			db_connect("INSERT INTO `users_percent` (`obj_id`, `user_id`, `name_jobs`) VALUES (:idObj, :idUser, :nameJob)", [":idObj" => $obj_id, ":idUser" => $user_id, ":nameJob" => $name_job], "insert");
	break;

	case 'add_percent':
		$user_id = $_POST['data']['user_id'];
		$obj_id = $_POST['data']['obj_id'];
		$percent = $_POST['data']['percent'];
		
		$string_buf = "";
		
		$select_result = db_connect("SELECT `percent_jobs` FROM `users_percent` WHERE `obj_id`=:idObj AND `user_id`=:idUser", ["idObj" => $obj_id, ":idUser" => $user_id], "select");
		
		if (isset($select_result[0]["percent_jobs"]))
		{
			for ($l = 0; $l < parsePercent($obj_id, $user_id, "count", 0); $l++)
			{
				if ($l < parsePercent($obj_id, $user_id, "count", 0) - 1)
				{				
					$percent_buf = parsePercent($obj_id, $user_id, "percent", $l);
					$month_buf = parsePercent($obj_id, $user_id, "month", $l);
					$year_buf = parsePercent($obj_id, $user_id, "year", $l);
					
					$string_buf .= $month_buf.".".$year_buf."-".$percent_buf.";";
				}
				else if ($l == parsePercent($obj_id, $user_id, "count", 0) - 1)
				{
					$percent_buf = $percent;
					$month_buf = parsePercent($obj_id, $user_id, "month", $l);
					$year_buf = parsePercent($obj_id, $user_id, "year", $l);
					
					$string_buf .= $month_buf.".".$year_buf."-".$percent_buf.";";
				}
				
			}
			
			//$percent_temp = saveUserPercent($percent);
			//$percent_new = $select_result[0]["percent_jobs"].$percent_temp;
		
			db_connect("UPDATE `users_percent` SET `percent_jobs`=:percent WHERE `obj_id`=:idObj AND `user_id`=:idUser", [":percent" => $string_buf, ":idObj" => $obj_id, ":idUser" => $user_id], "update");
		}
		else
		{
			$percent_new = saveUserPercent($percent);
			db_connect("INSERT INTO `users_percent` (`obj_id`, `user_id`, `percent_jobs`) VALUES (:idObj, :idUser, :percent)", [":percent" => $percent_new, ":idObj" => $obj_id, ":idUser" => $user_id], "insert");
			
		}
	break;
	
	case 'add_jobs_percent':
	
		parse_str($_POST['data'], $form_ser);
		
		$obj_id = $form_ser['hidden_obj_id'];
		
		//записываем работы
		
		for ($i = 1; $i <= $form_ser['hidden_count']; $i++)
		{
			$user_id = $form_ser['hidden_name_jobs_percent_'.$i];
			$percent = $form_ser['name_percent_'.$i];
			$job = $form_ser['name_jobs_'.$i];
			
			//записываем проценты в базу
			$string_buf = "";
		
			$select_result = db_connect("SELECT `percent_jobs` FROM `users_percent` WHERE `obj_id`=:idObj AND `user_id`=:idUser", [":idObj" => $obj_id, ":idUser" => $user_id], "select");
			
			if (isset($select_result[0]["percent_jobs"]))
			{
				for ($l = 0; $l < parsePercent($obj_id, $user_id, "count", 0); $l++)
				{
					if ($l < parsePercent($obj_id, $user_id, "count", 0) - 1)
					{				
						$percent_buf = parsePercent($obj_id, $user_id, "percent", $l);
						$month_buf = parsePercent($obj_id, $user_id, "month", $l);
						$year_buf = parsePercent($obj_id, $user_id, "year", $l);
						
						$string_buf .= $month_buf.".".$year_buf."-".$percent_buf.";";
					}
					else if ($l == parsePercent($obj_id, $user_id, "count", 0) - 1)
					{
						$percent_buf = $percent;
						$month_buf = parsePercent($obj_id, $user_id, "month", $l);
						$year_buf = parsePercent($obj_id, $user_id, "year", $l);
						
						$string_buf .= $month_buf.".".$year_buf."-".$percent_buf.";";
					}
					
				}
			
				db_connect("UPDATE `users_percent` SET `percent_jobs`=:percent WHERE `obj_id`=:idObj AND `user_id`=:idUser", [":percent" => $string_buf, ":idObj" => $obj_id, ":idUser" => $user_id], "update");
			}
			else
			{
				$percent_new = saveUserPercent($percent);
				db_connect("INSERT INTO `users_percent` (`obj_id`, `user_id`, `percent_jobs`) VALUES (:idObj, :idUser, :percent)", [":percent" => $percent_new, ":idObj" => $obj_id, ":idUser" => $user_id], "insert");
				
			}
			
			//записываем имя работы в базу
			
			$select_result = db_connect("SELECT * FROM `users_percent` WHERE `obj_id`=:idObj AND `user_id`=:idUser LIMIT 1", [":idObj" => $obj_id, ":idUser" => $user_id], "select");
		
			if (isset($select_result[0]["percent_jobs"]))
				db_connect("UPDATE `users_percent` SET `name_jobs`=:nameJob WHERE `user_id`=:idUser AND `obj_id`=:idObj", [":nameJob" => $job, "idObj" => $obj_id, ":idUser" => $user_id], "update");
			else
				db_connect("INSERT INTO `users_percent` (`obj_id`, `user_id`, `name_jobs`) VALUES (:idObj, :idUser, :nameJob)", [":idObj" => $obj_id, ":idUser" => $user_id, ":nameJob" => $job], "insert");
		}
		
	break;
	
	case "view_chart":
		$obj_id = $_POST['object_id'];
		
		//Плановые даты для текущего объекта
	
		$select_result_dates_plan = db_connect("SELECT `v8_lv1`, `v10_lv1`, `v12_lv1`, `v14_lv1`, `v16_lv1`, `v18_lv1`, `v20_lv1`, `v22_lv1`
									FROM `obj_info` WHERE `id`=:objId LIMIT 1", [":objId" => $obj_id], "select");
									
		//Фактические даты для текущего объекта
									
		$select_result_dates_fact = db_connect("SELECT `v9_lv1`, `v11_lv1`, `v13_lv1`, `v15_lv1`, `v17_lv1`, `v19_lv1`, `v21_lv1`, `v23_lv1`
									FROM `obj_info` WHERE `id`=:objId LIMIT 1", [":objId" => $obj_id], "select");
									
		//Парсинг дат по году, месяцу и дню
		
		foreach ($select_result_dates_plan[0] as $key => $value)
			$dates_plan[] = explode("-", $select_result_dates_plan[0][$key]);
			
		foreach ($select_result_dates_fact[0] as $key => $value)
			$dates_fact[] = explode("-", $select_result_dates_fact[0][$key]);
		
		$success["dates_plan"] = $dates_plan;
		$success["dates_fact"] = $dates_fact;
		$success["stages"] = ["Разработка пакета договорных документов (начало)", "Разработка пакета договорных документов (окончание)", "Подписание пакета договорных документов (начало)", 
		"Подписание пакета договорных документов (окончание)", "Составление исполнительной сметы на ПИР", "Составление допсоглашения к договору",
		"Передача 1 экз. ПСД Заказчику на согласование", "Составление акта приемки-сдачи накладной"];
	
		//$error = "";
		//ajax_response($success, $error);
		echo json_encode($success);
	break;
}

?>