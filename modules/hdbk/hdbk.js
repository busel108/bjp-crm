$(".chosen-select").chosen({width: "100%", disable_search_threshold:9});
$(document).ready(function(){ $('#simple-menu').sidr(); });

$("#types_of_jobs_full").on("click", function(e){
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: "types_of_jobs_full"
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				$(".response-hdbk-full").html(arr_msg.success["show_types_of_jobs_full"]);
				$(".hdbk-name").html(arr_msg.success["hdbk_name"]);
				$(".show-full-hdbk").css("display", "block");
				
				$(".add-hdbk").on("click", function(){
					var hdbk_table = "hdbk_types_of_jobs";
					var hdbk_action = "form_add_types_of_jobs_full";
					$(".btn-add-hdbk").html("<button class=\"btn btn-primary add-to-hdbk\" type=\"submit\" data-action=\"add_types_of_jobs_full\" data-refresh=\"types_of_jobs_full\">Добавить</button>");
					form_add_hdbk(hdbk_table, hdbk_action);
				});
				
				$(".edit-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-save-hdbk").html("<button class=\"btn btn-primary btn-save\" type=\"submit\" data-action=\"update_types_of_jobs_full\" data-refresh=\"types_of_jobs_full\">Сохранить</button>");
					form_edit_hdbk(hdbk_id, hdbk_table, hdbk_action);  
				});
				
				$(".delete-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-delete-hdbk").html("<button class=\"btn btn-primary btn-delete\" type=\"submit\" data-action=\"delete_types_of_jobs_full\" data-refresh=\"types_of_jobs_full\">Удалить</button>");
					form_delete_hdbk(hdbk_id, hdbk_table, hdbk_action);  
				});
				
				$('#form-edit-hdbk input').on("keyup", function(e){ $("#form-edit-hdbk .ajax-resp").html(''); });
				$('#form-delete-hdbk input').on("keyup", function(e){ $("#form-delete-hdbk .ajax-resp").html(''); });
				$('button[data-toggle="modal"]').on("click", function(e){ $(".ajax-resp").html(''); });
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
});

$("#education_full").on("click", function(e){
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: "education_full"
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				$(".response-hdbk-full").html(arr_msg.success["show_education_full"]);
				$(".hdbk-name").html(arr_msg.success["hdbk_name"]);
				$(".show-full-hdbk").css("display", "block");

				$(".add-hdbk").on("click", function(){
					var hdbk_table = "hdbk_user_education";
					var hdbk_action = "form_add_education_full";
					$(".btn-add-hdbk").html("<button class=\"btn btn-primary add-to-hdbk\" type=\"submit\" data-action=\"add_education_full\" data-refresh=\"education_full\">Добавить</button>");
					form_add_hdbk(hdbk_table, hdbk_action);
				});			
				
				$(".edit-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-save-hdbk").html("<button class=\"btn btn-primary btn-save\" type=\"submit\" data-action=\"update_education_full\" data-refresh=\"education_full\">Сохранить</button>");
					form_edit_hdbk(hdbk_id, hdbk_table, hdbk_action); 
				});
				
				$(".delete-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-delete-hdbk").html("<button class=\"btn btn-primary btn-delete\" type=\"submit\" data-action=\"delete_education_full\" data-refresh=\"education_full\">Удалить</button>");
					form_delete_hdbk(hdbk_id, hdbk_table, hdbk_action);  
				});
				
				$('#form-edit-hdbk input').on("keyup", function(e){ $("#form-edit-hdbk .ajax-resp").html(''); });
				$('#form-delete-hdbk input').on("keyup", function(e){ $("#form-delete-hdbk .ajax-resp").html(''); });
			//	$('#form-add-hdbk input').on("keyup", function(e){ $("#form-add-hdbk .ajax-resp").html(''); });
				$('button[data-toggle="modal"]').on("click", function(e){ $(".ajax-resp").html(''); });
				
				$("#loader").css("dispaly", "none");
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
});

$("#function_full").on("click", function(e){
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: "function_full"
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				$(".response-hdbk-full").html(arr_msg.success["show_function_full"]);
				$(".hdbk-name").html(arr_msg.success["hdbk_name"]);
				$(".show-full-hdbk").css("display", "block");
				
				$(".add-hdbk").on("click", function(){
					var hdbk_table = "hdbk_user_function";
					var hdbk_action = "form_add_function_full";
					$(".btn-add-hdbk").html("<button class=\"btn btn-primary add-to-hdbk\" type=\"submit\" data-action=\"add_function_full\" data-refresh=\"function_full\">Добавить</button>");
					form_add_hdbk(hdbk_table, hdbk_action);
				});	

				$(".edit-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-save-hdbk").html("<button class=\"btn btn-primary btn-save\" type=\"submit\" data-action=\"update_function_full\" data-refresh=\"function_full\">Сохранить</button>");
					form_edit_hdbk(hdbk_id, hdbk_table, hdbk_action); 
				});
				
				$(".delete-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-delete-hdbk").html("<button class=\"btn btn-primary btn-delete\" type=\"submit\" data-action=\"delete_function_full\" data-refresh=\"function_full\">Удалить</button>");
					form_delete_hdbk(hdbk_id, hdbk_table, hdbk_action);  
				});
				
				$('#form-edit-hdbk input').on("keyup", function(e){ $("#form-edit-hdbk .ajax-resp").html(''); });
				$('#form-delete-hdbk input').on("keyup", function(e){ $("#form-delete-hdbk .ajax-resp").html(''); });
				$('button[data-toggle="modal"]').on("click", function(e){ $(".ajax-resp").html(''); });
				
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
});

$("#subdivision_full").on("click", function(e){
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: "subdivision_full"
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				$(".response-hdbk-full").html(arr_msg.success["show_subdivision_full"]);
				$(".hdbk-name").html(arr_msg.success["hdbk_name"]);
				$(".show-full-hdbk").css("display", "block");
				
				$(".add-hdbk").on("click", function(){
					var hdbk_table = "hdbk_user_subdivision";
					var hdbk_action = "form_add_subdivision_full";
					$(".btn-add-hdbk").html("<button class=\"btn btn-primary add-to-hdbk\" type=\"submit\" data-action=\"add_subdivision_full\" data-refresh=\"subdivision_full\">Добавить</button>");
					form_add_hdbk(hdbk_table, hdbk_action);
				});	

				$(".edit-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-save-hdbk").html("<button class=\"btn btn-primary btn-save\" type=\"submit\" data-action=\"update_subdivision_full\" data-refresh=\"subdivision_full\">Сохранить</button>");
					form_edit_hdbk(hdbk_id, hdbk_table, hdbk_action); 
				});
				
				$(".delete-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-delete-hdbk").html("<button class=\"btn btn-primary btn-delete\" type=\"submit\" data-action=\"delete_subdivision_full\" data-refresh=\"subdivision_full\">Удалить</button>");
					form_delete_hdbk(hdbk_id, hdbk_table, hdbk_action);  
				});
				
				$('#form-edit-hdbk input').on("keyup", function(e){ $("#form-edit-hdbk .ajax-resp").html(''); });
				$('#form-delete-hdbk input').on("keyup", function(e){ $("#form-delete-hdbk .ajax-resp").html(''); });
				$('button[data-toggle="modal"]').on("click", function(e){ $(".ajax-resp").html(''); });
				
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
});

$("#source_of_finance_full").on("click", function(e){
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: "source_of_finance_full"
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				$(".response-hdbk-full").html(arr_msg.success["show_source_of_finance_full"]);
				$(".hdbk-name").html(arr_msg.success["hdbk_name"]);
				$(".show-full-hdbk").css("display", "block");
				
				$(".add-hdbk").on("click", function(){
					var hdbk_table = "hdbk_source_of_finance";
					var hdbk_action = "form_add_source_of_finance_full";
					$(".btn-add-hdbk").html("<button class=\"btn btn-primary add-to-hdbk\" type=\"submit\" data-action=\"add_source_of_finance_full\" data-refresh=\"source_of_finance_full\">Добавить</button>");
					form_add_hdbk(hdbk_table, hdbk_action);
				});	

				$(".edit-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-save-hdbk").html("<button class=\"btn btn-primary btn-save\" type=\"submit\" data-action=\"update_source_of_finance_full\" data-refresh=\"source_of_finance_full\">Сохранить</button>");
					form_edit_hdbk(hdbk_id, hdbk_table, hdbk_action); 
				});
				
				$(".delete-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-delete-hdbk").html("<button class=\"btn btn-primary btn-delete\" type=\"submit\" data-action=\"delete_source_of_finance_full\" data-refresh=\"source_of_finance_full\">Удалить</button>");
					form_delete_hdbk(hdbk_id, hdbk_table, hdbk_action);  
				});
				
				$('#form-edit-hdbk input').on("keyup", function(e){ $("#form-edit-hdbk .ajax-resp").html(''); });
				$('#form-delete-hdbk input').on("keyup", function(e){ $("#form-delete-hdbk .ajax-resp").html(''); });
				$('button[data-toggle="modal"]').on("click", function(e){ $(".ajax-resp").html(''); });
				
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
});

$("#doc_reason_for_development_psd_full").on("click", function(e){
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: "doc_reason_for_development_psd_full"
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				$(".response-hdbk-full").html(arr_msg.success["show_doc_reason_for_development_psd_full"]);
				$(".hdbk-name").html(arr_msg.success["hdbk_name"]);
				$(".show-full-hdbk").css("display", "block");
				
				$(".add-hdbk").on("click", function(){
					var hdbk_table = "hdbk_doc_reason_for_development_psd";
					var hdbk_action = "form_add_doc_reason_for_development_psd_full";
					$(".btn-add-hdbk").html("<button class=\"btn btn-primary add-to-hdbk\" type=\"submit\" data-action=\"add_doc_reason_for_development_psd_full\" data-refresh=\"doc_reason_for_development_psd_full\">Добавить</button>");
					form_add_hdbk(hdbk_table, hdbk_action);
				});	

				$(".edit-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-save-hdbk").html("<button class=\"btn btn-primary btn-save\" type=\"submit\" data-action=\"update_doc_reason_for_development_psd_full\" data-refresh=\"doc_reason_for_development_psd_full\">Сохранить</button>");
					form_edit_hdbk(hdbk_id, hdbk_table, hdbk_action); 
				});
				
				$(".delete-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-delete-hdbk").html("<button class=\"btn btn-primary btn-delete\" type=\"submit\" data-action=\"delete_doc_reason_for_development_psd_full\" data-refresh=\"doc_reason_for_development_psd_full\">Удалить</button>");
					form_delete_hdbk(hdbk_id, hdbk_table, hdbk_action);  
				});
				
				$('#form-edit-hdbk input').on("keyup", function(e){ $("#form-edit-hdbk .ajax-resp").html(''); });
				$('#form-delete-hdbk input').on("keyup", function(e){ $("#form-delete-hdbk .ajax-resp").html(''); });
				$('button[data-toggle="modal"]').on("click", function(e){ $(".ajax-resp").html(''); });
				
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
});

$("#customers_full").on("click", function(e){
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: "customers_full"
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				$(".response-hdbk-full").html(arr_msg.success["show_customers_full"]);
				$(".hdbk-name").html(arr_msg.success["hdbk_name"]);
				$(".show-full-hdbk").css("display", "block");
				
				$(".add-hdbk").on("click", function(){
					var hdbk_table = "hdbk_customers";
					var hdbk_action = "form_add_customers_full";
					$(".btn-add-hdbk").html("<button class=\"btn btn-primary add-to-hdbk\" type=\"submit\" data-action=\"add_customers_full\" data-refresh=\"customers_full\">Добавить</button>");
					form_add_hdbk(hdbk_table, hdbk_action);
				});	

				$(".edit-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-save-hdbk").html("<button class=\"btn btn-primary btn-save\" type=\"submit\" data-action=\"update_customers_full\" data-refresh=\"customers_full\">Сохранить</button>");
					form_edit_hdbk(hdbk_id, hdbk_table, hdbk_action); 
				});
				
				$(".delete-hdbk").on("click", function(){ 
					var hdbk_id = $(this).attr("data-id");
					var hdbk_table = $(this).attr("data-table-name");
					var hdbk_action = $(this).attr("data-action");
					$(".btn-delete-hdbk").html("<button class=\"btn btn-primary btn-delete\" type=\"submit\" data-action=\"delete_customers_full\" data-refresh=\"customers_full\">Удалить</button>");
					form_delete_hdbk(hdbk_id, hdbk_table, hdbk_action);  
				});
				
				$('#form-edit-hdbk input').on("keyup", function(e){ $("#form-edit-hdbk .ajax-resp").html(''); });
				$('#form-delete-hdbk input').on("keyup", function(e){ $("#form-delete-hdbk .ajax-resp").html(''); });
				$('button[data-toggle="modal"]').on("click", function(e){ $(".ajax-resp").html(''); });
				
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
});

function form_add_hdbk(data_table, data_action){
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: data_action,
			hdbk_table: data_table
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				$("#form-add-hdbk .modal-body").html(arr_msg.success[data_action]);
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
}

$("#form-add-hdbk").on("submit", function(){
	var action_data = $(".add-to-hdbk").attr("data-action");
	var refresh_data = $(".add-to-hdbk").attr("data-refresh");
	
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: action_data,
			data: $(this).serialize()
		},
		success: function(data) {
			alert(data);
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else
			{ 
				$("#form-add-hdbk .ajax-resp").html(arr_msg.success); $('#'+refresh_data).click();
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
	return false;
});

function form_edit_hdbk(data_id, data_table, data_action){
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: data_action,
			hdbk_id: data_id,
			hdbk_table: data_table
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				$("#form-edit-hdbk .modal-body").html(arr_msg.success[data_action]);
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
}

$("#form-edit-hdbk").on("submit", function(e){
	var action_data = $(".btn-save").attr("data-action");
	var refresh_data = $(".btn-save").attr("data-refresh");
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: action_data,
			data: $(this).serialize()
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ $("#form-edit-hdbk .ajax-resp").html(arr_msg.success); $('#'+refresh_data).click(); }
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
	
	return false;
});

function form_delete_hdbk(data_id, data_table, data_action){
	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: data_action,
			hdbk_id: data_id,
			hdbk_table: data_table
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				$("#form-delete-hdbk .modal-body").html(arr_msg.success[data_action]);
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
}

$("#form-delete-hdbk").on("submit", function(e){
	var action_data = $(".btn-delete").attr("data-action");
	var refresh_data = $(".btn-delete").attr("data-refresh");

	$.ajax({
		type: 'POST',
		url: 'hdbk.ajax.php',
		data: {
			action: action_data,
			data: $(this).serialize()
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ $("#form-delete-hdbk .ajax-resp").html(arr_msg.success); $('#'+refresh_data).click(); }
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
	
	return false;
});

