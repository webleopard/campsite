$(function () 
{
	$(document).on('click','.show_top_search', function() {
		if ($(".top_search_panel").hasClass("active"))
		{
			$(".top_search_panel").removeClass("active");
		}
		else
		{
			$(".top_search_panel").addClass("active");
		}
	});
	
	$(document).on('click','.top_search_panel .button_close', function() {
		$(".top_search_panel").removeClass("active");
	});

});
