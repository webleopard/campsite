$(function() {
	$('.right_col_content').dragScroll({
        direction: 'scrollLeft'
    });
	
	$(document).on('click','.module_admin .date_item', function() {
		var scrollPos = $(this).offset().left-$('.module_admin .dates').offset().left;
		$(".module_admin .right_col").animate({scrollLeft: scrollPos}, 800);

	});
	
	
	if ($(window).width()<767)
	{
		$(".module_admin .search_panel_wrapper").hide();
	}
	
	$(".module_admin .show_filters").click(function() {
		$(".module_admin .search_panel_wrapper").toggle();
		$(".module_admin .sort_panel").toggle();
	});
});