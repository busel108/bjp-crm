$(".chosen-select").chosen({width: "100%", disable_search_threshold:9});
$(document).ready(function(){ start_load(); $('#simple-menu').sidr(); });

function ajax(data){
	var result = "";
	
	response = $.ajax({
        type: 'POST',
        url: 'planning.ajax_3.php',
        async: false,
        data: { 
			action: data[0],
			data: data[1]
		},
        dataType: 'json',
    }).responseText;
	console.log(response);
	result = $.parseJSON(response);
	
    return result;
}

function start_load(){
	var subdivision_list = ajax(["start_load", ""]);

	if( subdivision_list.error != "" ){ 
		console.log(subdivision_list.error); 
	}
	else{
	//	alert(subdivision_list.success["percent"]);
		$('select[name="subdivision_list"]').html(subdivision_list.success['subdivision_list']);
		$('select[name="subdivision_list"]').trigger("chosen:updated");		
	}
	
	$('select[name="subdivision_list"]').on("change", function(e){ select_subdivision(this); });
}

function select_subdivision(src){
	var obj_list = ajax(["obj_list", $(src).val()]);
	
	if( obj_list.error != "" ){ 
		console.log(obj_list.error); 
	}
	else{
		//console.log(obj_list.success['obj_list']);
		$("#show_obj_list").html(obj_list.success['obj_list']);	
	}
	
	$('.btn-view-obj').on("click", function(e){ btn_view_obj(this); });
	$('.btn-edit-obj').on("click", function(e){ btn_edit_obj(this); });
}

function btn_view_obj(src){
	var obj_id = $(src).attr("data-obj-id");
	var subdivision_id = $(src).attr("data-subdivision-id");
	
	var data = {};
	data.obj_id = obj_id;
	data.subdivision_id = subdivision_id;
	
	var view_obj = ajax(["btn_view_obj", data]);
	
	if( view_obj.error != "" ){ 
		console.log(view_obj.error); 
	}
	else{
		$("#response-view-obj").html(view_obj.success["user_subdivision"]);	
		$("#edit-obj").css("display", "none");
		$("#view-obj").css("display", "block");
		
		chart_show(obj_id);
	}
}

function btn_edit_obj(src){
	var obj_id = $(src).attr("data-obj-id");
	var subdivision_id = $(src).attr("data-subdivision-id");
	
	var data = {};
	data.obj_id = obj_id;
	data.subdivision_id = subdivision_id;
	
	var edit_obj = ajax(["btn_edit_obj", data]);
	
	if( edit_obj.error != "" ){ 
		console.log(edit_obj.error); 
	}
	else{
		$("#response-edit-obj").html(edit_obj.success["user_subdivision"]);	
		$("#view-obj").css("display", "none");
		$("#edit-obj").css("display", "block");
	//	$(".btn-add-name-jobs").on("click", function(){btn_add_name_jobs(this);});
	//	$(".btn-add-jobs-percent").on("click", function(){btn_add_jobs_percent(this);});
	
		$("#form-add-jobs-percent").on("submit", function(e){form_add_jobs_percent(this, obj_id); return false;});
	}
	
}

function btn_add_name_jobs(src) {
	var user_id = $(src).attr("data-user-id");
	var obj_id = $(src).attr("data-obj-id");
	var name_job = $("#input-add-name-jobs-" + user_id).val();
	
	//alert(user_id+" "+obj_id+" "+name_job);
	var data = {};
	data.user_id = user_id;
	data.obj_id = obj_id;
	data.name_job = name_job;
	
	var add_name_jobs = ajax(["add_name_jobs", data]);
	
	if( add_name_jobs.error != "" ){ 
		console.log(add_name_jobs.error); 
	}
	else{
		alert("it works!");
	//	$("#response-edit-obj").html(edit_obj.success["user_subdivision"]);	
	//	$("#view-obj").css("display", "none");
	//	$("#edit-obj").css("display", "block");
	//	$(".btn-add-name-jobs").on("click", function(){add_name_jobs(this);});
	}
	
}

function btn_add_jobs_percent(src) {
	var user_id = $(src).attr("data-user-id");
	var obj_id = $(src).attr("data-obj-id");
	var percent = $("#input-add-percent-" + user_id).val();
	var name_job = $("#input-add-name-jobs-" + user_id).val();
	
	var data = {};
	data.user_id = user_id;
	data.obj_id = obj_id;
	data.percent = percent;
	
	var add_percent = ajax(["add_percent", data]);
	
	if( add_percent.error != "" ){ 
		console.log(add_percent.error); 
	}
	else{
		alert("it works!");
	//	$("#response-edit-obj").html(edit_obj.success["user_subdivision"]);	
	//	$("#view-obj").css("display", "none");
	//	$("#edit-obj").css("display", "block");
	//	$(".btn-add-name-jobs").on("click", function(){add_name_jobs(this);});
	}
	
}

function form_add_jobs_percent(src, obj_id)
{
	$.ajax({
		type: 'POST',
		url: 'planning.ajax_3.php',
		data: {
			data: $(src).serialize(),
			action: 'add_jobs_percent'
		},
		error: function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		},
		success: function(data) {
			$(".btn-edit-obj[data-obj-id="+obj_id+"]").click();
		}
		
	});
		return false;
}

function chart_show(obj_id)
{
	$.ajax({
		type: 'POST',
		url: 'planning.ajax_3.php',
		data: {
			action: 'view_chart',
			object_id: obj_id 
		},
		success: function(data) {
			
			var msg = jQuery.parseJSON(data);
			
			var series_data_plan = [];
			var series_data_fact = [];
			
			var options = {
				year: 'numeric',
				month: 'long',
				day: 'numeric'
			};
			
			for (var i = 0; i < msg["dates_plan"].length; i++)
				series_data_plan.push([Date.UTC(msg["dates_plan"][i][0], msg["dates_plan"][i][1]-1, msg["dates_plan"][i][2]), i]);
			
			
			for (var i = 0; i < msg["dates_fact"].length; i++)
				series_data_fact.push([Date.UTC(msg["dates_fact"][i][0], msg["dates_fact"][i][1]-1, msg["dates_fact"][i][2]), i]);
			
			Highcharts.chart('container', {
				title: {
					text: 'График плановых и фиктических дат проектирования'
				},

				subtitle: {
					text: ''
				},

				xAxis: {
					type: 'datetime'
				},
				
				yAxis: {
					title: {
						text: ''
					},
					categories: msg["stages"]
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle'
				},

				series: [{
					name: "Планируемые даты проектирования",
					data: series_data_plan
				},
				{
					name: "Фактические даты проектирования",
					data: series_data_fact
				}
				]

			});
		}
	});
	
}