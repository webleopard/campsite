$(document).on('click', '.baloon_content .btn.fancybox', function() {	
    $.fancybox.open({src: '#popup_callback', type: 'inline', 'touch' : false});
});