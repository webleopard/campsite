<?
$CODE=$filter_prop["CODE"];
?>
<div class="block block_date">
	<div class="flex-grow-1">
		<input class="<?=$CODE ?>" placeholder="<?=$filter_prop["NAME"] ?>" type="text" name="<?=$CODE ?>" value="" >
	</div>
</div>
<script>
$(function () 
{
	$.datepicker.regional['ru'] =
	{
		closeText: 'Закрыть',
		prevText: '&#x3c;Пред',
		nextText: 'След&#x3e;',
		currentText: 'Сегодня',
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
		'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
		'Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false
	};


	$.datepicker.setDefaults($.extend($.datepicker.regional["ru"]));
	
	$(".<?=$block_id?>_block_selector .search_panel .<?=$CODE ?>").datepicker({});  

});
</script>
