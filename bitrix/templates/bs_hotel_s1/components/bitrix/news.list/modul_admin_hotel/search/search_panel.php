<div class="search_panel_container">
<div class="content_container">
<<?=$header_tag ?> class="page_block_header"><?=$block_header ?></<?=$header_tag ?>>
<div class="clear"></div>
<a class="btn small show_filters iconfont_container" href="javascript:void(0);" style="display: none;">Фильтры</a>

<form class="form_catalog_search">

<div class="search_panel_wrapper">
<div class="search_panel d-flex flex-wrap">
<?
/*Перенос строки перед полем*/
$clear_before_field=array("DATE_FROM");

/*В фильтре значения из выборки*/
/* $filter_items_type="from_result"; */

/*В фильтре значения из инфоблока*/
$filter_items_type="from_iblock";


$expand_panel_start=false;

if (!empty($filter_prop_items))
{
	
	foreach ($filter_prop_items as $id=>$filter_prop)
	{
		if (in_array($filter_prop["CODE"], $clear_before_field)) {
			?><div class="clear" style="flex-basis: 100%; height: 0;"></div><?	
		}
			
		/*Свернутые параметры*/
		if ($filter_expand && $filter_prop["DISPLAY_EXPANDED"]=="N" && !$expand_panel_start)
		{
			print '<div class="filter_expand d-flex flex-wrap"><a class="show_expand" href="javascript:void(0);">Показать все <i class="fa fa-angle-down"></i></a>';
			$expand_panel_start=true;
		}
			
		if (stripos($filter_prop["CODE"], "CHECKBOX_YN_")!==false) 
		/*Чекбокс да\нет*/
		{
			include('filter_display_type/checkbox_yn.php');
		}
		elseif (stripos($filter_prop["CODE"], "DATE")!==false)
		/*Дата*/
		{
			include('filter_display_type/date.php');
		}
		elseif ($filter_prop["LINK_IBLOCK_ID"]>0 && $filter_prop["DISPLAY_TYPE"]=="K")
		/*Привязка к элементам*/
		{
			include('filter_display_type/radio_round_linked.php');
		}
		elseif ($filter_prop["DISPLAY_TYPE"]=="A")	
		/*Ползунок*/	
		{
			include('filter_display_type/slider.php');
		}
		elseif ($filter_prop["DISPLAY_TYPE"]=="B" || $filter_prop["DISPLAY_TYPE"]=="K")
		/*Радио кнопки - кружки*/
		{
			include('filter_display_type/radio_round.php');
		}
		elseif ($filter_prop["CODE"]=="OPTION_ID") 
		/*Опции - кнопки*/
		{
			include('filter_display_type/option_button.php');
		}
		elseif ($filter_prop["DISPLAY_TYPE"]=="P" || $filter_prop["PROPERTY_TYPE"]=="E")
		{
			include('filter_display_type/select.php');
		}
		/*default*/
		else
		{
			include('filter_display_type/select.php');
		}
		
	}
	
	if ($expand_panel_start) print "</div>";
}



/*CUSTOM*/

?>
<div class="clear" style="flex-basis: 100%; height: 0;"></div>
<div class="block block_date">
	<div class="flex-grow-1">
		<input class="DATE_START" placeholder="Дата с" type="text" name="DATE_START" value="<?=htmlspecialcharsbx($_REQUEST["DATE_START"]) ?>" >
	</div>
</div>
<div class="block block_date">
	<div class="flex-grow-1">
		<input class="DATE_END" placeholder="Дата с" type="text" name="DATE_END" value="<?=htmlspecialcharsbx($_REQUEST["DATE_END"]) ?>" >
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
	
	$(".<?=$block_id?>_block_selector .search_panel .DATE_START").datepicker({

	});  
	$(".<?=$block_id?>_block_selector .search_panel .DATE_END").datepicker({

	});


});
</script>
<?/*---CUSTOM---*/?>





</div>





<div class="text-center">
<a class="btn small ripple clear_filter" style="display: none;">
<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9 1.08838L1 9.08838M9 9.08838L1 1.08838" stroke="#FFF" stroke-width="1.6"></path>
</svg><span>Сбросить фильтры</span><span class="kol"></span></a>
</div>

<?
if (is_array($jsParams))
foreach ($arParams as $k=>$v)
if (in_array($k,$jsParams))
{
	?><input type="hidden" name="<?=$k ?>" value="<?=$v ?>"><?
}
?>
</form>

</div>
</div>
</div>

<div class="air p20"></div>
