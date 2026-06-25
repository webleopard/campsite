

function scroll_to_func(name) {
	if($(name).length>0) {
		var elem=$(name+':first');
      	destination = elem.offset().top-70;
        $("html, body").animate({scrollTop:destination},"slow")
	}
}
$.fn.scrollToTop=function(){
	 $(this).removeAttr("href");
	    if($(window).scrollTop()!="0"){
	        $(this).stop().show();
	  }
	  var scrollDiv=$(this);
	  $(window).scroll(function(){
	    if($(window).scrollTop()=="0")
	    $(scrollDiv).hide();
	    else
	    $(scrollDiv).show();
	  });
	  $(this).click(function(){
	      $("html, body").animate({scrollTop:0},"slow")
	   });
}
function popup_message(popup_header, popup_content)
{
	$("#message_form .header3").html(popup_header);
	$("#message_form p").html(popup_content);
	$.fancybox.open({src: '#message_form', type: 'inline', 'touch' : false});
	return false;
}
function button_effect()
{
	/*Анимация кнопки*/
	$("a.btn.ripple, .btn_container.ripple").mouseenter(function(e)
	{ 	
		if ($(this).hasClass("disabled")) return;
		
        const x = e.pageX - $(this).offset().left;
        const y = e.pageY - $(this).offset().top;
        const rEffect = document.createElement("span");
        rEffect.setAttribute('class', 'effect');
      

        rEffect.style.left = `${x}px`;
        rEffect.style.top = `${y}px`;

        $(this).append(rEffect);
        setTimeout(() => {
          rEffect.remove();
        }, 500);
	});
	
}


$(function() {
	
	$('a[href="#popup_callback"]').addClass("fancybox");
	
	button_effect();
	
	/*Предупрежение об использовании cookie*/
	function getCookie() {
		  return document.cookie.split('; ').reduce((acc, item) => {
		    const [name, value] = item.split('=')
		    acc[name] = value
		    return acc
		  }, {})
	}
	const cookie = getCookie();

	if (cookie.cookie_modal!="ok") 
	$(".cookie_modal").removeClass("d-none");
	else
	{
		var date = new Date();
		date.setDate(date.getDate() + 90);
		date = date.toGMTString();	
		document.cookie = 'cookie_modal=ok; expires=' + date + '; path=/';
	}
	
	$(document).on('click','.cookie_modal .close', function() {
		$(".cookie_modal").hide();
		var date = new Date();
		date.setDate(date.getDate() + 90);
		date = date.toGMTString();	
		document.cookie = 'cookie_modal=ok; expires=' + date + '; path=/';
	});
	/*-----Предупрежение об использовании cookie-----*/
	
	/*dropdown-select*/
	$(document).on('click', '.dropdown-select label', function() 
	{
		$(this).parents(".dropdown-select").find(".items").toggle();
		$(this).parents(".dropdown-select").toggleClass("active");
	});	
	$(document).on('click', '.dropdown-select .items a', function() 
	{
		$(this).parents(".dropdown-select").find("label span").html($(this).html());
		$(this).parents(".items").hide();
		
		if ($(this).data("value")!="")
		$(this).parents(".dropdown-select").find(".value").val($(this).data("value"));
	});
	
	
	/*table-content-wrapper*/
	$(".table-content").wrap( "<div class='table-content-wrapper'></div>" );
	
	
	/*popup форма*/
	$(document).on('click', '.fancybox', function() {
		$($(this).attr("href")+" .form_result").html('');
		$($(this).attr("href")+" .header3").removeClass('hidden');
		$($(this).attr("href")+" .popup_form").removeClass('hidden');

		
		if ($(this).data('header')!='' && $(this).data('header')!=undefined)
		$($(this).attr("href")+" .header3").html($(this).data('header'));
		else $($(this).attr("href")+" .header3").html(BX.message("DEF_POPUP_HEADER")); 
		
		if ($(this).data('comment')!='')
		$($(this).attr("href")+' [data-code="SOURCE_NAME"]').val($(this).data('comment'));
		else $($(this).attr("href")+' [data-code="SOURCE_NAME"]').val('');

	    $($(this).attr("href")+' input[data-code="PHONE"]').mask("+7 (999) 999-9999");
	    $($(this).attr("href")+' input[data-code="PHONE"][required]').attr("placeholder", "+7 (999) 999-9999 *");
	    $($(this).attr("href")+' input[data-code="PHONE"]').not('[required]').attr("placeholder", "+7 (999) 999-9999");	
	});

	/*Последний видимый элемент top_panel*/
	$(window).on("load resize", function () {
		$('.top_panel > .content_container > .d-flex > div').not(':hidden').last().addClass("last_child_class");
	});
	
	
	
	
	/*Скрол к блоку*/
	$('.main_menu a[href^="#"], .footer_menu a[href^="#"], .mobile_submenu_container .menu a[href^="#"]').on("click", function(e) {
	    e.preventDefault();
	    var href=$(this).attr('href');
	    href=href.replace('#','');
	    scroll_to_func('a[id='+href+']');
	});
	
	
    /*верхнее меню*/
	$(window).on("load scroll", function () {
		//if ($(window).width()>1200) 
		made_menu();
	});
	function made_menu (){
		
		if ($(window).scrollTop()>$('header').outerHeight())
		{
			$('.fixed_header').slideDown();
			//$('body').css('padding-top', '70px');
		}
		else if ($(window).scrollTop()<$('header').outerHeight()) 
		{
			$('.fixed_header').slideUp();
			//$('body').css('padding-top', '0');	
		}
	}
	
	
	/*формы*/
    $('input[data-code="PHONE"]').mask("+7 (999) 999-9999");
    $('input[data-code="PHONE"][required]').attr("placeholder", "+7 (999) 999-9999 *");
    $('input[data-code="PHONE"]').not('[required]').attr("placeholder", "+7 (999) 999-9999");
	
	
	/*определение тачскрина*/  
	try {document.createEvent("TouchEvent"); $('.container_page').addClass('touch');} 
	catch (e) {$('.container_page').addClass('no_touch');}  
	
	if ($('#bx-panel').length>0) {$('body').addClass('bx_edit_mode');}
	
	
	$('.order_form').click(function() {
		if ($(this).data('source-name')!='')
		{
			$('#order_form .good_comment').html($(this).data('source-name'));
			$('#order_form input[data-code="SOURCE_NAME"]').val('Форма заказа - '+$(this).parents('.content_container').find('h1').html());
		}
	});
	

	/*Мобильное меню*/
	$(".mobile_submenu_container").on("swipeleft", function( event ){alert('1'); $(this).find('.close-x').trigger('click');});
	$(".mobile_submenu_container .close-x").click(function() {hide_mobile_menu();});
	$('.mobile_submenu_container .menu a[href^="#"]').on("click", function(e) {if (!$(this).hasClass('has_sub')) hide_mobile_menu();});
    function show_mobile_menu()
    {
    	$(".main_menu_container").show();
		$(".mobile_menu .icon").addClass('active');
		$(".mobile_submenu_container").show("slide", { direction: "left" }, 300);
		$(".mobile_submenu_content_overlay").show();
	
		if ($(window).height()<$('.mobile_submenu_content').height())
		{
			$("html, body").animate({scrollTop:0},"fast");
			$('.mobile_submenu_container').addClass('absolute');
		}
    }
    function hide_mobile_menu()
    {
    	$(".mobile_menu .icon").removeClass('active');
		$(".mobile_submenu_container").hide("slide", { direction: "left" }, 300);
		$(".mobile_submenu_content_overlay").hide();
		$(".mobile_submenu_container .sub_menu").remove();
		
    }
    
	$(".mobile_menu .icon").click(function() {
		if ($(this).hasClass("active"))
		{
			hide_mobile_menu();
		}
		else
		{
			show_mobile_menu();
		}

	});
	
	$(".mobile_submenu_content_overlay, .mobile_submenu_container .close-x").click(function() {hide_mobile_menu();});
	
	$(".mobile_submenu_container li").has(".sub").addClass("has_sub");
	$(".mobile_submenu_container li").has(".sub").find('>a').addClass("has_sub");
	$(".mobile_submenu_container li a.has_sub").attr('href', '#');
	
	$(document).on('click', '.mobile_submenu_container li a.has_sub', function() {
		var sub_col=$(".mobile_submenu_container .menu .sub_menu").length+1;
		$(".mobile_submenu_container .menu .sub_menu").hide();
		$(".mobile_submenu_container .menu").append('<div style="z-index: '+sub_col+'" class="sub_menu" data-id="sub_id_'+sub_col+'"><ul><li class="back"><a href="#">Назад</a></li>'+$(this).parents('li').find('.sub').html()+'</ul></div>');
		$("[data-id=sub_id_"+sub_col).show("slide", { direction: "right" }, 300);
		
		return false;
	});
	$(document).on('click', '.mobile_submenu_container .back', function() {
		
		$(this).parents('.sub_menu').hide("slide", { direction: "right" }, 300);
		
		$(this).parents('.sub_menu').remove();
		$(".mobile_submenu_container .menu .sub_menu").show();
	});
	
	/*Скрол к блоку из меню*/
	$('.main_menu_container a[href^="#"], .mobile_submenu_container a[href^="#"], .footer_menu a[href^="#"]').on("click", function(e) {
	   if ($(this).attr('href')!='#')
	   {
			e.preventDefault();
		    var href=$(this).attr('href');
		    href=href.replace('#','');
		    hide_mobile_menu();
		    scroll_to_func('a[name='+href+']');
	   }
	});

	
	//$('.main_menu .root-item[href="/uslugi/"]').attr('href', 'javascript:void(0);');

	/*viewport*/
	//if ($(window).width() < 500) {$("[name=viewport]").attr("content", "width=500, initial-scale=1");}
	
	
	
	/*popup*/
    $("a.fancybox").fancybox({
        openEffect: 'elastic',
        closeEffect: 'elastic',
        padding: 40,
        lang: "ru",
	        i18n: {
		          ru: {
		            CLOSE: "Закрыть",
		            NEXT: "Следующий",
		            PREV: "Предыдущий",
		            ERROR: "Контент не может быть загружен. <br/> Повторите попытку позже",
		            PLAY_START: "Начать показ слайдов",
		            PLAY_STOP: "Остановить показ слайдов",
		            FULL_SCREEN: "На полный экран",
		            THUMBS: "Миниатюра",
		            DOWNLOAD: "Загрузить",
		            SHARE: "Поделиться",
		            ZOOM: "Увеличить"
		          }
	        }
    });

	
	$("#scrollTop").scrollToTop();


   
    /*формы*/
    $('.ajax_form [data-code="PHONE"][required]').attr("placeholder", "+7 (999) 999-9999 *");
    $('.ajax_form [data-code="PHONE"]').not('[required]').attr("placeholder", "+7 (999) 999-9999");
   
    
	
	/*Одинаковый размер блоков*/
	$(window).on("load resize", function () {
	    
	    $("body").find(".equal_height").each(function () {
	    	var maxHeight = 0;
	    	
	    	$(this).find(".equal_item").each(function() {
	    		 if ($(this).outerHeight() > maxHeight) {
	 	            maxHeight = $(this).outerHeight();

	 	        }
			}).outerHeight(maxHeight);

	    });
	});
	
	/*Ссылка на увеличинную картинку*/
	$(window).on("load", function () {
	    var i=0;
	    $("body").find("a.zoom_image").each(function () {
	    	i++;
	    	$(this).attr('data-fancybox','');
	    });
	});	

	
	/*Селекты*/
	$('.select').has('option[selected="selected"]').addClass('active');
	$(".select").click(function() {$(this).removeClass("active")});
	
	/*Fancybox ajax*/

	
	
	$(document).on('click', '.fancybox_ajax', function() {
		var id = $(this).data('id');
		var type = $(this).data('type');
		$.ajax({
			type : "POST",
			url : "/ajax.php",
			data : "action=get_popup_content&type="+type+"&id=" + id,
			success : function(html) {
				$.fancybox.open(html);
			}
		});
	});
	
	$(document).on('click', '.popup_close', function() {
		 $.fancybox.close();
	});
    
});