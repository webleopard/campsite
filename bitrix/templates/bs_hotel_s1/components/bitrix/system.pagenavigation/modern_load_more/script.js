$(document).ready(function(){
	
	var next_href=$('.modern-page-navigation .modern-page-current').next("a").attr('href');
	if (next_href=='' || next_href==undefined) $('.load_more').hide();
	
	$(document).on('click','.load_more', function() {
		$.ajax({
	        type: "POST",
	        url: $('.modern-page-navigation .modern-page-current').next("a").attr('href'),
	        data: {'ajax_get_page': 'y'},
	        dataType: "html",
	        success: function (data) 
	        {
	        	var items = $(data).find('.places_list_table tbody');
	        	var paging = $(data).find('.modern-page-navigation');
	        	
	        	$('.load_more_content .places_list_table').append(items);
	        	$('.modern-page-navigation').html(paging);
	        	
	        	var next_href=$('.modern-page-navigation .modern-page-current').next("a").attr('href');
	        	if (next_href=='' || next_href==undefined) $('.load_more').hide();
	        	
	        }
	    });
	});
	
	
});