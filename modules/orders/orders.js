$(".chosen-select").chosen({width: "100%", disable_search_threshold:9});
window.onload = function(){ start_load(); $('#simple-menu').sidr(); }

$('input[name="exec_mark"]').on("click", function(){
	if ($('textarea[name="answer"]').css('display') == "none")
		$('textarea[name="answer"]').css('display', 'block');
	else
		$('textarea[name="answer"]').css('display', 'none');
});

//Добавление поручения
$("#form-add-order").on("submit", function(){
	var dataAdd = new FormData($(this)[0]);
	
	$.ajax({
		type: 'POST',
		url: 'orders.ajax.php',
		data: dataAdd,
		cache       : false,
        contentType : false,
        processData : false,
		success: function(data) {
			//alert(data);
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ 
				start_load(); $("#form-add-order .ajax-resp").html(arr_msg.success);
				$("#form-add-order")[0].reset(); $('.chosen-select').trigger("chosen:updated"); 					
			}
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
	
	return false;
});

//Обновление данных сотрудника
$("#form-edit-order").on("submit", function(e){
	var dataAdd = new FormData($(this)[0]);
	
	$.ajax({
		type: 'POST',
		url: 'orders.ajax.php',
		data: dataAdd,
		cache       : false,
        contentType : false,
        processData : false,
		success: function(data) {
			//alert(data);
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{ start_load(); $("#form-edit-order .ajax-resp").html(arr_msg.success); }
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
	
	return false;
});

//Функция удаления сотрудника
function delete_order(delete_order_id){
	$.ajax({
		type: 'POST',
		url: 'orders.ajax.php',
		data: {
			action: "delete_order",
			data: delete_order_id
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
function edit_order(edit_order_id){
	$(".exec-add").html("");
	$('input[name="counter"]').val("1");
	
	
	$.ajax({
		type: 'POST',
		url: 'orders.ajax.php',
		data: {
			action: "add_all_exec",
			data: edit_order_id
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else
			{
				//alert(arr_msg.success["all_exec"]);
				$(".exec-add").append(arr_msg.success["all_exec"]);
				//$(".exec-add").append('<div style="border: 2px dashed black; padding: 5px; margin-bottom: 10px; margin-top: 10px; width: 40%;" class="executor-block" data-id="16108"><label>ФИО исполнителя</label><button class="btn btn-default del-exec-new" type="button" style="float: right;">Удалить</button><br><div class="form-group" style="width: 60%; margin-bottom: 10px;"><select class="chosen-select executor" name="executor-1" data-placeholder="Должностное лицо (исполнитель)"></select></div><br><label>Дата исполнения</label><br><div class="form-group" style="width: 60%; margin-bottom: 10px;"><input class="form-control exec_date" style="width: 100%;" type="date" name="exec_date-1" placeholder="Дата исполнения"></div><br><label>Отметка об исполнении</label><br><div class="form-group" style="width: 5%; margin-bottom: 10px;"><input class="form-control exec_mark" style="width: 100%;" type="checkbox" name="exec_mark-1" placeholder="Дата исполнения"></div><br><div class="form-group" style="width: 100%; margin-bottom: 10px;"><input type="file" class="form-control" style="width: 100%;" name="file-por-1" placeholder="Файл поручения"></div></div>');
			}
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
	
	$("#edit-order-nav").css({"background-color": "#fff","border": "1px solid #ddd","border-bottom-color": "transparent","cursor": "default"});
	$("#add-exec-nav").css({"background-color": "#fff","border": "none"});
	$("#edit-order-nav a").css("color", "black");
	$("#add-exec-nav a").css("color", "#6196ef");
	
	$(".edit-order-div").css('display', 'block');
	$(".add-exec-div").css('display', 'none');
	
	add_executors();
	
	$(".chosen-select").chosen({width: "100%", disable_search_threshold:9});
	
	$.ajax({
		type: 'POST',
		url: 'orders.ajax.php',
		data: {
			action: "edit_order",
			data: edit_order_id
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{
				$('#form-edit-order input[name="order_id"]').val(arr_msg.success[0]['id']);
				$('#form-edit-order input[name="topic"]').val(arr_msg.success[0]['topic']);
				$('#form-edit-order input[name="income_date"]').val(arr_msg.success[0]['income_date']);
				$('#form-edit-order input[name="reg_num"]').val(arr_msg.success[0]['reg_num']);
				$('#form-edit-order select[name="corr"]').val(arr_msg.success[0]['corr']);
				$('#form-edit-order select[name="doc_type"]').val(arr_msg.success[0]['id_doc_type']);
				
				$('#redact').html(arr_msg.success[0]['reg_num']);
				
				$('.chosen-select').trigger("chosen:updated");
				
			}
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
}

function show_alert_msg() {
	$.ajax({
		type: 'POST',
		url: 'orders.ajax.php',
		data: {
			action: "show_alert_msg"
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{
				if ((arr_msg.success["alert_msg"]["login"] == "Shakh-A") || (arr_msg.success["alert_msg"]["login"] == "Portnov-V"))
				{
					$(".btn-show-exec-expired").click();
					$(".exec-expired-text").html(arr_msg.success["alert_msg"]["html"] + "\n");
				}
			}
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
}

function start_load(){
	$('input[name="exec_mark"]').attr('checked', false);
	
	$.ajax({
		type: 'POST',
		url: 'orders.ajax.php',
		data: {
			action: "start_load"
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{
				$('.orders-data').html(arr_msg.success['orders_table']);
				
				$(".delete_order").on("click", function(e){ delete_order($(this).attr("data-order-id")); });
				$(".edit_order").on("click", function(e){ edit_order($(this).attr("data-order-id")); });
				$(".show_exec").on("click", function(e){ show_executors($(this).attr("data-order-id")); });
				
				$('select[name="doc_type"]').html(arr_msg.success["doc_type_list"]);
				$('select[name="corr"]').html(arr_msg.success["corr_list"]);
				$('select[name="executor"]').html(arr_msg.success["executor_list"]);
				$('select[name="position"]').html(arr_msg.success["position_list"]);
				
				$('button[data-toggle="modal"]').on("click", function(e){ $('.chosen-select').trigger("chosen:updated"); $(".ajax-resp").html(''); });
			}

		}
	});
	
	show_alert_msg();
}

function show_executors(exec_id){
	$(".view-order-div").css('display', 'block');
	$(".view-exec-div").css('display', 'none');
	$("#view-order-nav").css({"background-color": "#fff","border": "1px solid #ddd","border-bottom-color": "transparent","cursor": "default"});
	$("#view-exec-nav").css({"background-color": "#fff","border": "none"});
	$("#view-order-nav a").css("color", "black");
	$("#view-exec-nav a").css("color", "#6196ef");
	
	//alert(exec_id);
	
	$.ajax({
		type: 'POST',
		url: 'orders.ajax.php',
		data: {
			action: "show_executors",
			data: exec_id
		},
		success: function(data) {
			//alert(data);
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{
				$('.executors-data').html(arr_msg.success['executors_table']);
				$(".table-executors").css('display', 'block');
				$("#prosmotr").html(arr_msg.success['reg_num']);
				$('button[data-toggle="modal"]').on("click", function(e){ $('.chosen-select').trigger("chosen:updated"); $(".ajax-resp").html(''); });
			}

		}
	});
	
	$.ajax({
		type: 'POST',
		url: 'orders.ajax.php',
		data: {
			action: "show_orders_table",
			data: exec_id
		},
		success: function(data) {
			//alert(data);
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{
				$('.one-order').html(arr_msg.success['show_order']);
			}

		}
	});	
}

function add_executors(){
	$.ajax({
		type: "POST",
		url: "orders.ajax.php",
		data: {
			action: "add-executors"
		},
		success: function(data) {
			var arr_msg = jQuery.parseJSON(data);
			if( arr_msg.error != "" ){
				console.log(arr_msg.error);
			}
			else{
				$('select[name^="executor"]').append(arr_msg.success['executor_list']);
				$(".chosen-select").chosen({width: "100%", disable_search_threshold:9});
			}

		}
	}); 
}

$("#add-executor-btn").on("click", function(e){
	$("#startup").css("display", "none");
	var ctr = $('input[name="counter"]').val();
	//$(".exec-add").append('<div style="border: 2px dashed black; padding: 5px; margin-bottom: 10px; margin-top: 10px; width: 40%;" class="executor-block" data-id="16108"><label>ФИО исполнителя</label><button class="btn btn-default del-exec-new" type="button" style="float: right;">Удалить</button><br><div class="form-group" style="width: 60%; margin-bottom: 10px;"><select class="chosen-select executor" name="executor" data-placeholder="Должностное лицо (исполнитель)"></select></div><br><label>Дата исполнения</label><br><div class="form-group" style="width: 60%; margin-bottom: 10px;"><input class="form-control exec_date" style="width: 100%;" type="date" name="exec_date" placeholder="Дата исполнения"></div><br><label>Отметка об исполнении</label><br><div class="form-group" style="width: 5%; margin-bottom: 10px;"><input class="form-control exec_mark" style="width: 100%;" type="checkbox" name="exec_mark" placeholder="Дата исполнения"></div></div>');
	$(".exec-add").append('<div style="border: 2px dashed black; padding: 5px; margin-bottom: 10px; margin-top: 10px; width: 40%;" class="executor-block" data-id="16108"><label>ФИО исполнителя</label><button class="btn btn-default del-exec-new" type="button" style="float: right;">Удалить</button><br><div class="form-group" style="width: 60%; margin-bottom: 10px;"><select class="chosen-select executor" name="executor" data-placeholder="Должностное лицо (исполнитель)"></select></div><br><label>Дата исполнения</label><br><div class="form-group" style="width: 60%; margin-bottom: 10px;"><input class="form-control exec_date" style="width: 100%;" type="date" name="exec_date" placeholder="Дата исполнения"></div><br><label>Отметка об исполнении</label><br><div class="form-group" style="width: 5%; margin-bottom: 10px;"><input class="form-control exec_mark" style="width: 100%;" type="checkbox" name="exec_mark" placeholder="Дата исполнения"></div><br><label>Файл поручения</label><br><div class="form-group" style="width: 100%; margin-bottom: 10px;"><input type="file" class="btn btn-default" name="file-por" data-placeholder="Документ"></input></div></div>');
	
	$(".del-exec-new").on("click", function(){
		$('.executor-block[data-id="16108"]').fadeOut();
	});
	
//	if ($("input").is(".very-last-counter"))
//	{
		$('input[name="counter"]').val($('.very-last-counter:last').val());
		var ctr = $('input[name="counter"]').val();
		ctr++;
//	}
/*	else
	{
		var ctr = $('input[name="counter"]').val();
		ctr++;
	}
	*/
	add_executors();
	$('select[name="executor"]').attr('name', 'executor-' + ctr);
	$('input[name="exec_date"]').attr('name', 'exec_date-' + ctr);
	$('input[name="exec_mark"]').attr('name', 'exec_mark-' + ctr);
	$('input[name="file-por"]').attr('name', 'file-por-' + ctr);
	
	$('input[name="counter"]').val(ctr);
});

$("#edit-order-nav").on("click", function(){
	$(".edit-order-div").css('display', 'block');
	$(".add-exec-div").css('display', 'none');
	$("#edit-order-nav").css({"background-color": "#fff","border": "1px solid #ddd","border-bottom-color": "transparent","cursor": "default"});
	$("#add-exec-nav").css({"background-color": "#fff","border": "none"});
	$("#edit-order-nav a").css("color", "black");
	$("#add-exec-nav a").css("color", "#6196ef");
});

$("#add-exec-nav").on("click", function(){
	$(".add-exec-div").css("display", "block");
	$(".edit-order-div").css("display", "none");
	$("#add-exec-nav").css({"background-color": "#fff","border": "1px solid #ddd","border-bottom-color": "transparent","cursor": "default"});
	$("#edit-order-nav").css({"background-color": "#fff","border": "none"});
	$("#add-exec-nav a").css("color", "black");
	$("#edit-order-nav a").css("color", "#6196ef");
	
	$(".del-exec").on("click", function(){
		var exec_id = $(this).attr("data-id");
		
		$('.executor-block[data-id="'+exec_id+'"]').fadeOut();
		$.ajax({
			type: "POST",
			url: "orders.ajax.php",
			data: {
				action: "delete-exec",
				exec_id: exec_id
			},
			success: function(){
				//---
			},
			error: function(xhr, str){
				alert('Возникла ошибка: ' + xhr.responseCode);
			}
		});
		
	});
});

$("#view-order-nav").on("click", function(){
	$(".view-order-div").css('display', 'block');
	$(".view-exec-div").css('display', 'none');
	$("#view-order-nav").css({"background-color": "#fff","border": "1px solid #ddd","border-bottom-color": "transparent","cursor": "default"});
	$("#view-exec-nav").css({"background-color": "#fff","border": "none"});
	$("#view-order-nav a").css("color", "black");
	$("#view-exec-nav a").css("color", "#6196ef");
});

$("#view-exec-nav").on("click", function(){
	$(".view-exec-div").css("display", "block");
	$(".view-order-div").css("display", "none");
	$("#view-exec-nav").css({"background-color": "#fff","border": "1px solid #ddd","border-bottom-color": "transparent","cursor": "default"});
	$("#view-order-nav").css({"background-color": "#fff","border": "none"});
	$("#view-exec-nav a").css("color", "black");
	$("#view-order-nav a").css("color", "#6196ef");
});

$(".delete_exec").on("click", function(){
	$.ajax({
		type: 'POST',
		url: 'orders.ajax.php',
		data: {
			action: "delete_exec",
			data: delete_order_id
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
});