<?php
session_start();

include_once "orders.db.php";
$orders = new orders();
$success = ""; $error = ""; 


function ajax_response($success, $error){

		$arrMsg = array(
			"success" => $success, 
			"error" => $error
		);
	
	$arrMsgEncode = json_encode($arrMsg);
	return $arrMsgEncode;
}

//Вывод всех сотрудников
function show_order($data, $html = "", $subdivision_id = ""){
	
	foreach($data as $value){
	
		if ($value["exec_mark"] == "1")
		
			$exec_mark_output = "<span class=\"glyphicon glyphicon-ok\"></span>";
		else
			$exec_mark_output = "";
		
		$income_date = date("d.m.Y", strtotime($value["income_date"]));
		$exec_date = date("d.m.Y", strtotime($value["exec_date"]));
		
		$dir = "uploads/doc/";
		$linkPor = "Файл не найден";
		$flag = FALSE;
		
		$dh = opendir($dir);
		while (false != ($filename = readdir($dh))) {
			$arr = explode("_", $filename);
			
			if ((count($arr) == 3) && ($flag == FALSE))
			{
				if ((strstr($arr[2], $value["reg_num"]) != FALSE) && ($income_date == $arr[1]) && ($value["id_doc_type"] == $arr[0]))
				{
					$linkPor = "<a href=".$dir.$filename." target=\"_blank\">Ссылка на документ</a>";
					$flag = TRUE;
				}
				else
					$linkPor = "Файл не найден";
			}
		}
		
		$html .= '<tr data-user-id="'.$value["id"].'">
		<td style="text-align: center; vertical-align: middle;">'.$value["doc_type"].'</td>
		<td style="text-align: center; vertical-align: middle;">'.$income_date.'</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["reg_num"].'</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["topic"].'</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["org_name"].'</td>
		<td style="text-align: center; vertical-align: middle;">'.$linkPor.'</td>
	
		<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default show_exec" data-order-id='.$value["id"].' data-toggle="modal" data-target="#modal-view-order"><span class="glyphicon glyphicon-search"></span></button></td>
		<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default edit_order" data-order-id='.$value["id"].' data-toggle="modal" data-target="#modal-edit-order"><span class="glyphicon glyphicon-edit"></span></button></td>
		<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default delete_order" data-order-id='.$value["id"].'><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
	}
	
	return $html;
}

function show_exec($data, $html = "")
{
	$i = 1;
	foreach($data as $value)
	{
		if ($value["exec_mark"] == "1")
		
			$exec_mark_output = "<span class=\"glyphicon glyphicon-ok\"></span>";
		else
			$exec_mark_output = "";
		
		$income_date = date("d.m.Y", strtotime($value["income_date"]));
		
		$dir = "uploads/por/";
		$linkOtv = "Файл не найден";
		$flag = FALSE;
		
		$dh = opendir($dir);
		while (false !== ($filename = readdir($dh))) {
			$arr = explode("_", $filename);
			
			if ((count($arr) == 4) && ($flag == FALSE))
			{
				if (($value["id_doc_type"] == $arr[0]) && (strstr($arr[2], $value["reg_num"]) != FALSE) && ($income_date == $arr[1]) && ($arr[3] == $value["executor"].".pdf"))
				{
					$linkOtv = "<a href=".$dir.$filename." target=\"_blank\">Ссылка на документ</a>";
					$flag = TRUE;
				}
				else
				{
					$linkOtv = "Файл не найден";
				}
			}
		}
		
		$html .= '<tr data-user-id="'.$value["id"].'">
		<td style="text-align: center; vertical-align: middle;">'.$i.'</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["function_name"].'</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["fio"].'</td>
		<td style="text-align: center; vertical-align: middle;">'.date("d.m.Y", strtotime($value["exec_date"])).'</td>
		<td style="text-align: center; vertical-align: middle;">'.$exec_mark_output.'</td>
		<td style="text-align: center; vertical-align: middle;">'.$linkOtv.'</td>';
	
		$i++;
	}
	
	return $html;
}

function show_one_order($data, $html="")
{
	foreach($data as $value)
	{	
		$income_date = date("d.m.Y", strtotime($value["income_date"]));
	
		$dir = "uploads/doc/";
		$linkPor = "Файл не найден";
		$flag = FALSE;
		
		$dh = opendir($dir);
		while (false != ($filename = readdir($dh))) {
			$arr = explode("_", $filename);
			
			if ((count($arr) == 3) && ($flag == FALSE))
			{
				if ((strstr($arr[2], $value["reg_num"]) != FALSE) && ($income_date == $arr[1]) && ($value["id_doc_type"] == $arr[0]))
				{
					$linkPor = "<a href=".$dir.$filename." target=\"_blank\">Ссылка на документ</a>";
					$flag = TRUE;
				}
				else
					$linkPor = "Файл не найден";
			}
		}
	
		$html .= '
		<tr>
		<td style="text-align: center; vertical-align: middle; background-color: #c2c2c2; font-weight: bold;">Тип документа</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["doc_type"].'</td>
		</tr>
		<tr>
		<td style="text-align: center; vertical-align: middle; background-color: #c2c2c2; font-weight: bold;">Дата поступления</td>
		<td style="text-align: center; vertical-align: middle;">'.$income_date.'</td>
		</tr>
		<tr>
		<td style="text-align: center; vertical-align: middle; background-color: #c2c2c2; font-weight: bold;">Регистрационный номер</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["reg_num"].'</td>
		</tr>
		<tr>
		<td style="text-align: center; vertical-align: middle; background-color: #c2c2c2; font-weight: bold;">Тема документа</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["topic"].'</td>
		</tr>
		<tr>
		<td style="text-align: center; vertical-align: middle; background-color: #c2c2c2; font-weight: bold;">Корреспондент</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["org_name"].'</td>
		</tr>
		<tr>
		<td style="text-align: center; vertical-align: middle; background-color: #c2c2c2; font-weight: bold;">Просмотр документа</td>
		<td style="text-align: center; vertical-align: middle;">'.$linkPor.'</td>
		</tr>
		';
	}
	
	return $html;
}

function select_all_exec($data, $html = "")
{
	$i = 1;
	
	foreach($data as $value)
	{	
		if ($value["exec_mark"] == 0)
			$checked = "";
		else
			$checked = "checked";
	
		$html .=
		'<div style="border: 2px dashed black; padding: 5px; margin-bottom: 10px; margin-top: 10px; width: 40%;" class="executor-block" data-id="'.$value["id"].'">
		<label>ФИО исполнителя</label>
		<button class="btn btn-default del-exec" type="button" style="float: right;" data-id="'.$value["id"].'">Удалить</button>
		<br>
		<div class="form-group" style="width: 60%; margin-bottom: 10px;"><select class="chosen-select executor" name="executor-'.$i.'" data-placeholder="Должностное лицо (исполнитель)">
		<option value="'.$value["executor"].'" selected>'.$value["fio"].'</option>
		</select></div>
		<br><label>Дата исполнения</label><br>
		<div class="form-group" style="width: 60%; margin-bottom: 10px;"><input class="form-control exec_date" style="width: 100%;" type="date" name="exec_date-'.$i.'" placeholder="Дата исполнения" value='.$value['exec_date'].'></div>
		<br><label>Отметка об исполнении</label><br>
		<div class="form-group" style="width: 5%; margin-bottom: 10px;"><input class="form-control exec_mark" style="width: 100%;" type="checkbox" name="exec_mark-'.$i.'" '.$checked.'></div></div>
		<input class="very-last-counter" type="hidden" value="'.$i.'">
		<input type="hidden" name="isid-'.$i.'" value="'.$value["id"].'">';
		
		
		$i++;
	}
	
	return $html;
}

function show_alert_msg($data, $html = "") {
	foreach ($data as $value)
	{
		
		if ($value["exec_date"] != "0000-00-00")
		{
			$years = calculate_year($value["exec_date"], date("Y-m-d"));
			$months = calculate_month($value["exec_date"], date("Y-m-d"));
			$days = calculate_day($value["exec_date"], date("Y-m-d")); 
			
			if (($years == 0) && ($months == 0) && ($days <= 2))
				$html .= "► ".$value["fio"]."<br>";
		}
		
	}
	
	$saveAlertData["html"] = $html;
	$saveAlertData["login"] = $_SESSION["login"];
	
	return $saveAlertData;
}

/***Спавочная информация***/
function show_corr_list($data, $html = '<option value=""></option>'){
	foreach($data as $value){
		$html .= '<option value="'.$value['id'].'">'.$value['org_name'].'</option>';
		
	}
	
	return $html;
}

function show_executor_list($data, $html = '<option value=""></option>'){
	foreach($data as $value){
		$html .= '<option value="'.$value['id'].'">'.$value['fio'].'</option>';
	}
	
	return $html;
}

function show_position_list($data, $html = '<option value=""></option>'){
	foreach($data as $value){
		$html .= '<option value="'.$value['id'].'">'.$value['function_name'].'</option>';
	}
	
	return $html;
}

function show_doc_type_list($data, $html = '<option value=""></option>'){
	foreach($data as $value){
		$html .= '<option value="'.$value['id'].'">'.$value['doc_type'].'</option>';
	}
	
	return $html;
}
/*************************/

function calculate_year($date_end, $date_begin) {
	if ( date("Y", strtotime($date_end)) >= date("Y", strtotime($date_begin) ))
	{
		$date1 = new DateTime($date_begin);
		$date2 = new DateTime($date_end);
		$interval = $date1->diff($date2);
		
		return $interval->y;
	}
	else
		return 0;
}

function calculate_month($date_end, $date_begin) {

	$date1 = new DateTime($date_begin);
	$date2 = new DateTime($date_end);
	$interval = $date1->diff($date2);

	return $interval->m;

}

function calculate_day($date_end, $date_begin) {
		$date1 = new DateTime($date_begin);
		$date2 = new DateTime($date_end);
		$interval = $date1->diff($date2);
		
		if ((strtotime($date_end) - strtotime($date_begin)) < 0)
			return 0;
		else
			return $interval->d;
}

//**********************************************************

switch( $_POST['action'] ){
	case 'start_load':
		/***Таблица поручений***/
		$select_order = $orders->show_order_full();
		if( !empty($select_order) ){
			$success["orders_table"] = show_order($select_order);
		}
		else{ $success["orders_table"] = '<tr><td style="text-align: center;" colspan="8">Поручения не найдены. Обратитесь в службу поддержки.</td></tr>'; }
		
		/****Корреспондент***/
		$select_corr_list = $orders->show_corr_list();
		if( !empty($select_corr_list) ){
			$success["corr_list"] = show_corr_list($select_corr_list);
		}
		else{ $success["corr_list"] = '<option value=""></option>'; }
		
		/***Исполнитель***/
		$select_executor_list = $orders->show_executor_list();
		if( !empty($select_executor_list) ){
			$success["executor_list"] = show_executor_list($select_executor_list);
		}
		else{ $success["executor_list"] = '<option value=""></option>'; }

		//Должности
		$select_position_list = $orders->show_position_list();
		if( !empty($select_position_list) ){
			$success["position_list"] = show_position_list($select_position_list);
		}
		else{ $success["position_list"] = '<option value=""></option>'; }
		
		//Тип документа
		$select_doc_type_list = $orders->show_doc_type_list();
		if( !empty($select_doc_type_list) ){
			$success["doc_type_list"] = show_doc_type_list($select_doc_type_list);
		}
		else{ $success["doc_type_list"] = '<option value=""></option>'; }

		echo ajax_response($success, $error);
	break;
	
	case 'form-add-exec':
		parse_str($_POST['data'], $row_form);
		
		$orig_data = ["position", "executor", "exec_date", "exec_mark", "order_id"];
		
		if (isset($row_form['exec_mark']))
			$row_form['exec_mark'] = 1;
		else
			$row_form['exec_mark'] = 0;
		
		for( $i=0; $i<count($row_form); $i++ ){
			$data_db[":" . $orig_data[$i]] = $row_form[$orig_data[$i]];
		}
		
		$last_id = $orders->create_exec($data_db);
		if( !empty($last_id) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Исполнитель успешно добавлен.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }

		echo ajax_response($success, $error);
	break;
	
	case 'form-add-order':
		$data_db = [":doc_type" => $_POST["doc_type"], 
					":income_date" => $_POST["income_date"],
					":reg_num" => $_POST["reg_num"],
					":topic" => $_POST["topic"],
					":corr" => $_POST["corr"]];
		
		$dir = "uploads/doc/";
		
		$last_id = $orders->create_order($data_db);
		if( !empty($last_id) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Документ успешно добавлен.</div>';
			
			if (isset($_FILES["file-doc"]))
			{
				$info = new SplFileInfo(basename($_FILES["file-doc"]["name"]));
				$ext = $info->getExtension();
				$fn = $_POST["doc_type"]."_".date("d.m.Y", strtotime($_POST["income_date"]))."_".$_POST["reg_num"].".".$ext;
				
				$filedir = $dir.$fn;
				move_uploaded_file($_FILES['file-doc']['tmp_name'], $filedir);
			}
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }

		echo ajax_response($success, $error);
	break;
	
	case 'form-update-order':
		$data_db = [":doc_type" => $_POST["doc_type"], 
					":income_date" => $_POST["income_date"],
					":reg_num" => $_POST["reg_num"],
					":topic" => $_POST["topic"],
					":corr" => $_POST["corr"],
					":order_id" => $_POST["order_id"]];
	
		$dir = "uploads/por/";
	
		$last_id = $orders->update_order($data_db);
		if( !empty($last_id) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px; width: 30%;">Данные успешно обновлены.</div>';
			
			//Добавление исполнителей
			if ($_POST["counter"] > 0)
			{
				for ($i = 0; $i < $_POST["counter"]; $i++)
				{	
					$data_db_exec[":executor"] = $_POST["executor-".($i+1)];
					$data_db_exec[":exec_date"] = $_POST["exec_date-".($i+1)];
					$data_db_exec[":id"] = $_POST["order_id"];
					
					if (isset($_FILES["file-por-".($i+1)]))
					{
						$info = new SplFileInfo(basename($_FILES["file-por-".($i+1)]["name"]));
						$ext = $info->getExtension();
						$fn = $_POST["doc_type"]."_".date("d.m.Y", strtotime($_POST["income_date"]))."_".$_POST["reg_num"]."_".$_POST["executor-".($i+1)].".".$ext;
						
						$filedir = $dir.$fn;
						move_uploaded_file($_FILES['file-por-'.($i+1)]['tmp_name'], $filedir);
					}
					
					if (isset($_POST["exec_mark-".($i+1)]))
						$_POST["exec_mark-".($i+1)] = 1;
					else
						$_POST["exec_mark-".($i+1)] = 0;
					
					$data_db_exec[":exec_mark"] = $_POST["exec_mark-".($i+1)];
					
					
					if (isset($_POST["isid-".($i+1)]))
					{
						$data_db_exec[":id"] = $_POST["isid-".($i+1)];
						$orders->update_executor($data_db_exec);
					}
					else
						$last_id = $orders->add_executor($data_db_exec);
					
				}
			}
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px; width: 30%;">Ошибка. Обратитесь в службу поддержки.</div>'; }
	
		echo ajax_response($success, $error);
	break;
	
	case 'delete_order':
		$delete_data = $orders->delete_order([":order_id" => $_POST['data']]);
		$success = "Удаление поручения успешно произведено.";
		
		echo ajax_response($success, $error);
	break;
	
	case 'edit_order':
		$edit_data = $orders->edit_order([":order_id" => $_POST['data']]);
		if( !empty($edit_data) ){
			$success = $edit_data;
		}
		else{ $error = "Ошибка. Обратитесь в службу поддержки."; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'show_executors':
		$select_exec = $orders->show_exec_full([":exec_id" => $_POST['data']]);
		if( !empty($select_exec) ){
			$success["executors_table"] = show_exec($select_exec);
			$success["reg_num"] = $select_exec[0]["reg_num"];
		}
		else{ $success["executors_table"] = '<tr><td style="text-align: center;" colspan="8">Поручения не найдены. Обратитесь в службу поддержки.</td></tr>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'add-executors':
		$select_executor_list = $orders->show_executor_list();
		if( !empty($select_executor_list) ){
			$success["executor_list"] = show_executor_list($select_executor_list);
		}
		else{ $success["executor_list"] = '<option value=""></option>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'show_orders_table':
		$select_order = $orders->show_order([":order_id" => $_POST['data']]);
		if( !empty($select_order) ){
			$success["show_order"] = show_one_order($select_order);
		}
		else{ $success["show_order"] = '<tr><td style="text-align: center;" colspan="8">Поручения не найдены. Обратитесь в службу поддержки.</td></tr>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'add_all_exec':
		$select_all_exec = $orders->select_all_exec([":exec_id" => $_POST['data']]);
		
		if (!empty($select_all_exec))
			$success["all_exec"] = select_all_exec($select_all_exec);
		else
			$success["all_exec"] = "";
	
		echo ajax_response($success, $error);
	break;
	
	case 'delete-exec':
		$delete_data = $orders->delete_exec([":exec_id" => $_POST['exec_id']]);
		
		echo ajax_response($success, $error);
	break;
	
	case 'show_alert_msg':
		$select_show_alert_msg = $orders->show_alert_msg();
		
		if(!empty($select_show_alert_msg))
			$success["alert_msg"] = show_alert_msg($select_show_alert_msg);
		else
			$success["alert_msg"] = "";
		
		echo ajax_response($success, $error);
	break;
}
?>