	$(function () 
	{
		$(document).on('click', '.fancybox', function() {


			$($(this).attr("href")+" .form_result").html('');
			$($(this).attr("href")+" .header3").removeClass('hidden');
			$($(this).attr("href")+" .popup_form").removeClass('hidden');

			
			if ($(this).data('header')!='' && $(this).data('header')!=undefined)
			$($(this).attr("href")+" .header3").html($(this).data('header'));
			else $($(this).attr("href")+" .header3").html("<?=GetMessage("DEF_POPUP_HEADER") ?>"); 
			
			if ($(this).data('comment')!='')
			$($(this).attr("href")+' [data-code="SOURCE_NAME"]').val($(this).data('comment'));
			else $($(this).attr("href")+' [data-code="SOURCE_NAME"]').val('');

		    $($(this).attr("href")+' input[data-code="PHONE"]').mask("+7 (999) 999-9999");
		    $($(this).attr("href")+' input[data-code="PHONE"][required]').attr("placeholder", "+7 (999) 999-9999 *");
		    $($(this).attr("href")+' input[data-code="PHONE"]').not('[required]').attr("placeholder", "+7 (999) 999-9999");	

		});
	});