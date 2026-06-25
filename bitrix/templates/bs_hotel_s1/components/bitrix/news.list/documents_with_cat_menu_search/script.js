$(function() {
	
	/*Фильтр меню*/
	$(document).on('click','.documents_block .cat_menu a', function() 
	{
		
		$(this).parents(".documents_block").find(".section_block").show();
		$(this).parents(".documents_block").find(".section_block .item").show();
		$(this).parents(".documents_block").find(".search input").val("");
		
		
		$(this).parents(".documents_block .cat_menu").find(">a").removeClass("active");
		//$(this).parents(".documents_block").find(".section_block .top_air").removeClass("d-none");
		$(this).addClass("active");
		
		
		$(this).parents(".documents_block").find(".section_block").hide();
		
		var target_block=$(this).parents(".documents_block").find(".section_block[data-id='"+$(this).data("id")+"']");
		$(target_block).show();
		var parents = $(target_block).parents(".section_block");
		for (var i = parents.length-1; i >= 0; i--) 
		{
			$(parents[i]).show();
		}
		
		$(this).parents(".documents_block").find(".section_block[data-id='"+$(this).data("id")+"']").parents(".section_block>:last").show();
		//$(this).parents(".documents_block").find(".section_block[data-id='"+$(this).data("id")+"'] .top_air").addClass("d-none");
		
		/*Показать все*/
		$(this).parents(".documents_block .cat_menu").find(".show_all").show();
		if ($(this).hasClass("show_all"))
		{
			$(this).hide();
			$(this).parents(".documents_block").find(".section_block").show();
		}
		
		/*Прокрутка к блоку*/
		{
			var elem=$(this).parents(".documents_block").find(".section_block[data-id='"+$(this).data("id")+"']");
	      	destination = elem.offset().top-70;
	        $("html, body").animate({scrollTop:destination},"slow")
		}
		
	});
	
	
	/*Поиск по названию*/
	jQuery.expr[":"].icontains = jQuery.expr.createPseudo(function (arg) {                                                                                                                                                                
	    return function (elem) {                                                            
	        return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;        
	    };                                                                                  
	});
	$(document).on('keyup','.documents_block .search input', function() 
	{
		$(this).parents(".documents_block").find(".section_block").show();
		$(this).parents(".documents_block").find(".item").hide();
		$(this).parents(".documents_block").find(".item:icontains('"+$(this).val()+"')").show();
		
		
		
		if ($(this).val()=='')
		{
			$(this).parents(".documents_block").find(".section_block").show();
			$(this).parents(".documents_block").find(".section_block .item").show();
			$(this).parents(".search").removeClass("search_active");
			
			$(this).parents(".documents_block").find(".clear_search").addClass("d-none");
		}
		else
		{
			$(this).parents(".search").addClass("search_active");
			$(this).parents(".documents_block").find(".clear_search").removeClass("d-none");
		}
		
		$(this).parents(".documents_block").find(".section_block:not(:has(.item:visible))").hide();
	});
	
	/*Очистить поиск*/
	$(document).on('click','.documents_block .clear_search', function() 
	{
		$(this).parents(".documents_block").find(".search input").val("");
		$(this).addClass("d-none");
		$(this).parents(".documents_block").find(".section_block").show();
		$(this).parents(".documents_block").find(".section_block .item").show();
		$(this).parents(".documents_block").find(".search").removeClass("search_active");
		
	});
	
	/*Фильтр*/
	$(document).on('click','.documents_block .show_filter', function() 
	{
		$(this).parents(".documents_block").find(".cat_menu").toggle();
		$(this).parents(".documents_block").find(".search").toggle();
		
	});
	
});