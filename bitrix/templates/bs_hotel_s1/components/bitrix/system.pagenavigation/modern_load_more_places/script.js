$(document).ready(function(){
	
	var next_href=$('.places_content_block.active .modern-page-navigation .modern-page-current').next("a").attr('href');
	if (next_href=='' || next_href==undefined) $('.load_more').hide();
	

	
	$(document).on('click','.load_more', function() {
		
		var active_type=$('.places .menu .item.active').data('type');
		//alert(active_type);
		$.ajax({
	        type: "POST",
	        url: $('.places_content_block.active .modern-page-navigation .modern-page-current').next("a").attr('href'),
	        data: {'ajax_get_page': 'y'},
	        dataType: "html",
	        success: function (data) 
	        {
	        	var items = $(data).find('.places_content_block.'+active_type+' .places_list_table tbody');
	        	var paging = $(data).find('.places_content_block.'+active_type+' .modern-page-navigation');
	        	

	        	
	        	$('.places_content_block.active .places_list_table tbody').append(items.html());
	        	$('.places_content_block.active .modern-page-navigation').html(paging);
	        	
	        	var next_href=$('.places_content_block.active .modern-page-navigation .modern-page-current').next("a").attr('href');
	        	if (next_href=='' || next_href==undefined) $('.places_content_block.active .load_more').hide();
	        	
	        }
	    });
	});
	
	
});