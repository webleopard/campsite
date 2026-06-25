$(function () 
{
	var show_page=0;

	/*-----ADD_EDIT----*/
	$('#add_edit_form').submit(function() {
		var empty_cnt=0;
	    var source_form=$(this).parents(".add_edit_form");
		
		$(source_form).find('input, textarea').each(function() 
		{
			if ($(this).val()!='')
			{
				$(this).removeClass('alert');
			}
			else
			{
				if ($(this).attr("placeholder")!=undefined && $(this).attr("placeholder").indexOf("*")>-1)
				{
					$(this).addClass('alert');
					empty_cnt++;
				}
			}
		});
		
		if (empty_cnt==0)
		{
			data_params_str=$('.add_edit_form').serialize();
			
			$.ajax({
				type: "POST",
				url: templateCatalogPath_ModulAdmin+"/item_edit/ajax_edit.php",
				data: "ajax_mode=y&iblock_id="+iblock_reserve_id+"&"+data_params_str,
				dataType: 'json',
		        success: function(data)
				{
		        	
		        	if (data.error!="" && data.error!=undefined)
		        	{
		        		popup_message("", data.error);
		        	}
		        	else
		        	{
		        		ajax_search_prefix_module_admin();
		        		$("#add_edit_form .fancybox-close-small").trigger("click");
		        	}
				}
			});
		}
		
		 
	});
	$(document).on('click','.add_edit_form .delete_item', function() {
		if (confirm(add_edit_del_confirm))
		{
			$.ajax({
				type: "POST",
				url: templateCatalogPath_ModulAdmin+"/item_edit/ajax_edit.php",
				data: "ajax_mode=y&action=delete&id="+$(this).data("id")+"&iblock_id="+iblock_reserve_id,
				dataType: 'json',
		        success: function(data)
				{
		        	if (data.error!="" && data.error!=undefined)
		        	{
		        		popup_message("", data.error);
		        	}
		        	else
		        	{
		        		ajax_search_prefix_module_admin();
		        		$("#add_edit_form .fancybox-close-small").trigger("click");
		        	}
				}
			});
		}

	});
	/*-----ADD_EDIT----*/
	
	
	/*Ajax поиск*/
	function ajax_search_prefix_module_admin(action="")
	{
		if (!on_input_change_listener) return;
		
		$(blockCatalogSelectorModulAdmin+" .search_loader").show();
		
		data_params_str=$(blockCatalogSelectorModulAdmin+' .form_catalog_search').serialize();
		
		if ($(blockCatalogSelectorModulAdmin+' .view_type a.active').length > 0) {
			data_params_str+="&view_type="+$(blockCatalogSelectorModulAdmin+' .view_type a.active').data("view");
		}
		
		var next_page=0;
		$.ajax({
			type: "POST",
			url: templateCatalogPath_ModulAdmin+"/template.php",
			data: "ajax_mode=y&page="+show_page+"&"+data_params_str,
			dataType: "html",
	        success: function(data)
			{
	        	$(blockCatalogSelectorModulAdmin+" .search_result").prop('outerHTML', $(data).find('.search_result').prop('outerHTML'));
	        	$(blockCatalogSelectorModulAdmin+" .paging_container").html($(data).find('.paging_container').html());
	        	
	        	show_filter_button_prefix_catalog_hotel();
	        	
	        	button_effect();
	        	$(blockCatalogSelectorModulAdmin+" .search_loader").hide();
	        	
	        	/*destination = $(blockCatalogSelectorModulAdmin).offset().top-20;
	    	    $("html, body").animate({scrollTop:destination},"slow");
	    	    $(blockCatalogSelectorModulAdmin+" a.fancybox").fancybox({
	    	        openEffect: 'elastic',
	    	        closeEffect: 'elastic',
	    	        padding: 40
	    	    });*/
	        	
	        	$('.right_col_content').dragScroll({
	                direction: 'scrollLeft'
	            });
	    	    
	    	    
			}
		});

	}
	
	/*Количество фильтров*/
	function show_filter_button_prefix_catalog_hotel()
	{
		var filter_count=0;
		//Радио, чекбоксы
		$(blockCatalogSelectorModulAdmin+" .search_panel").find('input[type="radio"]:checked, input[type="checkbox"]:checked').each(function()
		{
			filter_count++;
		});
		//Селекты
		$(blockCatalogSelectorModulAdmin+" .search_panel").find('select').each(function()
		{
			if ($(this).val()!='' && $(this).val()!=null)	filter_count++;
		});
		//Слайдеры
		$(blockCatalogSelectorModulAdmin).find('.slider_container').each(function()
		{
			if ($(this).find(".slider_from").val()!=$(this).find(".slider_from").data("min").toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '))
			filter_count++;	
			
			if ($(this).find(".slider_to").val()!=$(this).find(".slider_to").data("max").toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '))
			filter_count++;	
		});
		

		if (filter_count>0)
		{
			$(blockCatalogSelectorModulAdmin+" .clear_filter").show();
			$(blockCatalogSelectorModulAdmin+" .clear_filter .kol").html("<span>"+filter_count+"</span>");
		}
		else
		{
			$(blockCatalogSelectorModulAdmin+" .clear_filter").hide();
			$(blockCatalogSelectorModulAdmin+" .clear_filter .kol").html("");
		}	
		
	}
	
	/*Очистить фильтр*/
	$(document).on('click',blockCatalogSelectorModulAdmin+' .clear_filter', function() {
		on_input_change_listener=false;
		$(blockCatalogSelectorModulAdmin).find('input[type="radio"], input[type="checkbox"]').prop('checked', false);
		$(blockCatalogSelectorModulAdmin).find(".item.active").removeClass("active");
		$(blockCatalogSelectorModulAdmin).find("select").val(null).trigger('change');
		$(blockCatalogSelectorModulAdmin).find('.slider_container').each(function()
		{
			var options = $(this).find(".slider").slider('option');

			$(this).find(".slider_from").val(options.min.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
			$(this).find(".slider_to").val(options.max.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
			
			$(this).find("input[data-input='slider_from']").val(options.min);
			$(this).find("input[data-input='slider_to']").val(options.max);
			
			$(this).find(".slider").slider('values', [options.min, options.max]);  
		});
		on_input_change_listener=true;
		
		$(this).hide();
		show_page=0;
		ajax_search_prefix_module_admin("clear_filter");

	});
	
	$(document).on('change', blockCatalogSelectorModulAdmin+' .search_panel', function() 
	{
		ajax_search_prefix_module_admin();
	});
	$(document).on('change', blockCatalogSelectorModulAdmin+' .search_panel .radio_round input', function() 
	{
		var parent_container=$(this).parents(".radio_round_container");
		
		if ($(parent_container).hasClass("yes_no_input"))
		{
			$(parent_container).find(".item").removeClass("active");
			$(parent_container).find("input").not(this).prop('checked', false);
		}
		
		if ($(this).prop('checked')==true)
		$(this).parents(".item").addClass("active");	
		else 
		$(this).parents(".item").removeClass("active");
	});
	
	$(document).on('change', blockCatalogSelectorModulAdmin+' .search_panel .option_button input', function() 
	{
		var parent_container=$(this).parents(".option_button_container");
		$(this).parents(".item").toggleClass("active");		
	});	
	
	/*Сортировка*/
	$(document).on('click', blockCatalogSelectorModulAdmin+' .sort_select a', function() 
	{
		$(blockCatalogSelectorModulAdmin+' [name="SORT_BY1"]').val($(this).data("sort_by1"));
		$(blockCatalogSelectorModulAdmin+' [name="SORT_ORDER1"]').val($(this).data("sort_order1"));
		$(this).parents(".sort_select").find("a").removeClass("active");
		$(this).addClass("active");
		$(this).parents(".dropdown-select").find("label span").html($(this).html());
		ajax_search_prefix_module_admin("sort");
	});	
	
	/*Вид*/
	$(document).on('click', blockCatalogSelectorModulAdmin+' .view_type a', function() 
	{
		$(this).parent(".view_type").find("a").removeClass("active");
		$(this).addClass("active");
		ajax_search_prefix_module_admin("view_type");
	});	
	
	/*Пейджинг*/
	$(document).on('click',blockCatalogSelectorModulAdmin+' .paging_buttons a', function() 
	{
		if ($(this).html() == 'Следующая')
		show_page = parseInt($(this).parents(".paging_buttons").find(".active").html()) + 1;
		else show_page = $(this).html();
		ajax_search_prefix_module_admin("paging");
	});
	
	/*Фильтр - показать все*/
	$(document).on('click',blockCatalogSelectorModulAdmin+' .show_expand', function() 
	{
		$(this).parents(".filter_expand").find(".block").toggle();
		$(this).toggleClass("active");
	});
	
	
	/*Слайдер ручной ввод в input*/
	$(document).on('change', blockCatalogSelectorModulAdmin+' .slider_data input', function() 
	{
		var slide_min_input=$(this).parents(".slider_data").find(".slider_from");
		var slide_max_input=$(this).parents(".slider_data").find(".slider_to");
		
		var slide_min_slider_val=$(this).parents(".slider_data").find("[data-input='slider_from']").val();
		var slide_max_slider_val=$(this).parents(".slider_data").find("[data-input='slider_to']").val();
		
	
		
		/*min*/
		var min_input_val=slide_min_input.val().replace(/[^0-9.]/g, '');
		if (min_input_val>0 && min_input_val<$(slide_min_input).data("min"))
		min_input_val=$(slide_min_input).data("min");

		
		if (min_input_val>0 && Number(min_input_val)>Number(slide_max_slider_val))
		min_input_val=slide_max_slider_val;
		slide_min_input.data("inp_val",min_input_val);
		$(this).parents(".slider_data [data-input='slider_from']").val(min_input_val);
		
		$(slide_min_input).val((min_input_val+'').replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));

		/*max*/
		var max_input_val=slide_max_input.val().replace(/[^0-9.]/g, '');
		if ( max_input_val>0 && max_input_val>$(slide_max_input).data("max"))
		max_input_val=$(slide_max_input).data("max");

		if (max_input_val>0 && Number(max_input_val)<Number(slide_min_slider_val))
		max_input_val=slide_min_slider_val;
		slide_max_input.data("inp_val",max_input_val);
		$(this).parents(".slider_data [data-input='slider_to']").val(max_input_val);
		
		$(slide_max_input).val((max_input_val+'').replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
		
	});
	
	
	/*Модуль*/  
	$(document).on('change','.form_catalog_search .modul_fields .DATE_START, .form_catalog_search .modul_fields .DATE_END', function() 
	{
		if ($(".form_catalog_search .modul_fields .DATE_START").val()!="" && $(".form_catalog_search .modul_fields .DATE_END").val()!="")
		ajax_search_prefix_module_admin();
		
	});
});