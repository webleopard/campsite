$.datepicker.regional['ru'] =
{
	closeText: 'Закрыть',
	prevText: '&#x3c;Пред',
	nextText: 'След&#x3e;',
	currentText: 'Сегодня',
	monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
	'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
	monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
	'Июл','Авг','Сен','Окт','Ноя','Дек'],
	dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
	dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
	dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
	dateFormat: 'dd.mm.yy',
	firstDay: 1,
	isRTL: false
};



$(function () 
{	
	/*Get edit form*/
	$(document).on('click','.reserv_item', function() {
		
		if ($(this).data("id")>0)
		$.ajax({
			type: "POST",
			url: templateCatalogPath_ModulAdmin+"/item_edit/ajax_get_form.php",
			data: "id="+$(this).data("id")+"&categ_id="+$(this).data("categ_id")+"&iblock_reserve_id="+iblock_reserve_id,
			dataType: "html",
	        success: function(data)
			{
	        	$("#add_edit_form .popup_content").html(data);
	    	  
	        	$.fancybox.open({src: '#add_edit_form', type: 'inline', 'touch' : false});
	        	
	        	$('#add_edit_form input[name="PHONE"]').mask("+7 (999) 999-9999");
		    	$('#add_edit_form input[name="PHONE"][required]').attr("placeholder", "+7 (999) 999-9999 *");
		    	$('#add_edit_form input[name="PHONE"]').not('[required]').attr("placeholder", "+7 (999) 999-9999");	
	        	
	        	$.datepicker.setDefaults($.extend($.datepicker.regional["ru"]));
	        	$("[name=DATE_FROM]").datepicker({}); 
	   
			}
		});
	});
	
	/*Get add form*/
	$(document).on('click','.room_line .active', function() {
		
		if ($(this).data("room_id")>0)
		$.ajax({
			type: "POST",
			url: templateCatalogPath_ModulAdmin+"/item_edit/ajax_get_form.php",
			data: "room_id="+$(this).data("room_id")+"&date="+$(this).data("date")+"&categ_id="+$(this).data("categ_id")+"&iblock_reserve_id="+iblock_reserve_id,
			dataType: "html",
	        success: function(data)
			{
	        	$("#add_edit_form .popup_content").html(data);

	        	$.fancybox.open({src: '#add_edit_form', type: 'inline', 'touch' : false});
	        	
	        	$('#add_edit_form input[name="PHONE"]').mask("+7 (999) 999-9999");
		    	$('#add_edit_form input[name="PHONE"][required]').attr("placeholder", "+7 (999) 999-9999 *");
		    	$('#add_edit_form input[name="PHONE"]').not('[required]').attr("placeholder", "+7 (999) 999-9999");	
	        	
	        	$.datepicker.setDefaults($.extend($.datepicker.regional["ru"]));
	        	$("[name=DATE_FROM]").datepicker({}); 
	   
			}
		});
	});
	

});
