$(function() {
	$('body').append('<div class="mobile_layout" style="box-sizing: border-box; border: 1px solid #CCCCCC; z-index: 2147483647; background-color: #FFFFFF; position: fixed; width: 100%; bottom: 0px; opacity: 0.9; padding: 10px;">123</div>');
	
	$(".mobile_layout").click(function() {
		$(this).toggle();
	});

	function get_size_info()
	{
		$('.mobile_layout').html('width: '+$(window).width()+' | height '+$(window).height());
	}
	
	$(window).resize(function(){
		get_size_info();
	});
	
	get_size_info();
});