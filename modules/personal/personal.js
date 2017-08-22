$(".chosen-select").chosen({width: "100%", disable_search_threshold:9});
$(document).ready(function(){ start_load(); $('#simple-menu').sidr(); });

$(".btn-show-contracts").on("click", function(){
	$(".table-personal").css("display", "none");
	$(".statistics").css("display", "none");
	$(".panel-personal").css("display", "none");
	
	$(".table-contracts").css("display", "block");
	$(".panel-contracts").css("display", "block");
	
	$(".btn-show-personal").prop("disabled", false);
	$(".btn-show-contracts").prop("disabled", true);
});

$(".btn-show-personal").on("click", function(){
	$(".table-contracts").css("display", "none");
	$(".panel-contracts").css("display", "none");
	
	$(".table-personal").css("display", "block");
	$(".panel-personal").css("display", "block");
	$(".statistics").css("display", "block");
	
	$(".btn-show-personal").prop("disabled", true);
	$(".btn-show-contracts").prop("disabled", false);
});

//Добавление сотрудника
$("#form-add-user").on("submit", function(e){
	$.ajax({
		type: 'POST',
		url: 'personal.ajax.php',
		data: {
			action: "form-add-user",
			data: $(this).serialize()
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				start_load(); $("#form-add-user .ajax-resp").html(arr_msg.success);
				$("#form-add-user")[0].reset(); $('.chosen-select').trigger("chosen:updated"); 						
			}
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
	
	return false;
});

//Обновление данных сотрудника
$("#form-edit-user").on("submit", function(e){
	$.ajax({
		type: 'POST',
		url: 'personal.ajax.php',
		data: {
			action: "form-update-user",
			data: $(this).serialize()
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ start_load(); $("#form-edit-user .ajax-resp").html(arr_msg.success); }
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
	
	return false;
});

//Функция удаления сотрудника
function delete_user(delete_user_id){
	$.ajax({
		type: 'POST',
		url: 'personal.ajax.php',
		data: {
			action: "delete_user",
			data: delete_user_id
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ start_load(); }
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
}

//Функция редактирования сотрудника
function edit_user(edit_user_id){
	$.ajax({
		type: 'POST',
		url: 'personal.ajax.php',
		data: {
			action: "edit_user",
			data: edit_user_id
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{
				$('#form-edit-user input[name="user_id"]').val(arr_msg.success[0]['id']);
				$('#form-edit-user input[name="user_f"]').val(arr_msg.success[0]['user_f']);
				$('#form-edit-user input[name="user_i"]').val(arr_msg.success[0]['user_i']);
				$('#form-edit-user input[name="user_o"]').val(arr_msg.success[0]['user_o']);
				$('#form-edit-user input[name="user_dob"]').val(arr_msg.success[0]['user_dob']);
				$('#form-edit-user input[name="user_receipt"]').val(arr_msg.success[0]['user_receipt']);
				$('#form-edit-user select[name="user_gender"]').val(arr_msg.success[0]['user_gender']);
				$('#form-edit-user select[name="user_education"]').val(arr_msg.success[0]['user_education']);
				$('#form-edit-user select[name="user_function"]').val(arr_msg.success[0]['user_function']);
				$('#form-edit-user select[name="user_subdivision"]').val(arr_msg.success[0]['user_subdivision']);
				$('#form-edit-user select[name="user_category"]').val(arr_msg.success[0]['user_category']);
				
				$('.chosen-select').trigger("chosen:updated");
			}
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
}

//Функция редактирования данных о контрактах
function edit_contract(edit_contract_id){
	$.ajax({
		type: 'POST',
		url: 'personal.ajax.php',
		data: {
			action: "edit_contract",
			data: edit_contract_id
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{
				$('#form-edit-contract input[name="user_id"]').val(arr_msg.success[0]['id']);
				$('#form-edit-contract input[name="user_f"]').val(arr_msg.success[0]['user_f']);
				$('#form-edit-contract input[name="user_i"]').val(arr_msg.success[0]['user_i']);
				$('#form-edit-contract input[name="user_o"]').val(arr_msg.success[0]['user_o']);
				$('#form-edit-contract input[name="contract_num"]').val(arr_msg.success[0]['contract_num']);
				$('#form-edit-contract input[name="contract_date_begin"]').val(arr_msg.success[0]['contract_date_begin']);
				$('#form-edit-contract input[name="contract_date_end"]').val(arr_msg.success[0]['contract_date_end']);
				$('#form-edit-contract input[name="contract_extend_begin"]').val(arr_msg.success[0]['contract_extend_begin']);
				$('#form-edit-contract input[name="contract_extend_end"]').val(arr_msg.success[0]['contract_extend_end']);
			}
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
}

//Обновление данных сотрудника по контрактам
$("#form-edit-contract").on("submit", function(e){
	$.ajax({
		type: 'POST',
		url: 'personal.ajax.php',
		data: {
			action: "form-update-contract",
			data: $(this).serialize()
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else
			{ 
				start_load(); 
				$(".close-modal-edit-contract").click();
				$(".btn-show-contracts").click(); 
				$(".close-modal-show-contract-expired").click();
			}
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
	
	return false;
});

function start_load(){
//	$("#loader").css("display", "block");
	$(".table-contracts").css("display", "none");
	$(".panel-contracts").css("display", "none");
	
	$(".btn-show-personal").prop("disabled", true);

	$.ajax({
		type: 'POST',
		url: 'personal.ajax.php',
		data: {
			action: "start_load"
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{
				$('.personal-data').html(arr_msg.success['users_table']);
				$('.contracts-data').html(arr_msg.success['contracts_table']);
			
				$(".btn-show-contracts").on("click", function(){
					$(".btn-show-contract-expired").click();
					$("#modal-show-contract-expired .modal-text").html(arr_msg.success['fioContract']);
	
				});
				
				$('select[name="user_gender"]').html(arr_msg.success['gender_list']);
				$('select[name="user_function"]').html(arr_msg.success['function_list']); 							
				$('select[name="user_education"]').html(arr_msg.success['education_list']);
				$('select[name="user_subdivision"]').html(arr_msg.success['subdivision_list']);
				$('select[name="user_category"]').html(arr_msg.success['category_list']);
				
				$(".delete_user").on("click", function(e){ delete_user($(this).attr("data-user-id")); });
				$(".edit_user").on("click", function(e){ edit_user($(this).attr("data-user-id")); });
				$(".edit_contract").on("click", function(e){ edit_contract($(this).attr("data-user-id")); });
				
				$('#form-edit-user input').on("keyup", function(e){ $("#form-edit-user .ajax-resp").html(''); });
				$('#form-add-user input').on("keyup", function(e){ $("#form-add-user .ajax-resp").html(''); });
				$('#form-edit-contract input').on("keyup", function(e){ $("#form-edit-contract .ajax-resp").html(''); });
				
				show_statistic_data(arr_msg.success['statistic_data']);

				$('button[data-toggle="modal"]').on("click", function(e){ $('.chosen-select').trigger("chosen:updated"); $(".ajax-resp").html(''); });
			//	$("#loader").css("display", "none");		
			}

		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
	
	
}

function show_statistic_data(data){
	$('td[name="str_01_1"]').html(data['str_01_1']); $('td[name="str_01_2"]').html(data['str_01_2']); $('td[name="str_01_3"]').html(data['str_01_3']); $('td[name="str_01_4"]').html(data['str_01_4']);
	$('td[name="str_01_5"]').html(data['str_01_5']); $('td[name="str_01_6"]').html(data['str_01_6']); $('td[name="str_01_7"]').html(data['str_01_7']); $('td[name="str_01_8"]').html(data['str_01_8']);
	
	$('td[name="str_02_1"]').html(data['str_02_1']); $('td[name="str_02_2"]').html(data['str_02_2']); $('td[name="str_02_3"]').html(data['str_02_3']); $('td[name="str_02_4"]').html(data['str_02_4']);
	$('td[name="str_02_5"]').html(data['str_02_5']); $('td[name="str_02_6"]').html(data['str_02_6']); $('td[name="str_02_7"]').html(data['str_02_7']); $('td[name="str_02_8"]').html(data['str_02_8']);
	
	$('td[name="str_03_1"]').html(data['str_03_1']); $('td[name="str_03_2"]').html(data['str_03_2']); $('td[name="str_03_3"]').html(data['str_03_3']); $('td[name="str_03_4"]').html(data['str_03_4']);
	$('td[name="str_03_5"]').html(data['str_03_5']); $('td[name="str_03_6"]').html(data['str_03_6']); $('td[name="str_03_7"]').html(data['str_03_7']); $('td[name="str_03_8"]').html(data['str_03_8']);
	
	$('td[name="str_04_1"]').html(data['str_04_1']); $('td[name="str_04_2"]').html(data['str_04_2']); $('td[name="str_04_3"]').html(data['str_04_3']); $('td[name="str_04_4"]').html(data['str_04_4']);
	$('td[name="str_04_5"]').html(data['str_04_5']); $('td[name="str_04_6"]').html(data['str_04_6']); $('td[name="str_04_7"]').html(data['str_04_7']); $('td[name="str_04_8"]').html(data['str_04_8']);
	
	$('td[name="str_05_1"]').html(data['str_05_1']); $('td[name="str_05_2"]').html(data['str_05_2']); $('td[name="str_05_3"]').html(data['str_05_3']); $('td[name="str_05_4"]').html(data['str_05_4']);
	$('td[name="str_05_5"]').html(data['str_05_5']); $('td[name="str_05_6"]').html(data['str_05_6']); $('td[name="str_05_7"]').html(data['str_05_7']); $('td[name="str_05_8"]').html(data['str_05_8']);
	
	$('td[name="str_06_1"]').html(data['str_06_1']); $('td[name="str_06_2"]').html(data['str_06_2']); $('td[name="str_06_3"]').html(data['str_06_3']); $('td[name="str_06_4"]').html(data['str_06_4']); 
	$('td[name="str_06_5"]').html(data['str_06_5']); $('td[name="str_06_6"]').html(data['str_06_6']); $('td[name="str_06_7"]').html(data['str_06_7']); $('td[name="str_06_8"]').html(data['str_06_8']);
	
	$('td[name="str_07_1"]').html(data['str_07_1']); $('td[name="str_07_2"]').html(data['str_07_2']); $('td[name="str_07_3"]').html(data['str_07_3']); $('td[name="str_07_4"]').html(data['str_07_4']);
	$('td[name="str_07_5"]').html(data['str_07_5']); $('td[name="str_07_6"]').html(data['str_07_6']); $('td[name="str_07_7"]').html(data['str_07_7']); $('td[name="str_07_8"]').html(data['str_07_8']);
	
	$('td[name="str_08_1"]').html(data['str_08_1']); $('td[name="str_08_2"]').html(data['str_08_2']); $('td[name="str_08_3"]').html(data['str_08_3']); $('td[name="str_08_4"]').html(data['str_08_4']);
	$('td[name="str_08_5"]').html(data['str_08_5']); $('td[name="str_08_6"]').html(data['str_08_6']); $('td[name="str_08_7"]').html(data['str_08_7']); $('td[name="str_08_8"]').html(data['str_08_8']);

	$('td[name="str_09_1"]').html(data['str_09_1']); $('td[name="str_09_2"]').html(data['str_09_2']); $('td[name="str_09_3"]').html(data['str_09_3']); $('td[name="str_09_4"]').html(data['str_09_4']);
	$('td[name="str_09_5"]').html(data['str_09_5']); $('td[name="str_09_6"]').html(data['str_09_6']); $('td[name="str_09_7"]').html(data['str_09_7']); $('td[name="str_09_8"]').html(data['str_09_8']);
	
	$('td[name="str_10_1"]').html(data['str_10_1']); $('td[name="str_10_2"]').html(data['str_10_2']); $('td[name="str_10_3"]').html(data['str_10_3']); $('td[name="str_10_4"]').html(data['str_10_4']);
	$('td[name="str_10_5"]').html(data['str_10_5']); $('td[name="str_10_6"]').html(data['str_10_6']); $('td[name="str_10_7"]').html(data['str_10_7']); $('td[name="str_10_8"]').html(data['str_10_8']);
	
	$('td[name="str_11_1"]').html(data['str_11_1']); $('td[name="str_11_2"]').html(data['str_11_2']); $('td[name="str_11_3"]').html(data['str_11_3']); $('td[name="str_11_4"]').html(data['str_11_4']);
	$('td[name="str_11_5"]').html(data['str_11_5']); $('td[name="str_11_6"]').html(data['str_11_6']); $('td[name="str_11_7"]').html(data['str_11_7']); $('td[name="str_11_8"]').html(data['str_11_8']);
	
	$('td[name="str_12_1"]').html(data['str_12_1']); $('td[name="str_12_2"]').html(data['str_12_2']); $('td[name="str_12_3"]').html(data['str_12_3']); $('td[name="str_12_4"]').html(data['str_12_4']);
	$('td[name="str_12_5"]').html(data['str_12_5']); $('td[name="str_12_6"]').html(data['str_12_6']); $('td[name="str_12_7"]').html(data['str_12_7']); $('td[name="str_12_8"]').html(data['str_12_8']);
	
	$('td[name="str_13_1"]').html(data['str_13_1']); $('td[name="str_13_2"]').html(data['str_13_2']); $('td[name="str_13_3"]').html(data['str_13_3']); $('td[name="str_13_4"]').html(data['str_13_4']);
	$('td[name="str_13_5"]').html(data['str_13_5']); $('td[name="str_13_6"]').html(data['str_13_6']); $('td[name="str_13_7"]').html(data['str_13_7']); $('td[name="str_13_8"]').html(data['str_13_8']);
	
	$('td[name="str_14_1"]').html(data['str_14_1']); $('td[name="str_14_2"]').html(data['str_14_2']); $('td[name="str_14_3"]').html(data['str_14_3']); $('td[name="str_14_4"]').html(data['str_14_4']);
	$('td[name="str_14_5"]').html(data['str_14_5']); $('td[name="str_14_6"]').html(data['str_14_6']); $('td[name="str_14_7"]').html(data['str_14_7']); $('td[name="str_14_8"]').html(data['str_14_8']);
	
	$('td[name="str_15_1"]').html(data['str_15_1']); $('td[name="str_15_2"]').html(data['str_15_2']); $('td[name="str_15_3"]').html(data['str_15_3']); $('td[name="str_15_4"]').html(data['str_15_4']);
	$('td[name="str_15_5"]').html(data['str_15_5']); $('td[name="str_15_6"]').html(data['str_15_6']); $('td[name="str_15_7"]').html(data['str_15_7']); $('td[name="str_15_8"]').html(data['str_15_8']);
	
	$('td[name="str_16_1"]').html(data['str_16_1']); $('td[name="str_16_2"]').html(data['str_16_2']); $('td[name="str_16_3"]').html(data['str_16_3']); $('td[name="str_16_4"]').html(data['str_16_4']);
	$('td[name="str_16_5"]').html(data['str_16_5']); $('td[name="str_16_6"]').html(data['str_16_6']); $('td[name="str_16_7"]').html(data['str_16_7']); $('td[name="str_16_8"]').html(data['str_16_8']);
	
	$('td[name="str_17_1"]').html(data['str_17_1']); $('td[name="str_17_2"]').html(data['str_17_2']); $('td[name="str_17_3"]').html(data['str_17_3']); $('td[name="str_17_4"]').html(data['str_17_4']);
	$('td[name="str_17_5"]').html(data['str_17_5']); $('td[name="str_17_6"]').html(data['str_17_6']); $('td[name="str_17_7"]').html(data['str_17_7']); $('td[name="str_17_8"]').html(data['str_17_8']);
	
	$('td[name="str_18_1"]').html(data['str_18_1']); $('td[name="str_18_2"]').html(data['str_18_2']); $('td[name="str_18_3"]').html(data['str_18_3']); $('td[name="str_18_4"]').html(data['str_18_4']);
	$('td[name="str_18_5"]').html(data['str_18_5']); $('td[name="str_18_6"]').html(data['str_18_6']); $('td[name="str_18_7"]').html(data['str_18_7']); $('td[name="str_18_8"]').html(data['str_18_8']);
}