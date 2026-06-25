$(function() {
	$(".vacancy .list .item .expand").click(function() {
		
		if ($(this).parents(".item").hasClass("active"))
		{
			$(".vacancy .list .item").removeClass("active");
			$(this).parents(".item").find(".answer").slideUp();
		}
		else
		{
		
			$(".vacancy .text").slideUp();
			
			$(this).parents(".item").addClass("active");
			
			$(this).parents(".item").find(".answer").slideDown();
		}
	});
});