<?php
session_start();

include_once "personal.db.php";
$personal= new personal();
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
function show_user($data, $html = "", $subdivision_id = ""){
	foreach($data as $value){
		if( $subdivision_id != $value["user_subdivision"]){
			$subdivision_id = $value["user_subdivision"];
			$html .= '<tr data-subdivision-id="'.$value["user_subdivision"].'"><td colspan="8" style="padding-top: 20px; background: rgba(0,0,0,.1); text-transform: uppercase;"><b>'.$value['subdivision_name'].'</b></td></tr>';
		}

		$html .= '<tr data-user-id="'.$value["id"].'"><td style="vertical-align: middle;">'.$value["user_f"].' '.$value["user_i"].' '.$value["user_o"].'</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["gender_name"].'</td>
		<td style="text-align: center; vertical-align: middle;">'.date("d.m.Y", strtotime($value["user_dob"])).'</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["education_name"].'</td>
		<td style="text-align: center; vertical-align: middle;">'.$value["function_name"].'</td>
		<td style="text-align: center; vertical-align: middle;">'.date("d.m.Y", strtotime($value["user_receipt"])).'</td>
		<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default edit_user" data-user-id='.$value["id"].' data-toggle="modal" data-target="#modal-edit-user"><span class="glyphicon glyphicon-edit"></span></button></td>
		<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default delete_user" data-user-id='.$value["id"].'><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
	}
	
	return $html;
}
//Вывод информации по контрактам
function show_contracts($data, $html = "", $subdivision_id = ""){
	$fioContract = array();
	foreach($data as $value)
	{
		if ($value["contract_extend_begin"] == "0000-00-00" && $value["contract_extend_end"] == "0000-00-00"){
			$years = calculate_year($value["contract_date_end"], date("Y-m-d"));
			$months = calculate_month($value["contract_date_end"], date("Y-m-d"));
			$days = calculate_day($value["contract_date_end"], date("Y-m-d"));
		}
		elseif( $value["contract_extend_begin"] != "0000-00-00" && $value["contract_extend_end"] != "0000-00-00" ){
			$years = calculate_year($value["contract_extend_end"], date("Y-m-d"));
			$months = calculate_month($value["contract_extend_end"], date("Y-m-d"));
			$days = calculate_day($value["contract_extend_end"], date("Y-m-d"));
		}
		
		if( $subdivision_id != $value["user_subdivision"]){
			$subdivision_id = $value["user_subdivision"];
			$html .= '<tr data-subdivision-id="'.$value["user_subdivision"].'"><td colspan="10" style="padding-top: 20px; background: rgba(0,0,0,.1); text-transform: uppercase;"><b>'.$value['subdivision_name'].'</b></td></tr>';
		}

		//Сотрудники, у которых истекает срок контракта, помечаются красной строкой
		if ((($years == 0) && (($months == 1) && ($days <= 15))) || (($years == 0) && (($months == 0) && ($days <= 31))) && (($years > 0) || ($months > 0) || ($days > 0)))
		{
	//		if (($value["contract_date_begin"] == "0000-00-00") && ($value["contract_date_end"] == "0000-00-00") && ($value["contract_extend_begin"] == "0000-00-00") && ($value["contract_extend_end"] == "0000-00-00"))
	//	{
	//		$years = "";
	//		$months = "";
	//		$days = "";
	//	}
			
			if ($value["contract_date_begin"] == "0000-00-00")
				$contract_date_begin = "";
			else
				$contract_date_begin = date("d.m.Y", strtotime($value["contract_date_begin"]));
			
			if ($value["contract_date_end"] == "0000-00-00")
				$contract_date_end = "";
			else
				$contract_date_end = date("d.m.Y", strtotime($value["contract_date_end"]));
			
			if ($value["contract_extend_begin"] == "0000-00-00")
				$contract_extend_begin = "";
			else
				$contract_extend_begin = date("d.m.Y", strtotime($value["contract_extend_begin"]));
			
			if ($value["contract_extend_end"] == "0000-00-00")
				$contract_extend_end = "";
			else
				$contract_extend_end = date("d.m.Y", strtotime($value["contract_extend_end"]));
			

			array_push($fioContract, "► ".trim($value["user_f"])." ".mb_substr($value["user_i"], 0, 1, 'UTF-8').".".mb_substr($value["user_o"], 0, 1, 'UTF-8').". (".$value["function_name"].")<br>");
			$html .= '<tr data-user-id="'.$value["id"].'" style="background-color: red;">
			<td style="vertical-align: middle;">'.$value["user_f"]." ".$value["user_i"]." ".$value["user_o"].'</td>
			<td style="text-align: center; vertical-align: middle;">'.$value["contract_num"].'</td>
			<td style="text-align: center; vertical-align: middle;">'.$contract_date_begin.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$contract_date_end.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$years.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$months.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$days.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$contract_extend_begin.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$contract_extend_end.'</td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default edit_contract" data-user-id='.$value["id"].' data-toggle="modal" data-target="#modal-edit-contract"><span class="glyphicon glyphicon-edit"></span></button></td></tr>';
			
		}
		else
		{
			if (($value["contract_date_begin"] == "0000-00-00") && ($value["contract_date_end"] == "0000-00-00") && ($value["contract_extend_begin"] == "0000-00-00") && ($value["contract_extend_end"] == "0000-00-00"))
		{
			$years = " ";
			$months = " ";
			$days = " ";
		}
			
			if ($value["contract_date_begin"] == "0000-00-00")
				$contract_date_begin = "";
			else
				$contract_date_begin = date("d.m.Y", strtotime($value["contract_date_begin"]));
			
			if ($value["contract_date_end"] == "0000-00-00")
				$contract_date_end = "";
			else
				$contract_date_end = date("d.m.Y", strtotime($value["contract_date_end"]));
			
			if ($value["contract_extend_begin"] == "0000-00-00")
				$contract_extend_begin = "";
			else
				$contract_extend_begin = date("d.m.Y", strtotime($value["contract_extend_begin"]));
			
			if ($value["contract_extend_end"] == "0000-00-00")
				$contract_extend_end = "";
			else
				$contract_extend_end = date("d.m.Y", strtotime($value["contract_extend_end"]));
			
			$html .= '<tr data-user-id="'.$value["id"].'">]
			<td style="vertical-align: middle;" id="">'.$value["user_f"].' '.$value["user_i"].' '.$value["user_o"].'</td>
			<td style="text-align: center; vertical-align: middle;">'.$value["contract_num"].'</td>
			<td style="text-align: center; vertical-align: middle;">'.$contract_date_begin.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$contract_date_end.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$years.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$months.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$days.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$contract_extend_begin.'</td>
			<td style="text-align: center; vertical-align: middle;">'.$contract_extend_end.'</td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default edit_contract" data-user-id='.$value["id"].' data-toggle="modal" data-target="#modal-edit-contract"><span class="glyphicon glyphicon-edit"></span></button></td></tr>';
		}
	}
	
	$saveHtmlContract["html"] = $html;
	$saveHtmlContract["fioContract"] = $fioContract;
	
	return $saveHtmlContract;
}

/***Спавочная информация***/
function show_gender_list($data, $html = '<option value=""></option>'){
	foreach($data as $value){
		$html .= '<option value="'.$value['id'].'">'.$value['gender_name'].'</option>';
	}
	
	return $html;
}

function show_function_list($data, $html = '<option value=""></option>'){
	foreach($data as $value){
		$html .= '<option value="'.$value['id'].'">'.$value['function_name'].'</option>';
	}
	
	return $html;
}

function show_education_list($data, $html = '<option value=""></option>'){
	foreach($data as $value){
		$html .= '<option value="'.$value['id'].'">'.$value['education_name'].'</option>';
	}
	
	return $html;
}

function show_subdivision_list($data, $html = '<option value=""></option>'){
	foreach($data as $value){
		$html .= '<option value="'.$value['id'].'">'.$value['subdivision_name'].'</option>';
	}
	
	return $html;
}

function show_category_list($data, $html = '<option value=""></option>'){
	foreach($data as $value){
		$html .= '<option value="'.$value['id'].'">'.$value['category_name'].'</option>';
	}
	
	return $html;
}
/*************************/

function calculate_age($birthday) {
	$birthday_timestamp = strtotime($birthday);
	$age = date('Y', strtotime("2016-12-31")) - date('Y', $birthday_timestamp);
	if(date('md', $birthday_timestamp) > date('md', strtotime("2016-12-31"))) {
		$age--;
	}
	
	return $age;
}

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

function statistic_data($data){
	$str_01_1 = 0;  $str_01_2 = 0;	$str_01_3 = 0;	$str_01_4 = 0;	$str_01_5 = 0;	$str_01_6 = 0;	$str_01_7 = 0;	$str_01_8 = 0;
	$str_02_1 = 0;	$str_02_2 = 0;	$str_02_3 = 0;	$str_02_4 = 0;	$str_02_5 = 0;	$str_02_6 = 0;	$str_02_7 = 0;	$str_02_8 = 0;
	$str_03_1 = 0;	$str_03_2 = 0;	$str_03_3 = 0;	$str_03_4 = 0;	$str_03_5 = 0;	$str_03_6 = 0;	$str_03_7 = 0;	$str_03_8 = 0;
	$str_04_1 = 0;	$str_04_2 = 0;	$str_04_3 = 0;	$str_04_4 = 0;	$str_04_5 = 0;	$str_04_6 = 0;	$str_04_7 = 0;	$str_04_8 = 0;
	$str_05_1 = 0;	$str_05_2 = 0;	$str_05_3 = 0;	$str_05_4 = 0;	$str_05_5 = 0;	$str_05_6 = 0;	$str_05_7 = 0;	$str_05_8 = 0;
	$str_06_1 = 0;	$str_06_2 = 0;	$str_06_3 = 0;	$str_06_4 = 0;	$str_06_5 = 0;	$str_06_6 = 0;	$str_06_7 = 0;	$str_06_8 = 0;
	$str_07_1 = 0;	$str_07_2 = 0;	$str_07_3 = 0;	$str_07_4 = 0;	$str_07_5 = 0;	$str_07_6 = 0;	$str_07_7 = 0;	$str_07_8 = 0;
	$str_08_1 = 0;	$str_08_2 = 0;	$str_08_3 = 0;	$str_08_4 = 0;	$str_08_5 = 0;	$str_08_6 = 0;	$str_08_7 = 0;	$str_08_8 = 0;
	$str_09_1 = 0;	$str_09_2 = 0;	$str_09_3 = 0;	$str_09_4 = 0;	$str_09_5 = 0;	$str_09_6 = 0;	$str_09_7 = 0;	$str_09_8 = 0;
	$str_10_1 = 0;	$str_10_2 = 0;	$str_10_3 = 0;	$str_10_4 = 0;	$str_10_5 = 0;	$str_10_6 = 0;	$str_10_7 = 0;	$str_10_8 = 0;
	$str_11_1 = 0;	$str_11_2 = 0;	$str_11_3 = 0;	$str_11_4 = 0;	$str_11_5 = 0;	$str_11_6 = 0;	$str_11_7 = 0;	$str_11_8 = 0;
	$str_12_1 = 0;	$str_12_2 = 0;	$str_12_3 = 0;	$str_12_4 = 0;	$str_12_5 = 0;	$str_12_6 = 0;	$str_12_7 = 0;	$str_12_8 = 0;
	$str_13_1 = 0;	$str_13_2 = 0;	$str_13_3 = 0;	$str_13_4 = 0;	$str_13_5 = 0;	$str_13_6 = 0;	$str_13_7 = 0;	$str_13_8 = 0;
	$str_14_1 = 0;	$str_14_2 = 0;	$str_14_3 = 0;	$str_14_4 = 0;	$str_14_5 = 0;	$str_14_6 = 0;	$str_14_7 = 0;	$str_14_8 = 0;
	$str_15_1 = 0;	$str_15_2 = 0;	$str_15_3 = 0;	$str_15_4 = 0;	$str_15_5 = 0;	$str_15_6 = 0;	$str_15_7 = 0;	$str_15_8 = 0;
	$str_16_1 = 0;	$str_16_2 = 0;	$str_16_3 = 0;	$str_16_4 = 0;	$str_16_5 = 0;	$str_16_6 = 0;	$str_16_7 = 0;	$str_16_8 = 0;
	$str_17_1 = 0;	$str_17_2 = 0;	$str_17_3 = 0;	$str_17_4 = 0;	$str_17_5 = 0;	$str_17_6 = 0;	$str_17_7 = 0;	$str_17_8 = 0;
	$str_18_1 = 0;	$str_18_2 = 0;	$str_18_3 = 0;	$str_18_4 = 0;	$str_18_5 = 0;	$str_18_6 = 0;	$str_18_7 = 0;	$str_18_8 = 0;
	
	
	foreach( $data as $value ){
		$user_dob = calculate_age($value["user_dob"]);
		
		if( $value["user_category"] == 1 ){
			/****Всего сотрудников****/
			if( isset($str_01_3) ){ $str_01_3++; }else{ $str_01_3 = 0; $str_01_3++; }		// Количество руководителей

			if( $value["user_function"] == 1 ){ 
				if( isset($str_01_8) ){ $str_01_8++; }else{ $str_01_8 = 0; $str_01_8++; } 	// Количество руководителей юридического лица - Директор
			}else{ if( !isset($str_01_8) ){ $str_01_8 = 0; } }
			
			/****Образование****/
			if( $value["user_education"] == 4 ){
				if( isset($str_02_3) ){ $str_02_3++; }else{ $str_02_3 = 0; $str_02_3++; } 	// Количество руководителей с высшим образованием
			}else{ if( !isset($str_02_3) ){ $str_02_3 = 0; } }
			
			if( $value["user_education"] == 11 ){ 
				if( isset($str_03_3) ){ $str_03_3++; }else{ $str_03_3 = 0; $str_03_3++; } 	// Количество руководителей с средним специальным образованием
			}else{ if( !isset($str_03_3) ){ $str_03_3 = 0; } }
			
			if( $value["user_education"] == 12 ){
				if( isset($str_04_3) ){ $str_04_3++; }else{ $str_04_3 = 0; $str_04_3++; } 	// Количество руководителей с профессионально техническим образованием
			}else{ if( !isset($str_04_3) ){ $str_04_3 = 0; } }
			
			if( $value["user_education"] == 7 ){ 
				if( isset($str_05_3) ){ $str_05_3++; }else{ $str_05_3 = 0; $str_05_3++; } 	// Количество руководителей с общим средним образованием
			}else{ if( !isset($str_05_3) ){ $str_05_3 = 0; } }
			
			if( $value["user_education"] == 8 ){ 
				if( isset($str_06_3) ){ $str_06_3++; }else{ $str_06_3 = 0; $str_06_3++; } 	// Количество руководителей с общим базовым образованием
			}else{ if( !isset($str_06_3) ){ $str_06_3 = 0; } }
			
			/****Возвраст****/
			if( $user_dob < 16 ){ 
				if( isset($str_07_3) ){ $str_07_3++; }else{ $str_07_3 = 0; $str_07_3++; } 	// Количество руководителей до 16 лет
			}else{ if( !isset($str_07_3) ){ $str_07_3 = 0; } }
			
			if( $user_dob >= 16 and $user_dob <= 17 ){ 
				if( isset($str_08_3) ){ $str_08_3++; }else{ $str_08_3 = 0; $str_08_3++; } 	// Количество руководителей от 16 до 17 лет
			}else{ if( !isset($str_08_3) ){ $str_08_3 = 0; } }
			
			if( $user_dob >= 18 and $user_dob <= 24 ){ 
				if( isset($str_09_3) ){ $str_09_3++; }else{ $str_09_3 = 0; $str_09_3++; } 	// Количество руководителей от 18 до 24 лет
			}else{ if( !isset($str_09_3) ){ $str_09_3 = 0; } }
			
			if( $user_dob >= 25 and $user_dob <= 29 ){ 
				if( isset($str_10_3) ){ $str_10_3++; }else{ $str_10_3 = 0; $str_10_3++; } 	// Количество руководителей от 25 до 29 лет
			}else{ if( !isset($str_10_3) ){ $str_10_3 = 0; } }
			
			if( $user_dob == 30 ){ 
				if( isset($str_11_3) ){ $str_11_3++; }else{ $str_11_3 = 0; $str_11_3++; } 	// Количество руководителей 30 лет
			}else{ if( !isset($str_11_3) ){ $str_11_3 = 0; } }
			
			if( $user_dob == 31 ){ 
				if( isset($str_12_3) ){ $str_12_3++; }else{ $str_12_3 = 0; $str_12_3++; } 	// Количество руководителей 31 лет
			}else{ if( !isset($str_12_3) ){ $str_12_3 = 0; } }
			
			if( $user_dob >= 32 and $user_dob <= 39 ){ 
				if( isset($str_13_3) ){ $str_13_3++; }else{ $str_13_3 = 0; $str_13_3++; } 	// Количество руководителей от 32 до 39 лет
			}else{ if( !isset($str_13_3) ){ $str_13_3 = 0; } }
			
			if( $user_dob >= 40 and $user_dob <= 49 ){ 
				if( isset($str_14_3) ){ $str_14_3++; }else{ $str_14_3 = 0; $str_14_3++; } 	// Количество руководителей от 40 до 49 лет
			}else{ if( !isset($str_14_3) ){ $str_14_3 = 0; } }
			
			if( $user_dob >= 50 and $user_dob <= 54 ){ 
				if( isset($str_15_3) ){ $str_15_3++; }else{ $str_15_3 = 0; $str_15_3++; } 	// Количество руководителей от 50 до 54 лет
			}else{ if( !isset($str_15_3) ){ $str_15_3 = 0; } }
			
			if( $user_dob >= 55 and $user_dob <= 59 ){ 
				if( isset($str_16_3) ){ $str_16_3++; }else{ $str_16_3 = 0; $str_16_3++; } 	// Количество руководителей от 55 до 59 лет
			}else{ if( !isset($str_16_3) ){ $str_16_3 = 0; } }
			
			if( $user_dob >= 60 ){ 
				if( isset($str_17_3) ){ $str_17_3++; }else{ $str_17_3 = 0; $str_17_3++; } 	// Количество руководителей от 60 и старше
			}else{ if( !isset($str_17_3) ){ $str_17_3 = 0; } }
			
			if( $value["user_gender"] == 2 ){ 
				if( isset($str_18_3) ){ $str_18_3++; }else{ $str_18_3 = 0; $str_18_3++; }	// Количество руководителей женщин
				
				if( $value["user_function"] == 1 ){ 
					if( isset($str_18_8) ){ $str_18_8++; }else{ $str_18_8 = 0; $str_18_8++; } 	// Количество руководителей юридического лица - Директор / Женщина
				}else{ if( !isset($str_18_8) ){ $str_18_8 = 0; } }
				
			}else{ if( !isset($str_18_3) ){ $str_18_3 = 0; } }
		}
		
		if( $value["user_category"] == 2 ) {
			/****Всего сотрудников****/
			if( isset($str_01_4) ){ $str_01_4++; }else{ $str_01_4 = 0; $str_01_4++; }		// Количество специалистов
			
			/****Образование****/
			if( $value["user_education"] == 4 ){
				if( isset($str_02_4) ){ $str_02_4++; }else{ $str_02_4 = 0; $str_02_4++; } 	// Количество специалистов с высшим образованием
			}else{ if( !isset($str_02_4) ){ $str_02_4 = 0; } }
			
			if( $value["user_education"] == 11 ){ 
				if( isset($str_03_4) ){ $str_03_4++; }else{ $str_03_4 = 0; $str_03_4++; } 	// Количество специалистов с средним специальным образованием
			}else{ if( !isset($str_03_4) ){ $str_03_4 = 0; } }
			
			if( $value["user_education"] == 12 ){
				if( isset($str_04_4) ){ $str_04_4++; }else{ $str_04_3 = 0; $str_04_4++; } 	// Количество специалистов с профессионально техническим образованием
			}else{ if( !isset($str_04_4) ){ $str_04_4 = 0; } }
			
			if( $value["user_education"] == 7 ){ 
				if( isset($str_05_4) ){ $str_05_4++; }else{ $str_05_4 = 0; $str_05_4++; } 	// Количество специалистов с общим средним образованием
			}else{ if( !isset($str_05_4) ){ $str_05_4 = 0; } }
			
			if( $value["user_education"] == 8 ){ 
				if( isset($str_06_4) ){ $str_06_4++; }else{ $str_06_4 = 0; $str_06_4++; } 	// Количество специалистов с общим базовым образованием
			}else{ if( !isset($str_06_4) ){ $str_06_4 = 0; } }
			
			/****Возвраст****/
			if( $user_dob < 16 ){ 
				if( isset($str_07_4) ){ $str_07_4++; }else{ $str_07_4 = 0; $str_07_4++; } 	// Количество специалистов до 16 лет
			}else{ if( !isset($str_07_4) ){ $str_07_4 = 0; } }
			
			if( $user_dob >= 16 and $user_dob <= 17 ){ 
				if( isset($str_08_4) ){ $str_08_4++; }else{ $str_08_4 = 0; $str_08_4++; } 	// Количество специалистов от 16 до 17 лет
			}else{ if( !isset($str_08_4) ){ $str_08_4 = 0; } }
			
			if( $user_dob >= 18 and $user_dob <= 24 ){ 
				if( isset($str_09_4) ){ $str_09_4++; }else{ $str_09_4 = 0; $str_09_4++; } 	// Количество специалистов от 18 до 24 лет
			}else{ if( !isset($str_09_4) ){ $str_09_4 = 0; } }
			
			if( $user_dob >= 25 and $user_dob <= 29 ){ 
				if( isset($str_10_4) ){ $str_10_4++; }else{ $str_10_4 = 0; $str_10_4++; } 	// Количество специалистов от 25 до 29 лет
			}else{ if( !isset($str_10_4) ){ $str_10_4 = 0; } }
			
			if( $user_dob == 30 ){ 
				if( isset($str_11_4) ){ $str_11_4++; }else{ $str_11_4 = 0; $str_11_4++; } 	// Количество специалистов 30 лет
			}else{ if( !isset($str_11_4) ){ $str_11_4 = 0; } }
			
			if( $user_dob == 31 ){ 
				if( isset($str_12_4) ){ $str_12_4++; }else{ $str_12_4 = 0; $str_12_4++; } 	// Количество специалистов 31 лет
			}else{ if( !isset($str_12_4) ){ $str_12_4 = 0; } }
			
			if( $user_dob >= 32 and $user_dob <= 39 ){ 
				if( isset($str_13_4) ){ $str_13_4++; }else{ $str_13_4 = 0; $str_13_4++; } 	// Количество специалистов от 32 до 39 лет
			}else{ if( !isset($str_13_4) ){ $str_13_4 = 0; } }
			
			if( $user_dob >= 40 and $user_dob <= 49 ){ 
				if( isset($str_14_4) ){ $str_14_4++; }else{ $str_14_4 = 0; $str_14_4++; } 	// Количество специалистов от 40 до 49 лет
			}else{ if( !isset($str_14_4) ){ $str_14_4 = 0; } }
			
			if( $user_dob >= 50 and $user_dob <= 54 ){ 
				if( isset($str_15_4) ){ $str_15_4++; }else{ $str_15_4 = 0; $str_15_4++; } 	// Количество специалистов от 50 до 54 лет
			}else{ if( !isset($str_15_4) ){ $str_15_4 = 0; } }
			
			if( $user_dob >= 55 and $user_dob <= 59 ){ 
				if( isset($str_16_4) ){ $str_16_4++; }else{ $str_16_4 = 0; $str_16_4++; } 	// Количество специалистов от 55 до 59 лет
			}else{ if( !isset($str_16_4) ){ $str_16_4 = 0; } }
			
			if( $user_dob >= 60 ){ 
				if( isset($str_17_4) ){ $str_17_4++; }else{ $str_17_4 = 0; $str_17_4++; } 	// Количество специалистов от 60 и старше
			}else{ if( !isset($str_17_4) ){ $str_17_4 = 0; } }
			
			if( $value["user_gender"] == 2 ){ 
				if( isset($str_18_4) ){ $str_18_4++; }else{ $str_18_4 = 0; $str_18_4++; }	// Количество специалистов женщин
			}else{ if( !isset($str_18_4) ){ $str_18_4 = 0; } }
		}
		
		if( $value["user_category"] == 3 ) {
			/****Всего сотрудников****/
			if( isset($str_01_5) ){ $str_01_5++; }else{ $str_01_5 = 0; $str_01_5++; }		// Количество служащих
			
			/****Образование****/
			if( $value["user_education"] == 4 ){
				if( isset($str_02_5) ){ $str_02_5++; }else{ $str_02_5 = 0; $str_02_5++; } 	// Количество служащих с высшим образованием
			}else{ if( !isset($str_02_5) ){ $str_02_5 = 0; } }
			
			if( $value["user_education"] == 11 ){ 
				if( isset($str_03_5) ){ $str_03_5++; }else{ $str_03_5 = 0; $str_03_5++; } 	// Количество служащих с средним специальным образованием
			}else{ if( !isset($str_03_5) ){ $str_03_5 = 0; } }
			
			if( $value["user_education"] == 12 ){
				if( isset($str_04_5) ){ $str_04_5++; }else{ $str_04_5 = 0; $str_04_5++; } 	// Количество служащих с профессионально техническим образованием
			}else{ if( !isset($str_04_5) ){ $str_04_5 = 0; } }
			
			if( $value["user_education"] == 7 ){ 
				if( isset($str_05_5) ){ $str_05_5++; }else{ $str_05_5 = 0; $str_05_5++; } 	// Количество служащих с общим средним образованием
			}else{ if( !isset($str_05_5) ){ $str_05_5 = 0; } }
			
			if( $value["user_education"] == 8 ){ 
				if( isset($str_06_5) ){ $str_06_5++; }else{ $str_06_5 = 0; $str_06_5++; } 	// Количество служащих с общим базовым образованием
			}else{ if( !isset($str_06_5) ){ $str_06_5 = 0; } }
			
			/****Возвраст****/
			if( $user_dob < 16 ){ 
				if( isset($str_07_5) ){ $str_07_5++; }else{ $str_07_5 = 0; $str_07_5++; } 	// Количество служащих до 16 лет
			}else{ if( !isset($str_07_5) ){ $str_07_5 = 0; } }
			
			if( $user_dob >= 16 and $user_dob <= 17 ){ 
				if( isset($str_08_5) ){ $str_08_5++; }else{ $str_08_5 = 0; $str_08_5++; } 	// Количество служащих от 16 до 17 лет
			}else{ if( !isset($str_08_5) ){ $str_08_5 = 0; } }
			
			if( $user_dob >= 18 and $user_dob <= 24 ){ 
				if( isset($str_09_5) ){ $str_09_5++; }else{ $str_09_5 = 0; $str_09_5++; } 	// Количество служащих от 18 до 24 лет
			}else{ if( !isset($str_09_5) ){ $str_09_5 = 0; } }
			
			if( $user_dob >= 25 and $user_dob <= 29 ){ 
				if( isset($str_10_5) ){ $str_10_5++; }else{ $str_10_5 = 0; $str_10_5++; } 	// Количество служащих от 25 до 29 лет
			}else{ if( !isset($str_10_5) ){ $str_10_5 = 0; } }
			
			if( $user_dob == 30 ){ 
				if( isset($str_11_5) ){ $str_11_5++; }else{ $str_11_5 = 0; $str_11_5++; } 	// Количество служащих 30 лет
			}else{ if( !isset($str_11_5) ){ $str_11_5 = 0; } }
			
			if( $user_dob == 31 ){ 
				if( isset($str_12_5) ){ $str_12_5++; }else{ $str_12_5 = 0; $str_12_5++; } 	// Количество служащих 31 лет
			}else{ if( !isset($str_12_5) ){ $str_12_5 = 0; } }
			
			if( $user_dob >= 32 and $user_dob <= 39 ){ 
				if( isset($str_13_5) ){ $str_13_5++; }else{ $str_13_5 = 0; $str_13_5++; } 	// Количество служащих от 32 до 39 лет
			}else{ if( !isset($str_13_5) ){ $str_13_5 = 0; } }
			
			if( $user_dob >= 40 and $user_dob <= 49 ){ 
				if( isset($str_14_5) ){ $str_14_5++; }else{ $str_14_5 = 0; $str_14_5++; } 	// Количество служащих от 40 до 49 лет
			}else{ if( !isset($str_14_5) ){ $str_14_5 = 0; } }
			
			if( $user_dob >= 50 and $user_dob <= 54 ){ 
				if( isset($str_15_5) ){ $str_15_5++; }else{ $str_15_5 = 0; $str_15_5++; } 	// Количество служащих от 50 до 54 лет
			}else{ if( !isset($str_15_5) ){ $str_15_5 = 0; } }
			
			if( $user_dob >= 55 and $user_dob <= 59 ){ 
				if( isset($str_16_5) ){ $str_16_5++; }else{ $str_16_5 = 0; $str_16_5++; } 	// Количество служащих от 55 до 59 лет
			}else{ if( !isset($str_16_5) ){ $str_16_5 = 0; } }
			
			if( $user_dob >= 60 ){ 
				if( isset($str_17_5) ){ $str_17_5++; }else{ $str_17_5 = 0; $str_17_5++; } 	// Количество служащих от 60 и старше
			}else{ if( !isset($str_17_5) ){ $str_17_5 = 0; } }
			
			if( $value["user_gender"] == 2 ){ 
				if( isset($str_18_5) ){ $str_18_4++; }else{ $str_18_5 = 0; $str_18_5++; }	// Количество служащих женщин
			}else{ if( !isset($str_18_5) ){ $str_18_5 = 0; } }
		}
		
		if( $value["user_category"] == 4 ){
			/****Всего сотрудников****/
			if( isset($str_01_6) ){ $str_01_6++; }else{ $str_01_6 = 0; $str_01_6++; }		// Количество работники
			
			/****Образование****/
			if( $value["user_education"] == 4 ){
				if( isset($str_02_6) ){ $str_02_6++; }else{ $str_02_6 = 0; $str_02_6++; } 	// Количество работников с высшим образованием
			}else{ if( !isset($str_02_6) ){ $str_02_6 = 0; } }
			
			if( $value["user_education"] == 11 ){ 
				if( isset($str_03_6) ){ $str_03_6++; }else{ $str_03_6 = 0; $str_03_6++; } 	// Количество работников с средним специальным образованием
			}else{ if( !isset($str_03_6) ){ $str_03_6 = 0; } }
			
			if( $value["user_education"] == 12 ){
				if( isset($str_04_6) ){ $str_04_6++; }else{ $str_04_6 = 0; $str_04_6++; } 	// Количество работников с профессионально техническим образованием
			}else{ if( !isset($str_04_6) ){ $str_04_6 = 0; } }
			
			if( $value["user_education"] == 7 ){ 
				if( isset($str_05_6) ){ $str_05_6++; }else{ $str_05_6 = 0; $str_05_6++; } 	// Количество работников с общим средним образованием
			}else{ if( !isset($str_05_6) ){ $str_05_6 = 0; } }
			
			if( $value["user_education"] == 8 ){ 
				if( isset($str_06_6) ){ $str_06_6++; }else{ $str_06_6 = 0; $str_06_6++; } 	// Количество работников с общим базовым образованием
			}else{ if( !isset($str_06_6) ){ $str_06_6 = 0; } }
			
			/****Возвраст****/
			if( $user_dob < 16 ){ 
				if( isset($str_07_6) ){ $str_07_6++; }else{ $str_07_6 = 0; $str_07_6++; } 	// Количество работников до 16 лет
			}else{ if( !isset($str_07_6) ){ $str_07_6 = 0; } }
			
			if( $user_dob >= 16 and $user_dob <= 17 ){ 
				if( isset($str_08_6) ){ $str_08_6++; }else{ $str_08_6 = 0; $str_08_6++; } 	// Количество работников от 16 до 17 лет
			}else{ if( !isset($str_08_6) ){ $str_08_6 = 0; } }
			
			if( $user_dob >= 18 and $user_dob <= 24 ){ 
				if( isset($str_09_6) ){ $str_09_6++; }else{ $str_09_6 = 0; $str_09_6++; } 	// Количество работников от 18 до 24 лет
			}else{ if( !isset($str_09_6) ){ $str_09_6 = 0; } }
			
			if( $user_dob >= 25 and $user_dob <= 29 ){ 
				if( isset($str_10_6) ){ $str_10_6++; }else{ $str_10_6 = 0; $str_10_6++; } 	// Количество работников от 25 до 29 лет
			}else{ if( !isset($str_10_6) ){ $str_10_6 = 0; } }
			
			if( $user_dob == 30 ){ 
				if( isset($str_11_6) ){ $str_11_6++; }else{ $str_11_6 = 0; $str_11_6++; } 	// Количество работников 30 лет
			}else{ if( !isset($str_11_6) ){ $str_11_6 = 0; } }
			
			if( $user_dob == 31 ){ 
				if( isset($str_12_6) ){ $str_12_6++; }else{ $str_12_6 = 0; $str_12_6++; } 	// Количество работников 31 лет
			}else{ if( !isset($str_12_6) ){ $str_12_6 = 0; } }
			
			if( $user_dob >= 32 and $user_dob <= 39 ){ 
				if( isset($str_13_6) ){ $str_13_6++; }else{ $str_13_6 = 0; $str_13_6++; } 	// Количество работников от 32 до 39 лет
			}else{ if( !isset($str_13_6) ){ $str_13_6 = 0; } }
			
			if( $user_dob >= 40 and $user_dob <= 49 ){ 
				if( isset($str_14_6) ){ $str_14_6++; }else{ $str_14_6 = 0; $str_14_6++; } 	// Количество работников от 40 до 49 лет
			}else{ if( !isset($str_14_6) ){ $str_14_6 = 0; } }
			
			if( $user_dob >= 50 and $user_dob <= 54 ){ 
				if( isset($str_15_6) ){ $str_15_6++; }else{ $str_15_6 = 0; $str_15_6++; } 	// Количество работников от 50 до 54 лет
			}else{ if( !isset($str_15_6) ){ $str_15_6 = 0; } }
			
			if( $user_dob >= 55 and $user_dob <= 59 ){ 
				if( isset($str_16_6) ){ $str_16_6++; }else{ $str_16_6 = 0; $str_16_6++; } 	// Количество работников от 55 до 59 лет
			}else{ if( !isset($str_16_6) ){ $str_16_6 = 0; } }
			
			if( $user_dob >= 60 ){ 
				if( isset($str_17_6) ){ $str_17_6++; }	// Количество работников от 60 и старше
			}
			
			if( $value["user_gender"] == 2 ){ 
				if( isset($str_18_6) ){ $str_18_6++; }else{ $str_18_6 = 0; $str_18_6++; }	// Количество работников женщин
			}else{ if( !isset($str_18_6) ){ $str_18_6 = 0; } }
		}

		/****Женщины****/
		if( $value["user_gender"] == 2 ){
			/****Образование****/
			if( isset($str_01_7) ){ $str_01_7++; }else{ $str_01_7 = 0; $str_01_7++; } 		// Количество женщин
			
			if( $value["user_education"] == 4 ){ 
				if( isset($str_02_7) ){ $str_02_7++; }else{ $str_02_7 = 0; $str_02_7++; } 	// Количество женщин с высшим образованием 
			}else{ if( !isset($str_02_7) ){ $str_02_7 = 0; } }
			
			if( $value["user_education"] == 11 ){ 
				if( isset($str_03_7) ){ $str_03_7++; }else{ $str_03_7 = 0; $str_03_7++; }	// Количество женщин с средним специальным образованием 
			}else{ if( !isset($str_03_7) ){ $str_03_7 = 0; } }
			
			if( $value["user_education"] == 12 ){ 
				if( isset($str_04_7) ){ $str_04_7++; }else{ $str_04_7 = 0; $str_04_7++; } 	// Количество женщин с профессионально техническим образованием 
			}else{ if( !isset($str_04_7) ){ $str_04_7 = 0; } }
			
			if( $value["user_education"] == 7 ){ 
				if( isset($str_05_7) ){ $str_05_7++; }else{ $str_05_7 = 0; $str_05_7++; } 	// Количество женщин с общим средним образованием
			}else{ if( !isset($str_05_7) ){ $str_05_7 = 0; } }
			
			if( $value["user_education"] == 8 ){ 
				if( isset($str_06_7) ){ $str_06_7++; }else{ $str_06_7 = 0; $str_06_7++; } 	// Количество женщин с общим базовым образованием
			}else{ if( !isset($str_06_7) ){ $str_06_7 = 0; } }
			
			/****Возвраст****/
			if( $user_dob < 16 ){ 
				if( isset($str_07_7) ){ $str_07_7++; }else{ $str_07_7 = 0; $str_07_7++; } 	// Количество служащих до 16 лет
			}else{ if( !isset($str_07_7) ){ $str_07_7 = 0; } }
			
			if( $user_dob >= 16 and $user_dob <= 17 ){ 
				if( isset($str_08_7) ){ $str_08_7++; }else{ $str_08_7 = 0; $str_08_7++; } 	// Количество служащих от 16 до 17 лет
			}else{ if( !isset($str_08_7) ){ $str_08_7 = 0; } }
			
			if( $user_dob >= 18 and $user_dob <= 24 ){ 
				if( isset($str_09_7) ){ $str_09_7++; }else{ $str_09_7 = 0; $str_09_7++; } 	// Количество служащих от 18 до 24 лет
			}else{ if( !isset($str_09_7) ){ $str_09_7 = 0; } }
			
			if( $user_dob >= 25 and $user_dob <= 29 ){ 
				if( isset($str_10_7) ){ $str_10_7++; }else{ $str_10_7 = 0; $str_10_7++; } 	// Количество служащих от 25 до 29 лет
			}else{ if( !isset($str_10_7) ){ $str_10_7 = 0; } }
			
			if( $user_dob == 30 ){ 
				if( isset($str_11_7) ){ $str_11_7++; }else{ $str_11_7 = 0; $str_11_7++; } 	// Количество служащих 30 лет
			}else{ if( !isset($str_11_7) ){ $str_11_7 = 0; } }
			
			if( $user_dob == 31 ){ 
				if( isset($str_12_7) ){ $str_12_7++; }else{ $str_12_7 = 0; $str_12_7++; } 	// Количество служащих 31 лет
			}else{ if( !isset($str_12_7) ){ $str_12_7 = 0; } }
			
			if( $user_dob >= 32 and $user_dob <= 39 ){ 
				if( isset($str_13_7) ){ $str_13_7++; }else{ $str_13_7 = 0; $str_13_7++; } 	// Количество служащих от 32 до 39 лет
			}else{ if( !isset($str_13_7) ){ $str_13_7 = 0; } }
			
			if( $user_dob >= 40 and $user_dob <= 49 ){ 
				if( isset($str_14_7) ){ $str_14_7++; }else{ $str_14_7 = 0; $str_14_7++; } 	// Количество служащих от 40 до 49 лет
			}else{ if( !isset($str_14_7) ){ $str_14_7 = 0; } }
			
			if( $user_dob >= 50 and $user_dob <= 54 ){ 
				if( isset($str_15_7) ){ $str_15_7++; }else{ $str_15_7 = 0; $str_15_7++; } 	// Количество служащих от 50 до 54 лет
			}else{ if( !isset($str_15_7) ){ $str_15_7 = 0; } }
			
			if( $user_dob >= 55 and $user_dob <= 59 ){ 
				if( isset($str_16_7) ){ $str_16_7++; }else{ $str_16_7 = 0; $str_16_7++; } 	// Количество служащих от 55 до 59 лет
			}else{ if( !isset($str_16_7) ){ $str_16_7 = 0; } }
			
			if( $user_dob >= 60 ){ 
				if( isset($str_17_7) ){ $str_17_7++; }else{ $str_17_7 = 0; $str_17_7++; } 	// Количество служащих от 60 и старше
			}else{ if( !isset($str_17_7) ){ $str_17_7 = 0; } }
		}
		
		/****Юридическое лицо****/
		if( $value["user_education"] == 4 ){ 
			if( $value["user_function"] == 1 ){ 
				if( isset($str_02_8) ){ $str_02_8++; }else{ $str_02_8 = 0; $str_02_8++; } 	// Количество руководителей юридического лица с высшим - Директор 
				
				/****Возвраст****/
				if( $user_dob < 16 ){ 
					if( isset($str_07_8) ){ $str_07_8++; }else{ $str_07_8 = 0; $str_07_8++; } 	// Количество руководителей юридического лица с высшим - Директор до 16 лет
				}else{ if( !isset($str_07_8) ){ $str_07_8 = 0; } }
				
				if( $user_dob >= 16 and $user_dob <= 17 ){ 
					if( isset($str_08_8) ){ $str_08_8++; }else{ $str_08_8 = 0; $str_08_8++; } 	// Количество руководителей юридического лица с высшим - Директор от 16 до 17 лет
				}else{ if( !isset($str_08_8) ){ $str_08_8 = 0; } }
				
				if( $user_dob >= 18 and $user_dob <= 24 ){ 
					if( isset($str_09_8) ){ $str_09_8++; }else{ $str_09_8 = 0; $str_09_8++; } 	// Количество руководителей юридического лица с высшим - Директор от 18 до 24 лет
				}else{ if( !isset($str_09_8) ){ $str_09_8 = 0; } }
				
				if( $user_dob >= 25 and $user_dob <= 29 ){ 
					if( isset($str_10_8) ){ $str_10_8++; }else{ $str_10_8 = 0; $str_10_8++; } 	// Количество руководителей юридического лица с высшим - Директор от 25 до 29 лет
				}else{ if( !isset($str_10_8) ){ $str_10_8 = 0; } }
				
				if( $user_dob == 30 ){ 
					if( isset($str_11_8) ){ $str_11_8++; }else{ $str_11_8 = 0; $str_11_8++; } 	// Количество руководителей юридического лица с высшим - Директор 30 лет
				}else{ if( !isset($str_11_8) ){ $str_11_8 = 0; } }
				
				if( $user_dob == 31 ){ 
					if( isset($str_12_8) ){ $str_12_8++; }else{ $str_12_8 = 0; $str_12_8++; } 	// Количество руководителей юридического лица с высшим - Директор 31 лет
				}else{ if( !isset($str_12_8) ){ $str_12_8 = 0; } }
				
				if( $user_dob >= 32 and $user_dob <= 39 ){ 
					if( isset($str_13_8) ){ $str_13_8++; }else{ $str_13_8 = 0; $str_13_8++; } 	// Количество руководителей юридического лица с высшим - Директор от 32 до 39 лет
				}else{ if( !isset($str_13_8) ){ $str_13_8 = 0; } }
				
				if( $user_dob >= 40 and $user_dob <= 49 ){ 
					if( isset($str_14_8) ){ $str_14_8++; }else{ $str_14_8 = 0; $str_14_8++; } 	// Количество руководителей юридического лица с высшим - Директор от 40 до 49 лет
				}else{ if( !isset($str_14_8) ){ $str_14_8 = 0; } }
				
				if( $user_dob >= 50 and $user_dob <= 54 ){ 
					if( isset($str_15_8) ){ $str_15_8++; }else{ $str_15_8 = 0; $str_15_8++; } 	// Количество руководителей юридического лица с высшим - Директор от 50 до 54 лет
				}else{ if( !isset($str_15_8) ){ $str_15_8 = 0; } }
				
				if( $user_dob >= 55 and $user_dob <= 59 ){ 
					if( isset($str_16_8) ){ $str_16_8++; }else{ $str_16_8 = 0; $str_16_8++; } 	// Количество руководителей юридического лица с высшим - Директор от 55 до 59 лет
				}else{ if( !isset($str_16_8) ){ $str_16_8 = 0; } }
				
				if( $user_dob >= 60 ){ 
					if( isset($str_17_8) ){ $str_17_8++; }else{ $str_17_8 = 0; $str_17_8++; } 	// Количество руководителей юридического лица с высшим - Директор от 60 и старше
				}else{ if( !isset($str_17_8) ){ $str_17_8 = 0; } }
			
			}else{ if( !isset($str_02_8) ){ $str_02_8 = 0; } } 
		}
		
		if( $value["user_education"] == 11 ){ 
			if( $value["user_function"] == 1 ){ 
				if( isset($str_03_8) ){ $str_03_8++; }else{ $str_03_8 = 0; $str_03_8++; }  	// Количество руководителей юридического лица с средне специальным - Директор 
			}else{ if( !isset($str_03_8) ){ $str_03_8 = 0; } } 
		}
		
		if( $value["user_education"] == 12 ){ 
			if( $value["user_function"] == 1 ){ 
				if( isset($str_04_8) ){ $str_04_8++; }else{ $str_04_8 = 0; $str_04_8++; } 	// Количество руководителей юридического лица с профиссиально техническим - Директор 
			}else{ if( !isset($str_04_8) ){ $str_04_8 = 0; } }  
		}
		
		if( $value["user_education"] == 7 ){ 
			if( $value["user_function"] == 1 ){ 
				if( isset($str_05_8) ){ $str_05_8++; }else{ $str_05_8 = 0; $str_05_8++; } 	// Количество руководителей юридического лица с общим средним - Директор
			}else{ if( !isset($str_025_8) ){ $str_05_8 = 0; } } 
		}
		
		if( $value["user_education"] == 8 ){ 
			if( $value["user_function"] == 1 ){ 
				if( isset($str_06_8) ){ $str_06_8++; }else{ $str_06_8 = 0; $str_06_8++; }  	// Количество руководителей юридического лица с общим базовым - Директор 
			}else{ if( !isset($str_06_8) ){ $str_06_8 = 0; } }  
		}
	}
	
	$str_01_2 = $str_01_3 + $str_01_4 + $str_01_5; 	//Общее количество служащих
	$str_01_1 = $str_01_2 + $str_01_6; 				//Численность работников
	
	$str_02_2 = $str_02_3 + $str_02_4 + $str_02_5; 	//Общее количество служащих с высшим образованием
	$str_02_1 = $str_02_2 + $str_02_6; 				//Численность работников с высшим образованием
	
	$str_03_2 = $str_03_3 + $str_03_4 + $str_03_5;  //Общее количество служащих с средне специальным
	$str_03_1 = $str_03_2 + $str_03_6; 				//Численность работников с средне специальным
	
	$str_04_2 = $str_04_3 + $str_04_4 + $str_04_5; 	//Общее количество служащих с профессионально техническим
	$str_04_1 = $str_04_2 + $str_04_6; 				//Численность работников с профессионально техническим
	
	$str_05_2 = $str_05_3 + $str_05_4 + $str_05_5; 	//Общее количество служащих с общим средним
	$str_05_1 = $str_05_2 + $str_05_6; 				//Численность работников с общим средним
	
	$str_06_2 = $str_06_3 + $str_06_4 + $str_06_5; 	//Общее количество служащих с общим базовым
	$str_06_1 = $str_06_2 + $str_06_6; 				//Численность работников с общим базовым
	
	$str_07_2 = $str_07_3 + $str_07_4 + $str_07_5; 	//Общее количество служащих до 16 лет
	$str_07_1 = $str_07_2 + $str_07_6; 				//Численность работников до 16 лет
	
	$str_08_2 = $str_08_3 + $str_08_4 + $str_08_5; 	//Общее количество служащих от 16 до 17 лет
	$str_08_1 = $str_08_2 + $str_08_6; 				//Численность работников от 16 до 17 лет
	
	$str_09_2 = $str_09_3 + $str_09_4 + $str_09_5; 	//Общее количество служащих от 18 до 24 лет
	$str_09_1 = $str_09_2 + $str_09_6; 				//Численность работников от 18 до 24 лет
	
	$str_10_2 = $str_10_3 + $str_10_4 + $str_10_5; 	//Общее количество служащих от 25 до 29 лет
	$str_10_1 = $str_10_2 + $str_10_6; 				//Численность работников от 25 до 29 лет
	
	$str_11_2 = $str_11_3 + $str_11_4 + $str_11_5; 	//Общее количество служащих 30 лет
	$str_11_1 = $str_11_2 + $str_11_6; 				//Численность работников 30 лет
	
	$str_12_2 = $str_12_3 + $str_12_4 + $str_12_5; 	//Общее количество служащих 31 лет
	$str_12_1 = $str_12_2 + $str_12_6; 				//Численность работников 31 лет
	
	$str_13_2 = $str_13_3 + $str_13_4 + $str_13_5; 	//Общее количество служащих от 32 до 39 лет
	$str_13_1 = $str_13_2 + $str_13_6; 				//Численность работников от32 до 39 лет
	
	$str_14_2 = $str_14_3 + $str_14_4 + $str_14_5; 	//Общее количество служащих от 40 до 49 лет
	$str_14_1 = $str_14_2 + $str_14_6; 				//Численность работников от 40 до 49 лет
	
	$str_15_2 = $str_15_3 + $str_15_4 + $str_15_5; 	//Общее количество служащих от 50 до 54 лет
	$str_15_1 = $str_15_2 + $str_15_6; 				//Численность работников от 50 до 54 лет
	
	$str_16_2 = $str_16_3 + $str_16_4 + $str_16_5; 	//Общее количество служащих от 55 до 59 лет
	$str_16_1 = $str_16_2 + $str_16_6; 				//Численность работников от 55 до 59 лет
	
	$str_17_2 = $str_17_3 + $str_17_4 + $str_17_5; 	//Общее количество служащих от 60 лет
	$str_17_1 = $str_17_2 + $str_17_6; 				//Численность работников от 60 лет
	
	$str_18_2 = $str_18_3 + $str_18_4 + $str_18_5; 	//Общее количество служащих женщин
	$str_18_1 = $str_18_2 + $str_18_6; 				//Численность работников женщин
	
	$arrStatistic = [
		"str_01_1" =>  $str_01_1, "str_01_2" =>  $str_01_2, "str_01_3" =>  $str_01_3, "str_01_4" =>  $str_01_4, "str_01_5" =>  $str_01_5, "str_01_6" =>  $str_01_6, "str_01_7" =>  $str_01_7, "str_01_8" =>  $str_01_8,
		"str_02_1" =>  $str_02_1, "str_02_2" =>  $str_02_2, "str_02_3" =>  $str_02_3, "str_02_4" =>  $str_02_4, "str_02_5" =>  $str_02_5, "str_02_6" =>  $str_02_6, "str_02_7" =>  $str_02_7, "str_02_8" =>  $str_02_8,
		"str_03_1" =>  $str_03_1, "str_03_2" =>  $str_03_2, "str_03_3" =>  $str_03_3, "str_03_4" =>  $str_03_4, "str_03_5" =>  $str_03_5, "str_03_6" =>  $str_03_6, "str_03_7" =>  $str_03_7, "str_03_8" =>  $str_03_8,
		"str_04_1" =>  $str_04_1, "str_04_2" =>  $str_04_2, "str_04_3" =>  $str_04_3, "str_04_4" =>  $str_04_4, "str_04_5" =>  $str_04_5, "str_04_6" =>  $str_04_6, "str_04_7" =>  $str_04_7, "str_04_8" =>  $str_04_8,
		"str_05_1" =>  $str_05_1, "str_05_2" =>  $str_05_2, "str_05_3" =>  $str_05_3, "str_05_4" =>  $str_05_4, "str_05_5" =>  $str_05_5, "str_05_6" =>  $str_05_6, "str_05_7" =>  $str_05_7, "str_05_8" =>  $str_05_8,
		"str_06_1" =>  $str_06_1, "str_06_2" =>  $str_06_2, "str_06_3" =>  $str_06_3, "str_06_4" =>  $str_06_4, "str_06_5" =>  $str_06_5, "str_06_6" =>  $str_06_6, "str_06_7" =>  $str_06_7, "str_06_8" =>  $str_06_8,
		"str_07_1" =>  $str_07_1, "str_07_2" =>  $str_07_2, "str_07_3" =>  $str_07_3, "str_07_4" =>  $str_07_4, "str_07_5" =>  $str_07_5, "str_07_6" =>  $str_07_6, "str_07_7" =>  $str_07_7, "str_07_8" =>  $str_07_8,
		"str_08_1" =>  $str_08_1, "str_08_2" =>  $str_08_2, "str_08_3" =>  $str_08_3, "str_08_4" =>  $str_08_4, "str_08_5" =>  $str_08_5, "str_08_6" =>  $str_08_6, "str_08_7" =>  $str_08_7, "str_08_8" =>  $str_08_8,
		"str_09_1" =>  $str_09_1, "str_09_2" =>  $str_09_2, "str_09_3" =>  $str_09_3, "str_09_4" =>  $str_09_4, "str_09_5" =>  $str_09_5, "str_09_6" =>  $str_09_6, "str_09_7" =>  $str_09_7, "str_09_8" =>  $str_09_8,
		"str_10_1" =>  $str_10_1, "str_10_2" =>  $str_10_2, "str_10_3" =>  $str_10_3, "str_10_4" =>  $str_10_4, "str_10_5" =>  $str_10_5, "str_10_6" =>  $str_10_6, "str_10_7" =>  $str_10_7, "str_10_8" =>  $str_10_8,
		"str_11_1" =>  $str_11_1, "str_11_2" =>  $str_11_2, "str_11_3" =>  $str_11_3, "str_11_4" =>  $str_11_4, "str_11_5" =>  $str_11_5, "str_11_6" =>  $str_11_6, "str_11_7" =>  $str_11_7, "str_11_8" =>  $str_11_8,
		"str_12_1" =>  $str_12_1, "str_12_2" =>  $str_12_2, "str_12_3" =>  $str_12_3, "str_12_4" =>  $str_12_4, "str_12_5" =>  $str_12_5, "str_12_6" =>  $str_12_6, "str_12_7" =>  $str_12_7, "str_12_8" =>  $str_12_8,
		"str_13_1" =>  $str_13_1, "str_13_2" =>  $str_13_2, "str_13_3" =>  $str_13_3, "str_13_4" =>  $str_13_4, "str_13_5" =>  $str_13_5, "str_13_6" =>  $str_13_6, "str_13_7" =>  $str_13_7, "str_13_8" =>  $str_13_8,
		"str_14_1" =>  $str_14_1, "str_14_2" =>  $str_14_2, "str_14_3" =>  $str_14_3, "str_14_4" =>  $str_14_4, "str_14_5" =>  $str_14_5, "str_14_6" =>  $str_14_6, "str_14_7" =>  $str_14_7, "str_14_8" =>  $str_14_8,
		"str_15_1" =>  $str_15_1, "str_15_2" =>  $str_15_2, "str_15_3" =>  $str_15_3, "str_15_4" =>  $str_15_4, "str_15_5" =>  $str_15_5, "str_15_6" =>  $str_15_6, "str_15_7" =>  $str_15_7, "str_15_8" =>  $str_15_8,
		"str_16_1" =>  $str_16_1, "str_16_2" =>  $str_16_2, "str_16_3" =>  $str_16_3, "str_16_4" =>  $str_16_4, "str_16_5" =>  $str_16_5, "str_16_6" =>  $str_16_6, "str_16_7" =>  $str_16_7, "str_16_8" =>  $str_16_8,
		"str_17_1" =>  $str_17_1, "str_17_2" =>  $str_17_2, "str_17_3" =>  $str_17_3, "str_17_4" =>  $str_17_4, "str_17_5" =>  $str_17_5, "str_17_6" =>  $str_17_6, "str_17_7" =>  $str_17_7, "str_17_8" =>  $str_17_8,
		"str_18_1" =>  $str_18_1, "str_18_2" =>  $str_18_2, "str_18_3" =>  $str_18_3, "str_18_4" =>  $str_18_4, "str_18_5" =>  $str_18_5, "str_18_6" =>  $str_18_6, "str_18_7" =>  $str_18_7, "str_18_8" =>  $str_18_8
	];
	
	return $arrStatistic;
}

switch( $_POST['action'] ){
	case 'start_load':
		/***Таблица сотрудников***/
		$select_user = $personal->show_user_full();
		if( !empty($select_user) ){
			$success["users_table"] = show_user($select_user);
		}
		else{ $success["users_table"] = '<tr><td style="text-align: center;" colspan="8">Сотрудники не найдены. Обратитесь в службу поддержки.</td></tr>'; }
		
		/****Пол***/
		$select_gender_list = $personal->show_gender_list();
		if( !empty($select_gender_list) ){
			$success["gender_list"] = show_gender_list($select_gender_list);
		}
		else{ $success["gender_list"] = '<option value=""></option>'; }
		
		/***Должность***/
		$select_function_list = $personal->show_function_list();
		if( !empty($select_function_list) ){
			$success["function_list"] = show_function_list($select_function_list);
		}
		else{ $success["function_list"] = '<option value=""></option>'; }
		
		/***Образование***/
		$select_education_list = $personal->show_education_list();
		if( !empty($select_education_list) ){
			$success["education_list"] = show_education_list($select_education_list);
		}
		else{ $success["education_list"] = '<option value=""></option>'; }
		
		/***Подразделение***/
		$select_subdivision_list = $personal->show_subdivision_list();
		if( !empty($select_subdivision_list) ){
			$success["subdivision_list"] = show_subdivision_list($select_subdivision_list);
		}
		else{ $success["subdivision_list"] = '<option value=""></option>'; }
		
		/***Категория сотрудников***/
		$select_category_list = $personal->show_category_list();
		if( !empty($select_category_list) ){
			$success["category_list"] = show_category_list($select_category_list);
		}
		else{ $success["category_list"] = '<option value=""></option>'; }

		$success["statistic_data"] = statistic_data($select_user);
		
		/*** Таблица по контрактам ***/
		$select_contracts = $personal->show_contracts_full();
		if( !empty($select_contracts) )
		{
			$returnHtmlContracts = show_contracts($select_contracts);
			$success["contracts_table"] = $returnHtmlContracts["html"];
			$success["fioContract"] = $returnHtmlContracts["fioContract"];
		}
		else
		{ 
			$success["contracts_table"] = '<tr><td style="text-align: center;" colspan="8">Сотрудники не найдены. Обратитесь в службу поддержки.</td></tr>'; 
		}
		
		echo ajax_response($success, $error);
	break;
	
	case 'form-add-user':
		parse_str($_POST['data'], $row_form);
		$orig_data = ["user_f", "user_i", "user_o", "user_dob", "user_receipt", "user_gender", "user_education", "user_function", "user_subdivision", "user_category"];
		
	//	$data_db[":fio"] = $row_form["user_f"];
		
		for( $i=0; $i<count($row_form); $i++ ){
			$data_db[":" . $orig_data[$i]] = $row_form[$orig_data[$i]];
		}
		
		$last_id = $personal->create_user($data_db);
		if( !empty($last_id) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Сотрудник успешно добавлен.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }

		echo ajax_response($success, $error);
	break;
	
	case 'form-update-user':
		parse_str($_POST['data'], $row_form);
		$orig_data = ["user_id", "user_f", "user_i", "user_o", "user_dob", "user_receipt", "user_gender", "user_education", "user_function", "user_subdivision", "user_category"];
		for( $i=0; $i<count($row_form); $i++ ){
			$data_db[":" . $orig_data[$i]] = $row_form[$orig_data[$i]];
		}
		
		$last_id = $personal->update_user($data_db);
		if( !empty($last_id) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные сотрудника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }

		echo ajax_response($success, $error);
	break;
	
	case 'form-update-contract':
		parse_str($_POST['data'], $row_form);
		$orig_data = ["user_id", "user_f", "user_i", "user_o", "contract_num", "contract_date_begin", "contract_date_end", "contract_extend_begin", "contract_extend_end"];
		for( $i=0; $i<count($row_form); $i++ ){
			$data_db[":" . $orig_data[$i]] = $row_form[$orig_data[$i]];
		}
		
		$last_id = $personal->update_contract($data_db);
		if( !empty($last_id) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные сотрудника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }

		echo ajax_response($success, $error);
	break;
	
	case 'delete_user':
		$delete_data = $personal->delete_user([":user_id" => $_POST['data']]);
		$success = "Удаление сотрудника успешно произведено.";
		
		echo ajax_response($success, $error);
	break;
	
	case 'edit_user':
		$edit_data = $personal->edit_user([":user_id" => $_POST['data']]);
		if( !empty($edit_data) ){
			$success = $edit_data;
		}
		else{ $error = "Ошибка. Обратитесь в службу поддержки."; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'edit_contract':
		$edit_contract = $personal->edit_contract([":user_id" => $_POST['data']]);
		if( !empty($edit_contract) ){
			$success = $edit_contract;
		}
		else{ $error = "Ошибка. Обратитесь в службу поддержки."; }
		
		echo ajax_response($success, $error);
	break;

	case 'logout_user':
		$auth_users->logout();
		if( isset($_SESSIO['user_id']) ){ $error = "Ошибка. Обратитесь в службу поддержки."; }
		
		echo ajax_response($success, $error);
	break;
}
?>