$(function() {
	
	/*Фильтр меню*/
	$(document).on('click','.price_block .cat_menu a', function() 
	{
		
		$(this).parents(".price_block").find(".section_block").show();
		$(this).parents(".price_block").find(".section_block .item").show();
		$(this).parents(".price_block").find(".search input").val("");
		
		
		$(this).parents(".price_block .cat_menu").find(">a").removeClass("active");
		//$(this).parents(".price_block").find(".section_block .top_air").removeClass("d-none");
		$(this).addClass("active");
		
		
		$(this).parents(".price_block").find(".section_block").hide();
		
		var target_block=$(this).parents(".price_block").find(".section_block[data-id='"+$(this).data("id")+"']");
		$(target_block).show();
		var parents = $(target_block).parents(".section_block");
		for (var i = parents.length-1; i >= 0; i--) 
		{
			$(parents[i]).show();
		}
		
		$(this).parents(".price_block").find(".section_block[data-id='"+$(this).data("id")+"']").parents(".section_block>:last").show();
		//$(this).parents(".price_block").find(".section_block[data-id='"+$(this).data("id")+"'] .top_air").addClass("d-none");
		
		/*Показать все*/
		$(this).parents(".price_block .cat_menu").find(".show_all").show();
		if ($(this).hasClass("show_all"))
		{
			$(this).hide();
			$(this).parents(".price_block").find(".section_block").show();
		}
		
		/*Прокрутка к блоку*/
		{
			var elem=$(this).parents(".price_block").find(".section_block[data-id='"+$(this).data("id")+"']");
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
	$(document).on('keyup','.price_block .search input', function() 
	{
		$(this).parents(".price_block").find(".section_block").show();
		$(this).parents(".price_block").find(".item").hide();
		$(this).parents(".price_block").find(".item:icontains('"+$(this).val()+"')").show();
		
		
		
		if ($(this).val()=='')
		{
			$(this).parents(".price_block").find(".section_block").show();
			$(this).parents(".price_block").find(".section_block .item").show();
			$(this).parents(".search").removeClass("search_active");
			
			$(this).parents(".price_block").find(".clear_search").addClass("d-none");
		}
		else
		{
			$(this).parents(".search").addClass("search_active");
			$(this).parents(".price_block").find(".clear_search").removeClass("d-none");
		}
		
		$(this).parents(".price_block").find(".section_block:not(:has(.item:visible))").hide();
	});
	
	/*Очистить поиск*/
	$(document).on('click','.price_block .clear_search', function() 
	{
		$(this).parents(".price_block").find(".search input").val("");
		$(this).addClass("d-none");
		$(this).parents(".price_block").find(".section_block").show();
		$(this).parents(".price_block").find(".section_block .item").show();
		$(this).parents(".price_block").find(".search").removeClass("search_active");
		
	});
	
	/*Фильтр*/
	$(document).on('click','.price_block .show_filter', function() 
	{
		$(this).parents(".price_block").find(".cat_menu").toggle();
		$(this).parents(".price_block").find(".search").toggle();
		
	});
	
});