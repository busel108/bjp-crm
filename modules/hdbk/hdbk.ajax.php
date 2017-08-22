<?php

session_start();

include_once "hdbk.db.php";
$hdbk = new hdbk();
$success = ""; $error = ""; 

function ajax_response($success, $error){
	$arrMsg = array(
		"success" => $success, 
		"error" => $error
	);
	
	$arrMsgEncode = json_encode($arrMsg);
	return $arrMsgEncode;
}

function show_types_of_jobs_full($data, $html=""){
	$html .= '<table class="table table-hover table-bordered" style="margin-bottom: 0px;">';
	
	foreach( $data as $value ){
		$html .= '<tr>
			<td style="padding-left: 15px;">'.$value["type_name"].'</td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default edit-hdbk" data-id='.$value["id"].' data-table-name="hdbk_types_of_jobs" data-action="form_edit_types_of_jobs_full" data-toggle="modal" data-target="#modal-edit-hdbk"><span class="glyphicon glyphicon-edit"></span></button></td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default delete-hdbk" data-id='.$value["id"].' data-table-name="hdbk_types_of_jobs" data-action="form_delete_types_of_jobs_full" data-toggle="modal" data-target="#modal-delete-hdbk"><span class="glyphicon glyphicon-trash"></span></button></td></tr>
		</tr>';
	}
	
	$html .= '</table>';
	
	return $html;
}

function form_edit_types_of_jobs_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="type_name" style="font-size: 85%;">Полное название вида работы:</label>
		<input class="form-control" style="width: 100%;" type="text" name="type_name" value="'.$data[0]["type_name"].'">
	</div>

	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="type_name_abbreviation" style="font-size: 85%;">Сокращённое название вида работы:</label>
		<input class="form-control" style="width: 100%;" type="text" name="type_name_abbreviation" value="'.$data[0]["type_name_abbreviation"].'">
	</div>';
			
	return $html;
}

function form_delete_types_of_jobs_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<p>Вы действительно хотите удалить запись '.$data[0]["type_name"].'?</p>
	</div>';
			
	return $html;
}

function show_education_full($data, $html=""){
	$html .= '<table class="table table-hover table-bordered" style="margin-bottom: 0px;">';
	
	foreach( $data as $value ){
		$html .= '<tr>
			<td style="padding-left: 15px;">'.$value["education_name"].'</td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default edit-hdbk" data-id='.$value["id"].' data-table-name="hdbk_user_education" data-action="form_edit_education_full" data-toggle="modal" data-target="#modal-edit-hdbk"><span class="glyphicon glyphicon-edit"></span></button></td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default delete-hdbk" data-id='.$value["id"].' data-table-name="hdbk_user_education" data-action="form_delete_education_full" data-toggle="modal" data-target="#modal-delete-hdbk"><span class="glyphicon glyphicon-trash"></span></button></td></tr>
		</tr>';
	}
	
	$html .= '</table>';
	
	return $html;
}

function form_edit_education_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="education_name" style="font-size: 85%;">Образование:</label>
		<input class="form-control" style="width: 100%;" type="text" name="education_name" value="'.$data[0]["education_name"].'">
	</div>';
			
	return $html;
}

function form_delete_education_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<p>Вы действительно хотите удалить запись '.$data[0]["education_name"].'?</p>
	</div>';
			
	return $html;
}

function show_function_full($data, $html=""){
	$html .= '<table class="table table-hover table-bordered" style="margin-bottom: 0px;">';
	
	foreach( $data as $value ){
		$html .= '<tr>
			<td style="padding-left: 15px;">'.$value["function_name"].'</td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default edit-hdbk" data-id='.$value["id"].' data-table-name="hdbk_user_function" data-action="form_edit_function_full" data-toggle="modal" data-target="#modal-edit-hdbk"><span class="glyphicon glyphicon-edit"></span></button></td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default delete-hdbk" data-id='.$value["id"].' data-table-name="hdbk_user_function" data-action="form_delete_function_full" data-toggle="modal" data-target="#modal-delete-hdbk"><span class="glyphicon glyphicon-trash"></span></button></td></tr>
		</tr>';
	}
	
	$html .= '</table>';
	
	return $html;
}

function form_edit_function_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="function_name" style="font-size: 85%;">Должность:</label>
		<input class="form-control" style="width: 100%;" type="text" name="function_name" value="'.$data[0]["function_name"].'">
	</div>';
			
	return $html;
}

function form_delete_function_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<p>Вы действительно хотите удалить запись '.$data[0]["function_name"].'?</p>
	</div>';
			
	return $html;
}

function show_subdivision_full($data, $html=""){
	$html .= '<table class="table table-hover table-bordered" style="margin-bottom: 0px;">
	<thead style="background: rgba(0,0,0,.3);">
		<th style="text-align: center;">Наименование</th>
		<th style="text-align: center;">Участие в проектированиии</th>
		<th><span class="glyphicon glyphicon-edit"></span></th>
		<th><span class="glyphicon glyphicon-trash"></span></th>
	</thead><tbody>';
	
	foreach( $data as $value ){
		$vl = $value["part_in_design"]=="1"?"ДА":"НЕТ";
		$html .= '<tr>
			<td style="padding-left: 15px;">'.$value["subdivision_name"].'</td>
			<td style="padding-left: 15px; text-align: center;">'.$vl.'</td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default edit-hdbk" data-id='.$value["id"].' data-table-name="hdbk_user_subdivision" data-action="form_edit_subdivision_full" data-toggle="modal" data-target="#modal-edit-hdbk"><span class="glyphicon glyphicon-edit"></span></button></td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default delete-hdbk" data-id='.$value["id"].' data-table-name="hdbk_user_subdivision" data-action="form_delete_subdivision_full" data-toggle="modal" data-target="#modal-delete-hdbk"><span class="glyphicon glyphicon-trash"></span></button></td></tr>
		</tr>';
	}
	
	$html .= '</tbody></table>';
	
	return $html;
}

function form_edit_subdivision_full($data, $html=""){
	$check = $data[0]["part_in_design"]==1?"checked":"";
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="type_name" style="font-size: 85%;">Подразделение:</label>
		<input class="form-control" style="width: 100%;" type="text" name="subdivision_name" value="'.$data[0]["subdivision_name"].'">
	</div>
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="type_name" style="font-size: 85%; margin-top: 5px;">Участие в проектировании:</label>
		<input style="margin: 4px 0 0; line-height: normal;" type="checkbox" name="check" '.$check.'>
	</div>';
			
	return $html;
}

function form_delete_subdivision_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<p>Вы действительно хотите удалить запись '.$data[0]["subdivision_name"].'?</p>
	</div>';
			
	return $html;
}

function show_source_of_finance_full($data, $html=""){
	$html .= '<table class="table table-hover table-bordered" style="margin-bottom: 0px;">';
	
	foreach( $data as $value ){
		$html .= '<tr>
			<td style="padding-left: 15px;">'.$value["value"].'</td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default edit-hdbk" data-id='.$value["id"].' data-table-name="hdbk_source_of_finance" data-action="form_edit_source_of_finance_full" data-toggle="modal" data-target="#modal-edit-hdbk"><span class="glyphicon glyphicon-edit"></span></button></td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default delete-hdbk" data-id='.$value["id"].' data-table-name="hdbk_source_of_finance" data-action="form_delete_source_of_finance_full" data-toggle="modal" data-target="#modal-delete-hdbk"><span class="glyphicon glyphicon-trash"></span></button></td></tr>
		</tr>';
	}
	
	$html .= '</table>';
	
	return $html;
}

function form_edit_source_of_finance_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="value" style="font-size: 85%;">Источник финансирования:</label>
		<input class="form-control" style="width: 100%;" type="text" name="value" value="'.$data[0]["value"].'">
	</div>';
			
	return $html;
}

function form_delete_source_of_finance_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<p>Вы действительно хотите удалить запись '.$data[0]["value"].'?</p>
	</div>';
			
	return $html;
}

function show_doc_reason_for_development_psd_full($data, $html=""){
	$html .= '<table class="table table-hover table-bordered" style="margin-bottom: 0px;">';
	
	foreach( $data as $value ){
		$html .= '<tr>
			<td style="padding-left: 15px;">'.$value["value"].'</td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default edit-hdbk" data-id='.$value["id"].' data-table-name="hdbk_doc_reason_for_development_psd" data-action="form_edit_doc_reason_for_development_psd_full" data-toggle="modal" data-target="#modal-edit-hdbk"><span class="glyphicon glyphicon-edit"></span></button></td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default delete-hdbk" data-id='.$value["id"].' data-table-name="hdbk_doc_reason_for_development_psd" data-action="form_delete_doc_reason_for_development_psd_full" data-toggle="modal" data-target="#modal-delete-hdbk"><span class="glyphicon glyphicon-trash"></span></button></td></tr>
		</tr>';
	}
	
	$html .= '</table>';
	
	return $html;
}

function form_edit_doc_reason_for_development_psd_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="value" style="font-size: 85%;">Документ-основание на разработку ПСД:</label>
		<input class="form-control" style="width: 100%;" type="text" name="value" value="'.$data[0]["value"].'">
	</div>';
			
	return $html;
}

function form_delete_doc_reason_for_development_psd_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<p>Вы действительно хотите удалить запись '.$data[0]["value"].'?</p>
	</div>';
			
	return $html;
}

function show_customers_full($data, $html=""){
	$html .= '<table class="table table-hover table-bordered" style="margin-bottom: 0px;">';
	
	foreach( $data as $value ){
		$html .= '<tr>
			<td style="padding-left: 15px;">'.$value["org_name"].'</td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default edit-hdbk" data-id='.$value["id"].' data-table-name="hdbk_customers_psd" data-action="form_edit_customers_full" data-toggle="modal" data-target="#modal-edit-hdbk"><span class="glyphicon glyphicon-edit"></span></button></td>
			<td style="text-align: center; vertical-align: middle; width: 40px; padding: 1px;"><button class="btn btn-default delete-hdbk" data-id='.$value["id"].' data-table-name="hdbk_customers_psd" data-action="form_delete_customers_full" data-toggle="modal" data-target="#modal-delete-hdbk"><span class="glyphicon glyphicon-trash"></span></button></td></tr>
		</tr>';
	}
	
	$html .= '</table>';
	
	return $html;
}

function form_edit_customers_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="org_name" style="font-size: 85%;">Название организации:</label>
		<input class="form-control" style="width: 100%;" type="text" name="org_name" value="'.$data[0]["org_name"].'">
	</div>
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="legal_address" style="font-size: 85%;">Юридический адрес:</label>
		<input class="form-control" style="width: 100%;" type="text" name="legal_address" value="'.$data[0]["legal_address"].'">
	</div>
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="mailing_address" style="font-size: 85%;">Почтовый адрес:</label>
		<input class="form-control" style="width: 100%;" type="text" name="mailing_address" value="'.$data[0]["mailing_address"].'">
	</div>
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="unp" style="font-size: 85%;">УНП:</label>
		<input class="form-control" style="width: 100%;" type="text" name="unp" value="'.$data[0]["unp"].'">
	</div>
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="okpo" style="font-size: 85%;">ОКПО:</label>
		<input class="form-control" style="width: 100%;" type="text" name="okpo" value="'.$data[0]["okpo"].'">
	</div>
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="bank_details" style="font-size: 85%;">Банковские реквизиты:</label>
		<input class="form-control" style="width: 100%;" type="text" name="bank_details" value="'.$data[0]["bank_details"].'">
	</div>
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<label for="head_fio" style="font-size: 85%;">ФИО директора:</label>
		<input class="form-control" style="width: 100%;" type="text" name="head_fio" value="'.$data[0]["head_fio"].'">
	</div>';
			
	return $html;
}

function form_delete_customers_full($data, $html=""){
	$html .= '<input type="hidden" name="hdbk_id" value="'.$data[0]["id"].'">
	<div class="form-group" style="width: 100%; margin-bottom: 10px;">
		<p>Вы действительно хотите удалить запись для '.$data[0]["org_name"].'?</p>
	</div>';
			
	return $html;
}

switch( $_POST['action'] ){
	case 'types_of_jobs_full':
	
		/****Виды работ***/

		$success["hdbk_name"] = "Планирование / виды выполняемых работ";
		$select_types_of_jobs_full = $hdbk->select_types_of_jobs_full();
		if( !empty($select_types_of_jobs_full) ){
			$success["show_types_of_jobs_full"] = show_types_of_jobs_full($select_types_of_jobs_full);
		}
		else{ $success["show_types_of_jobs_full"] = 'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'education_full':
	
		/****Образование***/

		$success["hdbk_name"] = "Образование";
		$select_education_full = $hdbk->select_education_full();
		if( !empty($select_education_full) ){
			$success["show_education_full"] = show_education_full($select_education_full);
		}
		else{ $success["show_education_full"] = 'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'source_of_finance_full':
	
		/****Источник финансирования***/

		$success["hdbk_name"] = "Источник финансирования";
		$select_source_of_finance_full = $hdbk->select_source_of_finance_full();
		if( !empty($select_source_of_finance_full) ){
			$success["show_source_of_finance_full"] = show_source_of_finance_full($select_source_of_finance_full);
		}
		else{ $success["show_source_of_finance_full"] = 'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'function_full':
	
		/****Должность***/

		$success["hdbk_name"] = "Должность";
		$select_function_full = $hdbk->select_function_full();
		if( !empty($select_function_full) ){
			$success["show_function_full"] = show_function_full($select_function_full);
		}
		else{ $success["show_function_full"] = 'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'subdivision_full':
	
		/****Подразделение***/

		$success["hdbk_name"] = "Подразделение";
		$select_subdivision_full = $hdbk->select_subdivision_full();
		if( !empty($select_subdivision_full) ){
			$success["show_subdivision_full"] = show_subdivision_full($select_subdivision_full);
		}
		else{ $success["show_subdivision_full"] = 'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'doc_reason_for_development_psd_full':
	
		/****Документ основание на разработку ПСД***/

		$success["hdbk_name"] = "Документ основание на разработку ПСД";
		$select_doc_reason_for_development_psd_full = $hdbk->select_doc_reason_for_development_psd_full();
		if( !empty($select_doc_reason_for_development_psd_full) ){
			$success["show_doc_reason_for_development_psd_full"] = show_doc_reason_for_development_psd_full($select_doc_reason_for_development_psd_full);
		}
		else{ $success["show_doc_reason_for_development_psd_full"] = 'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'customers_full':
	
		/****Заказчики***/

		$success["hdbk_name"] = "Заказчики";
		$select_customers_full = $hdbk->select_customers_full();
		if( !empty($select_customers_full) ){
			$success["show_customers_full"] = show_customers_full($select_customers_full);
		}
		else{ $success["show_customers_full"] = 'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_edit_types_of_jobs_full':
	
		/****Форма редактирования справочника - виды работ***/
		
		$select_edit_types_of_jobs_full = $hdbk->select_edit_types_of_jobs_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_edit_types_of_jobs_full) ){
			$success["form_edit_types_of_jobs_full"] = form_edit_types_of_jobs_full($select_edit_types_of_jobs_full);
		}
		else{ $success["form_edit_types_of_jobs_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_delete_types_of_jobs_full':
	
		/****Форма удаление записи из справочника - виды работ***/
		
		$select_delete_types_of_jobs_full = $hdbk->select_delete_types_of_jobs_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_delete_types_of_jobs_full) ){
			$success["form_delete_types_of_jobs_full"] = form_delete_types_of_jobs_full($select_delete_types_of_jobs_full);
		}
		else{ $success["form_delete_types_of_jobs_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_add_types_of_jobs_full':
	
		/****Форма добавления записи в справочник типы работ***/
		
		$success["form_add_types_of_jobs_full"] = 
		'<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="type_name" style="font-size: 85%;">Наименование работы:</label>
			<input class="form-control" style="width: 100%;" type="text" name="type_name">
			<label for="type_name_abbreviation" style="font-size: 85%;">Сокращенное наименование работы:</label>
			<input class="form-control" style="width: 100%;" type="text" name="type_name_abbreviation">
		</div>';
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_edit_education_full':
	
		/****Форма редактирования справочника образование***/
		
		$select_edit_education_full = $hdbk->select_edit_education_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_edit_education_full) ){
			$success["form_edit_education_full"] = form_edit_education_full($select_edit_education_full);
		}
		else{ $success["form_edit_education_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_add_education_full':
	
		/****Форма добавления записи в справочник образование***/
		
		$success["form_add_education_full"] = 
		'<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="education_name" style="font-size: 85%;">Образование:</label>
			<input class="form-control" style="width: 100%;" type="text" name="education_name">
		</div>';
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_delete_education_full':
	
		/****Форма удаление записи из справочника - образование***/
		
		$select_delete_education_full = $hdbk->select_delete_education_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_delete_education_full) ){
			$success["form_delete_education_full"] = form_delete_education_full($select_delete_education_full);
		}
		else{ $success["form_delete_education_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_edit_function_full':
	
		/****Форма редактирования справочника должностей***/
		
		$select_edit_function_full = $hdbk->select_edit_function_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_edit_function_full) ){
			$success["form_edit_function_full"] = form_edit_function_full($select_edit_function_full);
		}
		else{ $success["form_edit_function_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_delete_function_full':
	
		/****Форма удаление записи из справочника - должность***/
		
		$select_delete_function_full = $hdbk->select_delete_function_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_delete_function_full) ){
			$success["form_delete_function_full"] = form_delete_function_full($select_delete_function_full);
		}
		else{ $success["form_delete_function_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_add_function_full':
	
		/****Форма добавления записи в справочник должности***/
		
		$success["form_add_function_full"] = 
		'<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="function_name" style="font-size: 85%;">Должность:</label>
			<input class="form-control" style="width: 100%;" type="text" name="function_name">
		</div>';
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_edit_subdivision_full':
	
		/****Форма редактирования справочника подразделений***/
		
		$select_edit_subdivision_full = $hdbk->select_edit_subdivision_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_edit_subdivision_full) ){
			$success["form_edit_subdivision_full"] = form_edit_subdivision_full($select_edit_subdivision_full);
		}
		else{ $success["form_edit_subdivision_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_delete_subdivision_full':
	
		/****Форма удаление записи из справочника - подразделение***/
		
		$select_delete_subdivision_full = $hdbk->select_delete_subdivision_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_delete_subdivision_full) ){
			$success["form_delete_subdivision_full"] = form_delete_subdivision_full($select_delete_subdivision_full);
		}
		else{ $success["form_delete_subdivision_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_add_subdivision_full':
	
		/****Форма добавления записи в справочник подразделение***/
		
		$success["form_add_subdivision_full"] = 
		'<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="subdivision_name" style="font-size: 85%;">Подразделение:</label>
			<input class="form-control" style="width: 100%;" type="text" name="subdivision_name">
		</div>
		<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="type_name" style="font-size: 85%; margin-top: 5px;">Участие в проектировании:</label>
			<input style="margin: 4px 0 0; line-height: normal;" type="checkbox" name="check">
		</div>';
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_edit_source_of_finance_full':
	
		/****Форма редактирования справочника - Источник финансирования***/
		
		$select_edit_source_of_finance_full = $hdbk->select_edit_source_of_finance_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_edit_source_of_finance_full) ){
			$success["form_edit_source_of_finance_full"] = form_edit_source_of_finance_full($select_edit_source_of_finance_full);
		}
		else{ $success["form_edit_source_of_finance_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_delete_source_of_finance_full':
	
		/****Форма удаление записи из справочника - Источник финансирования***/
		
		$select_delete_source_of_finance_full = $hdbk->select_delete_source_of_finance_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_delete_source_of_finance_full) ){
			$success["form_delete_source_of_finance_full"] = form_delete_source_of_finance_full($select_delete_source_of_finance_full);
		}
		else{ $success["form_delete_source_of_finance_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_add_source_of_finance_full':
	
		/****Форма добавления записи в справочник Источник финансирования***/
		
		$success["form_add_source_of_finance_full"] = 
		'<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="value" style="font-size: 85%;">Источник финансирования:</label>
			<input class="form-control" style="width: 100%;" type="text" name="value">
		</div>';
		
		echo ajax_response($success, $error);
	break;
	
	//------------------------------------
	
	case 'form_edit_doc_reason_for_development_psd_full':
	
		/****Форма редактирования справочника - документ ПСД***/
		
		$select_edit_doc_reason_for_development_psd_full = $hdbk->select_edit_doc_reason_for_development_psd_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_edit_doc_reason_for_development_psd_full) ){
			$success["form_edit_doc_reason_for_development_psd_full"] = form_edit_doc_reason_for_development_psd_full($select_edit_doc_reason_for_development_psd_full);
		}
		else{ $success["form_edit_doc_reason_for_development_psd_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_delete_doc_reason_for_development_psd_full':
	
		/****Форма удаление записи из справочника - документ ПСД***/
		
		$select_delete_doc_reason_for_development_psd_full = $hdbk->select_delete_doc_reason_for_development_psd_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_delete_doc_reason_for_development_psd_full) ){
			$success["form_delete_doc_reason_for_development_psd_full"] = form_delete_doc_reason_for_development_psd_full($select_delete_doc_reason_for_development_psd_full);
		}
		else{ $success["form_delete_doc_reason_for_development_psd_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_add_doc_reason_for_development_psd_full':
	
		/****Форма добавления записи в справочник документ ПСД***/
		
		$success["form_add_doc_reason_for_development_psd_full"] = 
		'<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="value" style="font-size: 85%;">Документ основание на разработку ПСД:</label>
			<input class="form-control" style="width: 100%;" type="text" name="value">
		</div>';
		
		echo ajax_response($success, $error);
	break;
	
	//------------------------------------
	
	case 'form_edit_customers_full':
	
		/****Форма редактирования справочника - заказчики***/
		
		$select_edit_customers_full = $hdbk->select_edit_customers_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_edit_customers_full) ){
			$success["form_edit_customers_full"] = form_edit_customers_full($select_edit_customers_full);
		}
		else{ $success["form_edit_customers_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_delete_customers_full':
	
		/****Форма удаление записи из справочника - заказчики***/
		
		$select_delete_customers_full = $hdbk->select_delete_customers_full([":id" => $_POST["hdbk_id"]]);
		if( !empty($select_delete_customers_full) ){
			$success["form_delete_customers_full"] = form_delete_customers_full($select_delete_customers_full);
		}
		else{ $success["form_delete_customers_full"] = $data; } //'Ни одной записи не найдено. Добавьте новую запись или обратитесь в службу поддержки.'
		
		echo ajax_response($success, $error);
	break;
	
	case 'form_add_customers_full':
	
		/****Форма добавления записи в справочник заказчики***/
		
		$success["form_add_customers_full"] = 
		'<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="org_name" style="font-size: 85%;">Название организации:</label>
			<input class="form-control" style="width: 100%;" type="text" name="org_name">
		</div>
		<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="legal_address" style="font-size: 85%;">Юридический адрес:</label>
			<input class="form-control" style="width: 100%;" type="text" name="legal_address">
		</div>
		<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="mailing_address" style="font-size: 85%;">Почтовый адрес:</label>
			<input class="form-control" style="width: 100%;" type="text" name="mailing_address">
		</div>
		<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="unp" style="font-size: 85%;">УНП:</label>
			<input class="form-control" style="width: 100%;" type="text" name="unp">
		</div>
		<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="okpo" style="font-size: 85%;">ОКПО:</label>
			<input class="form-control" style="width: 100%;" type="text" name="okpo">
		</div>
		<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="bank_details" style="font-size: 85%;">Банковские реквизиты:</label>
			<input class="form-control" style="width: 100%;" type="text" name="bank_details">
		</div>
		<div class="form-group" style="width: 100%; margin-bottom: 10px;">
			<label for="head_fio" style="font-size: 85%;">ФИО директора:</label>
			<input class="form-control" style="width: 100%;" type="text" name="head_fio">
		</div>
		';
		
		echo ajax_response($success, $error);
	break;
	
	case 'add_education_full':
	
		/****Добавление - образование***/
		parse_str($_POST['data'], $row_form);
		
		$add_education_full = $hdbk->add_education_full([":education_name" => $row_form["education_name"]]);
		if( !empty($add_education_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
		case 'add_types_of_jobs_full':
	
		/****Добавление - виды работ***/
		parse_str($_POST['data'], $row_form);
		
		$add_types_of_jobs_full = $hdbk->add_types_of_jobs_full([":type_name" => $row_form["type_name"], ":type_name_abbreviation" => $row_form["type_name_abbreviation"]]);
		if( !empty($add_types_of_jobs_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
		case 'add_function_full':
	
		/****Добавление - образование***/
		parse_str($_POST['data'], $row_form);
		
		$add_function_full = $hdbk->add_function_full([":function_name" => $row_form["function_name"]]);
		if( !empty($add_function_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'add_subdivision_full':
	
		/****Добавление - образование***/
		parse_str($_POST['data'], $row_form);
		
		if( isset($row_form["check"]) ){
			$check = 1;
		}
		else{ $check = 0; }
		
		$add_subdivision_full = $hdbk->add_subdivision_full([":subdivision_name" => $row_form["subdivision_name"], ":checked" => $check]);
		if( !empty($add_subdivision_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'add_source_of_finance_full':
	
		/****Добавление - источник финансирования***/
		parse_str($_POST['data'], $row_form);
		
		$add_source_of_finance_full = $hdbk->add_source_of_finance_full([":value" => $row_form["value"]]);
		if( !empty($add_source_of_finance_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'add_doc_reason_for_development_psd_full':
	
		/****Добавление - документ ПСД***/
		parse_str($_POST['data'], $row_form);
		
		$add_doc_reason_for_development_psd_full = $hdbk->add_doc_reason_for_development_psd_full([":value" => $row_form["value"]]);
		if( !empty($add_doc_reason_for_development_psd_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'add_customers_full':
	
		/****Добавление - заказчики***/
		parse_str($_POST['data'], $row_form);
		
		$add_customers_full = $hdbk->add_customers_full([":org_name" => $row_form["org_name"], ":legal_address" => $row_form["legal_address"], ":mailing_address" => $row_form["mailing_address"],
																":unp" => $row_form["unp"], ":okpo" => $row_form["okpo"], ":bank_details" => $row_form["bank_details"], ":head_fio" => $row_form["head_fio"]]);
		if( !empty($add_customers_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'update_types_of_jobs_full':
	
		/****Обновление справочной информации - виды работ***/
		parse_str($_POST['data'], $row_form);
		
		$update_types_of_jobs_full = $hdbk->update_types_of_jobs_full([":id" => $row_form["hdbk_id"], ":type_name" => $row_form["type_name"], ":type_name_abbreviation" => $row_form["type_name_abbreviation"]]);
		if( !empty($update_types_of_jobs_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'update_education_full':
	
		/****Обновление справочной информации - образование***/
		parse_str($_POST['data'], $row_form);
		
		$update_education_full = $hdbk->update_education_full([":id" => $row_form["hdbk_id"], ":education_name" => $row_form["education_name"]]);
		if( !empty($update_education_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'update_function_full':
	
		/****Обновление справочной информации - Должность***/
		parse_str($_POST['data'], $row_form);
		
		$update_function_full = $hdbk->update_function_full([":id" => $row_form["hdbk_id"], ":function_name" => $row_form["function_name"]]);
		if( !empty($update_function_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'update_subdivision_full':
	
		/****Обновление справочной информации - подразделение***/
		parse_str($_POST['data'], $row_form);
		if( isset($row_form["check"]) ){
			$check = 1;
		}
		else{ $check = 0; }
		
		$update_subdivision_full = $hdbk->update_subdivision_full([":id" => $row_form["hdbk_id"], ":subdivision_name" => $row_form["subdivision_name"], ":checked" => $check]);
		if( !empty($update_subdivision_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'update_source_of_finance_full':
	
		/****Обновление справочной информации - источник финансирования***/
		parse_str($_POST['data'], $row_form);
		
		$update_source_of_finance_full = $hdbk->update_source_of_finance_full([":id" => $row_form["hdbk_id"], ":value" => $row_form["value"]]);
		if( !empty($update_source_of_finance_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'update_doc_reason_for_development_psd_full':
	
		/****Обновление справочной информации - документ ПСД***/
		parse_str($_POST['data'], $row_form);
		
		$update_doc_reason_for_development_psd_full = $hdbk->update_doc_reason_for_development_psd_full([":id" => $row_form["hdbk_id"], ":value" => $row_form["value"]]);
		if( !empty($update_doc_reason_for_development_psd_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'update_customers_full':
	
		/****Обновление справочной информации - документ ПСД***/
		parse_str($_POST['data'], $row_form);
		
		$update_customers_full = $hdbk->update_customers_full([":id" => $row_form["hdbk_id"], ":org_name" => $row_form["org_name"], ":legal_address" => $row_form["legal_address"], ":mailing_address" => $row_form["mailing_address"],
																":unp" => $row_form["unp"], ":okpo" => $row_form["okpo"], ":bank_details" => $row_form["bank_details"], ":head_fio" => $row_form["head_fio"]]);
		if( !empty($update_customers_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные справочника успешно обновлены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'delete_types_of_jobs_full':
	
		/****Удаление справочной информации - виды работ***/
		parse_str($_POST['data'], $row_form);
		
		$delete_types_of_jobs_full = $hdbk->delete_types_of_jobs_full([":id" => $row_form["hdbk_id"]]);
		if( !empty($delete_types_of_jobs_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные успешно удалены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'delete_education_full':
	
		/****Удаление справочной информации - образование***/
		parse_str($_POST['data'], $row_form);
		
		$delete_education_full = $hdbk->delete_education_full([":id" => $row_form["hdbk_id"]]);
		if( !empty($delete_education_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные успешно удалены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'delete_function_full':
	
		/****Удаление справочной информации - должность***/
		parse_str($_POST['data'], $row_form);
		
		$delete_function_full = $hdbk->delete_function_full([":id" => $row_form["hdbk_id"]]);
		if( !empty($delete_function_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные успешно удалены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'delete_subdivision_full':
	
		/****Удаление справочной информации - виды работ***/
		parse_str($_POST['data'], $row_form);
		
		$delete_subdivision_full = $hdbk->delete_subdivision_full([":id" => $row_form["hdbk_id"]]);
		if( !empty($delete_subdivision_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные успешно удалены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'delete_source_of_finance_full':
	
		/****Удаление справочной информации - источник финансирования***/
		parse_str($_POST['data'], $row_form);
		
		$delete_source_of_finance_full = $hdbk->delete_source_of_finance_full([":id" => $row_form["hdbk_id"]]);
		if( !empty($delete_source_of_finance_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные успешно удалены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'delete_doc_reason_for_development_psd_full':
	
		/****Удаление справочной информации - документ ПСД***/
		parse_str($_POST['data'], $row_form);
		
		$delete_doc_reason_for_development_psd_full = $hdbk->delete_doc_reason_for_development_psd_full([":id" => $row_form["hdbk_id"]]);
		if( !empty($delete_doc_reason_for_development_psd_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные успешно удалены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
	
	case 'delete_customers_full':
	
		/****Удаление справочной информации - документ ПСД***/
		parse_str($_POST['data'], $row_form);
		
		$delete_customers_full = $hdbk->delete_customers_full([":id" => $row_form["hdbk_id"]]);
		if( !empty($delete_customers_full) ){
			$success = '<div class="alert alert-success" style="padding: 6px 12px; margin-bottom: 0px;">Данные успешно удалены.</div>';
		}
		else{ $error = '<div class="alert alert-danger" style="padding: 6px 12px; margin-bottom: 0px;">Ошибка. Обратитесь в службу поддержки.</div>'; }
		
		echo ajax_response($success, $error);
	break;
}

?>