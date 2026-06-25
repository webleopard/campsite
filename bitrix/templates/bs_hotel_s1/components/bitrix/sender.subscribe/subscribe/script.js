$(function () 
{
	
	$(document).on("click",".subscribe_form a", function() {
		
		var email=$(".subscribe_form [name='email']").val();
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		
		if (emailReg.test(email))
		{
			var params = $(".subscribe_form").find('select, textarea, input').serialize();
			$.ajax({
			   	type: "POST",
			   	url: templateFolder+"/ajax.php",
			   	data: params,
			   	dataType: 'json',
			   	success: function(data){
			   		if (data.status=="ok")
			   		{
			   			$(".subscribe_form").removeClass("alert");
			   			$(".subscribe_form input").val("");
			   			$(".subscribe_form").addClass("ok");
			   		}
			   		else if (data.status=="error")
			   		{
			   			$(".subscribe_form").addClass("alert");
			   			popup_message("Ошибка", data.msg);
			   		}
				}
			});
		}
		else
		{
			$(".subscribe_form").addClass("alert");
		}
	});
});