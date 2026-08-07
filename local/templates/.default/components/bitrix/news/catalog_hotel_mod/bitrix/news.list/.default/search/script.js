$(function () 
{
	var show_page=0;
	
	function slider_photo_init_prefix_catalog_hotel()
	{
		var mouseDragEnabled = true;
		if ($(window).width()<1200) mouseDragEnabled = false;
		
		$(blockCatalogSelector+" .slider_images.owl-carousel").owlCarousel({
			pagination: true,
			//autoplay: true,
			nav: true,
			loop: false,
			dots: true,
			autoWidth:false,
			items: 1,
		    mouseDrag: mouseDragEnabled,
			navText : ['<svg width="24" height="24" viewBox="0 0 595.279 841.89" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"><path fill="#FFF" d="M326.391,209.918L130.01,388.8h429.494c16.132,0,29.823,16.489,29.823,32.622c0,16.133-14.882,37.74-31.015,37.74H129.95L308.712,628.58c11.489,11.428,10.239,37.979-4.286,50.658c-12.263,10.654-30.121,11.428-41.609,0L14.346,447.435c-6.132-6.131-8.751-14.227-8.334-22.264c-0.417-7.977,2.202-18.751,8.334-24.882l266.745-238.588c11.488-11.429,32.323-8.75,44.05,2.441C337.881,176.226,337.881,198.43,326.391,209.918z"/></svg>',
			           '<svg width="24" height="24" viewBox="0 0 595.279 841.89" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"><path fill="#FFF" d="M270.155,164.142c11.727-11.191,32.562-13.87,44.05-2.441L580.95,400.289c6.132,6.131,8.751,16.906,8.334,24.882c0.417,8.037-2.202,16.133-8.334,22.264L332.48,679.238c-11.488,11.428-29.347,10.654-41.609,0c-14.525-12.68-15.775-39.23-4.286-50.658l178.762-169.418H36.984c-16.133,0-31.015-21.607-31.015-37.74c0-16.132,13.691-32.622,29.823-32.622h429.494L268.905,209.918C257.416,198.43,257.416,176.226,270.155,164.142z"/></svg>'],
		});
	}
	
	/*owl item slider*/
	function slider_items_prefix_catalog_hotel()
	{
		/*$(blockCatalogSelector+" .search_result").removeClass("flex-wrap");
		$(blockCatalogSelector+" .search_result").addClass("owl-carousel owl-theme small-controls");
		
		
		var mouseDragEnabled = true;
		if ($(window).width()<1200) mouseDragEnabled = false;
		$(blockCatalogSelector+" .search_result").owlCarousel({
			pagination: true,
			//autoplay: true,
			nav: true,
			loop: false,
			dots: true,
			autoWidth:false,
		    mouseDrag: mouseDragEnabled,
			navText : ['<svg width="24" height="24" viewBox="0 0 595.279 841.89" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"><path fill="#FFF" d="M326.391,209.918L130.01,388.8h429.494c16.132,0,29.823,16.489,29.823,32.622c0,16.133-14.882,37.74-31.015,37.74H129.95L308.712,628.58c11.489,11.428,10.239,37.979-4.286,50.658c-12.263,10.654-30.121,11.428-41.609,0L14.346,447.435c-6.132-6.131-8.751-14.227-8.334-22.264c-0.417-7.977,2.202-18.751,8.334-24.882l266.745-238.588c11.488-11.429,32.323-8.75,44.05,2.441C337.881,176.226,337.881,198.43,326.391,209.918z"/></svg>',
			           '<svg width="24" height="24" viewBox="0 0 595.279 841.89" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"><path fill="#FFF" d="M270.155,164.142c11.727-11.191,32.562-13.87,44.05-2.441L580.95,400.289c6.132,6.131,8.751,16.906,8.334,24.882c0.417,8.037-2.202,16.133-8.334,22.264L332.48,679.238c-11.488,11.428-29.347,10.654-41.609,0c-14.525-12.68-15.775-39.23-4.286-50.658l178.762-169.418H36.984c-16.133,0-31.015-21.607-31.015-37.74c0-16.132,13.691-32.622,29.823-32.622h429.494L268.905,209.918C257.416,198.43,257.416,176.226,270.155,164.142z"/></svg>'],
		});*/
	}
	
	/*owl item slider*/
	slider_items_prefix_catalog_hotel();
	
	slider_photo_init_prefix_catalog_hotel();
	
	/*Ajax поиск*/
	function ajax_search_prefix_catalog_hotel(action="")
	{
		if (!on_input_change_listener) return;
		
		$(blockCatalogSelector+" .search_loader").show();
		
		data_params_str=$(blockCatalogSelector+' .form_catalog_search').serialize();
		
		if ($(blockCatalogSelector+' .view_type a.active').length > 0) {
			data_params_str+="&view_type="+$(blockCatalogSelector+' .view_type a.active').data("view");
		}
		
		var next_page=0;
		$.ajax({
			type: "POST",
			url: templateCatalogPath+"/template.php",
			data: "ajax_mode=y&page="+show_page+"&"+data_params_str,
			dataType: "html",
	        success: function(data)
			{
	        	$(blockCatalogSelector+" .search_result").prop('outerHTML', $(data).find('.search_result').prop('outerHTML'));
	        	$(blockCatalogSelector+" .paging_container").html($(data).find('.paging_container').html());
	        	
	        	show_filter_button_prefix_catalog_hotel();
	        	
	        	button_effect();
	        	$(blockCatalogSelector+" .search_loader").hide();
	        	slider_photo_init_prefix_catalog_hotel();
	        	
	        	destination = $(blockCatalogSelector).offset().top-20;
	    	    $("html, body").animate({scrollTop:destination},"slow");
	    	    $(blockCatalogSelector+" a.fancybox").fancybox({
	    	        openEffect: 'elastic',
	    	        closeEffect: 'elastic',
	    	        padding: 40
	    	    });
	    	    
	    	    /*owl item slider*/
	    	    if ($(blockCatalogSelector+' .view_type a.active').data("view")!="list")
	    	    slider_photo_init_prefix_catalog_hotel();
	    	    
			}
		});

	}
	
	/*Количество фильтров*/
	function show_filter_button_prefix_catalog_hotel()
	{
		var filter_count=0;
		//Радио, чекбоксы
		$(blockCatalogSelector+" .search_panel").find('input[type="radio"]:checked, input[type="checkbox"]:checked').each(function()
		{
			filter_count++;
		});
		//Селекты
		$(blockCatalogSelector+" .search_panel").find('select').each(function()
		{
			if ($(this).val()!='' && $(this).val()!=null)	filter_count++;
		});
		//Слайдеры
		$(blockCatalogSelector).find('.slider_container').each(function()
		{
			if ($(this).find(".slider_from").val()!=$(this).find(".slider_from").data("min").toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '))
			filter_count++;	
			
			if ($(this).find(".slider_to").val()!=$(this).find(".slider_to").data("max").toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '))
			filter_count++;	
		});
		

		if (filter_count>0)
		{
			$(blockCatalogSelector+" .clear_filter").show();
			$(blockCatalogSelector+" .clear_filter .kol").html("<span>"+filter_count+"</span>");
		}
		else
		{
			$(blockCatalogSelector+" .clear_filter").hide();
			$(blockCatalogSelector+" .clear_filter .kol").html("");
		}	
		
	}
	
	/*Очистить фильтр*/
	$(document).on('click',blockCatalogSelector+' .clear_filter', function() {
		on_input_change_listener=false;
		$(blockCatalogSelector).find('input[type="radio"], input[type="checkbox"]').prop('checked', false);
		$(blockCatalogSelector).find(".item.active").removeClass("active");
		$(blockCatalogSelector).find("select").val(null).trigger('change');
		$(blockCatalogSelector).find('.slider_container').each(function()
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
		ajax_search_prefix_catalog_hotel("clear_filter");

	});
	
	$(document).on('change', blockCatalogSelector+' .search_panel', function() 
	{
		ajax_search_prefix_catalog_hotel();
	});

	$(document).on('change', blockCatalogSelector+' .search_panel .radio_round input', function() 
	{
		var parent_container=$(this).parents(".radio_round_container");
		$(this).parents(".item").toggleClass("active");		
	});
	
	$(document).on('change', blockCatalogSelector+' .search_panel .option_button input', function() 
	{
		var parent_container=$(this).parents(".option_button_container");
		$(this).parents(".item").toggleClass("active");		
	});	
	
	/*Сортировка*/
	$(document).on('click', blockCatalogSelector+' .sort_select a', function() 
	{
		$(blockCatalogSelector+' [name="SORT_BY1"]').val($(this).data("sort_by1"));
		$(blockCatalogSelector+' [name="SORT_ORDER1"]').val($(this).data("sort_order1"));
		$(this).parents(".sort_select").find("a").removeClass("active");
		$(this).addClass("active");
		$(this).parents(".dropdown-select").find("label span").html($(this).html());
		ajax_search_prefix_catalog_hotel("sort");
	});	
	
	/*Вид*/
	$(document).on('click', blockCatalogSelector+' .view_type a', function() 
	{
		$(this).parent(".view_type").find("a").removeClass("active");
		$(this).addClass("active");
		ajax_search_prefix_catalog_hotel("view_type");
	});	
	
	/*Пейджинг*/
	$(document).on('click',blockCatalogSelector+' .paging_buttons a', function() 
	{
		if ($(this).html() == 'Следующая')
		show_page = parseInt($(this).parents(".paging_buttons").find(".active").html()) + 1;
		else show_page = $(this).html();
		ajax_search_prefix_catalog_hotel("paging");
	});
	
	/*Фильтр - показать все*/
	$(document).on('click',blockCatalogSelector+' .show_expand', function() 
	{
		$(this).parents(".filter_expand").find(".block").toggle();
		$(this).toggleClass("active");
	});
	
	
	/*Слайдер ручной ввод в input*/
	$(document).on('change', blockCatalogSelector+' .slider_data input', function() 
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
	$(document).on('change','.form_catalog_search .modul_fields .DATE_FROM, .form_catalog_search .modul_fields .DATE_TO', function() 
	{
		if ($(".form_catalog_search .modul_fields .DATE_FROM").val()!="" && $(".form_catalog_search .modul_fields .DATE_TO").val()!="")
		ajax_search_prefix_catalog_hotel();
		
	});
});