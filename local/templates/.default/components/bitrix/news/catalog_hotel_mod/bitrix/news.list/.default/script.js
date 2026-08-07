$(function() {
	
	
	$(document).on('click', '.catalog_block_wrapper .order_container .btn', function() 
	{
		$("#popup_form_modul input[name='IBLOCK_CATEG_ID']").val($(this).data("iblock-categ-id"));
		$("#popup_form_modul input[name='IBLOCK_ROOMS_ID']").val($(this).data("iblock-rooms-id"));
		$("#popup_form_modul input[name='CATEG_ID']").val($(this).data("categ-id"));
		
		$("#popup_form_modul #DATE_FROM").val("");
		$("#popup_form_modul #DATE_TO").val("");
		
	});
	
	if ($(window).width()<767)
	{
		$(".catalog_hotel_block_selector .search_panel_wrapper").hide();
		$(".catalog_hotel_block_selector .sort_panel").hide();
	}
	
	$(".catalog_hotel_block_selector .show_filters").click(function() {
		$(".catalog_hotel_block_selector .search_panel_wrapper").toggle();
		$(".catalog_hotel_block_selector .sort_panel").toggle();
	});
	
	

	
});