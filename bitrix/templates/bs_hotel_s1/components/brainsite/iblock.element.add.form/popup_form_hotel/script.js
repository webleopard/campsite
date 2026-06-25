$(function() 
{
	var reserv_disabled=false;
	
	
	$(document).on('change','.popup_form_hotel input[data-code=DATE_FROM], .popup_form_hotel input[data-code=DATE_TO]', function() 
	{
		var source_form=$(".popup_form_hotel");
		if ($('.popup_form_hotel input[data-code=DATE_FROM]').val()!="" &&  $('.popup_form_hotel input[data-code=DATE_TO]').val()!="")
		{
			var formData = $(".popup_form_hotel").serialize();
			$(".popup_form_hotel .info_text").remove();
			
			$.ajax({
			   	type: "POST",
			   	url: SITE_TEMPLATE_PATH+"/include/ajax/ajax_modul_form.php",
			   	data: formData+"&COMPONENT_PATH_FORM_HOTEL="+COMPONENT_PATH_FORM_HOTEL+"&SITE_TEMPLATE_PATH="+SITE_TEMPLATE_PATH+"&DATE_FROM="+$('.popup_form_hotel input[data-code=DATE_FROM]').val()+"&DATE_TO="+$('.popup_form_hotel input[data-code=DATE_TO]').val(),
			   	dataType: 'json',
			   	success: function(data){
			   		var info_text="";
			   		if (data.date_alert=="Y")
			   		{
			   			$('.popup_form_hotel input[data-code=DATE_FROM]').addClass("alert");
			   			$('.popup_form_hotel input[data-code=DATE_TO]').addClass("alert");
			   		}
			   		
			   		if (data.ROOM_ID>0)
			   		$('.popup_form_hotel input[name=ROOM_ID]').val(data.ROOM_ID);	
			   		
			   		if (data.date_alert=="N")
			   		{
			   			$('.popup_form_hotel input[data-code=DATE_FROM]').removeClass("alert");
			   			$('.popup_form_hotel input[data-code=DATE_TO]').removeClass("alert");
			   			info_text+="<div><b>"+data.days+"<b></div>";
			   			
			   		}
			   		if (data.ROOM_COUNT_INFO!="" && data.ROOM_COUNT_INFO!=undefined)
			   		{
			   			info_text+="<div><b>"+data.ROOM_COUNT_INFO+"<b></div>";
			   		}
			   		
			   		if (info_text!="") 
			   		{
			   			info_text="<div class='clear'></div><div class='info_text'>"+info_text+"</div>";
			   			$(".form_field_DATE_TO").after(info_text);
			   		}
			   		
			   		if (data.MODUL_DISABLED_ORDER=="Y")
			   		{
			   			$('.popup_form_hotel .btn').addClass("disabled"); 
			   			$('.popup_form_hotel .btn').parents(".btn_container").addClass("disabled");
			   		}
			   		else
			   		{
			   			$('.popup_form_hotel .btn').removeClass("disabled"); 
			   			$('.popup_form_hotel .btn').parents(".btn_container").removeClass("disabled");
			   		}
				}
			});
		}

	});
	
	$(".popup_form_hotel .send_form_wrapper").click(function() 
	{
		if ($(this).hasClass("disabled")) return;
		
		
		var empty_cnt=0;
		var source_form=$(this).parents(".popup_form_hotel");
		
		$(source_form).find('input, textarea').each(function() {
			if ($(this).val()!='')
			{
				$(this).removeClass('alert');
			}
			else
			{
				if ($(this).attr("placeholder")!=undefined && $(this).attr("placeholder").indexOf("*")>-1)
				/*if ($(this).parents('.place').find('label').length)
				if ($(this).parents('.place').find('label').html().indexOf("*")>-1)*/
				{
					$(this).addClass('alert');
					empty_cnt++;
				}
				
			}
		
		});
		
		/*Согласие на обработку*/
		$(source_form).find('.licence_block').removeClass('alert');
		if ($(source_form).find('.licence_block input[type=checkbox]').length && !$(source_form).find('.licence_block input[type=checkbox]').is(':checked'))
		{
			empty_cnt++;
			$(source_form).find('.licence_block').addClass('alert');
		}
		else $(source_form).find('.licence_block').removeClass('alert');
		
		/*Проверка даты*/
		var date_field=$(source_form).find('input[data-code=DATE_FROM]');
		var pattern =/^(\d{1,2})(\.)(\d{1,2})(\.)(\d{4})$/;
		if ($(date_field).val()!="")
		{
			var date_val=$(date_field).val();
			
			if(date_val.search(pattern) == 0)
			{
				
			}
			else
			{
				$(date_field).addClass('alert');
				empty_cnt++;
			}
		}
		var date_field=$(source_form).find('input[data-code=DATE_TO]');
		var pattern =/^(\d{1,2})(\.)(\d{1,2})(\.)(\d{4})$/;
		if ($(date_field).val()!="")
		{
			var date_val=$(date_field).val();
			
			if(date_val.search(pattern) == 0)
			{
				
			}
			else
			{
				$(date_field).addClass('alert');
				empty_cnt++;
			}
		}
		
		
		/*Проверка email*/
		var email_field=$(source_form).find('input[data-code=EMAIL]');
		var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}$/i;
		if ($(email_field).val()!="")
		{
			var mail=$(email_field).val();
			
			if(mail.search(pattern) == 0)
			{
				
			}
			else
			{
				$(email_field).addClass('alert');
				empty_cnt++;
			}
		}
		
		
		
		if (empty_cnt==0)
		{
			$(source_form).find(".submit_input").trigger("click");
		}
		
	
	});
});