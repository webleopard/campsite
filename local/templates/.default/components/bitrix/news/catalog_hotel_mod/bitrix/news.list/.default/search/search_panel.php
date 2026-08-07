<div class="search_panel_container">
<div class="content_container">
<<?=$header_tag ?> class="page_block_header"><?=$block_header ?></<?=$header_tag ?>>
<div class="clear"></div>
<a class="btn small show_filters iconfont_container" href="javascript:void(0);" style="display: none;">Фильтры</a>

<form class="form_catalog_search">

<div class="search_panel_wrapper">
<div class="search_panel d-flex flex-wrap">
<?
$expand_panel_start=false;

if (!empty($filter_prop_items))
{
	
	foreach ($filter_prop_items as $id=>$filter_prop)
	{
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


?>




<?
/*Модуль*/
if ($GLOBALS["OPTION_MODUL_USE"]=="Y")
{
?>
<div class="clear" style="flex-basis: 100%; height: 0;"></div>
<div class="block block_date modul_fields">
	<div class="flex-grow-1">
		<input class="DATE_FROM" placeholder="Дата с" type="text" name="DATE_FROM" value="" >
	</div>
</div>
<div class="block block_date modul_fields">
	<div class="flex-grow-1">
		<input class="DATE_TO" placeholder="Дата по" type="text" name="DATE_TO" value="" >
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
	
	$(".form_catalog_search .modul_fields .DATE_FROM").datepicker({
		minDate: '<?=date('d.m.Y', strtotime('NOW')) ?>',
		maxDate: '<?=date('d.m.Y', strtotime('+1 year')) ?>',
	});  
	$(".form_catalog_search .modul_fields .DATE_TO").datepicker({
		minDate: '<?=date('d.m.Y', strtotime('NOW')) ?>',
		maxDate: '<?=date('d.m.Y', strtotime('+1 year')) ?>',
	});

});
</script>
<?}?>





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



<div class="content_container sort_panel">
<div class="air p20"></div>
<div class="d-flex">
	<div class="flex-grow-1 text-left">
		
		<div class="dropdown-select sort_select">
			<input class="value" type="hidden" name="sort" value="<?=$sort_active ?>">
			<label><span><?=$sort_array[$sort_active] ?></span><i class="fa fa-angle-down"></i></label>
			<div class="items">
			<?
			foreach ($sort_array as $k=>$sort)
			{
				$sort_explode=explode(" ", $k);
				?><a data-SORT_BY1="<?=$sort_explode[0] ?>" data-SORT_ORDER1="<?=$sort_explode[1] ?>" <?=$k==$sort_active ? "class='active'":""?> href="javascript:void(0);"><?=$sort ?></a><?
			}
			?>
			</div>
		</div>
		
	</div>
	<div class="flex-grow-1 text-right">
		<?
		$view_type=array(
				/* "grid4"=>array("default"=>"true", "svg"=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 72C0 49.9 17.9 32 40 32H88c22.1 0 40 17.9 40 40v48c0 22.1-17.9 40-40 40H40c-22.1 0-40-17.9-40-40V72zM0 232c0-22.1 17.9-40 40-40H88c22.1 0 40 17.9 40 40v48c0 22.1-17.9 40-40 40H40c-22.1 0-40-17.9-40-40V232zM128 392v48c0 22.1-17.9 40-40 40H40c-22.1 0-40-17.9-40-40V392c0-22.1 17.9-40 40-40H88c22.1 0 40 17.9 40 40zM160 72c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40v48c0 22.1-17.9 40-40 40H200c-22.1 0-40-17.9-40-40V72zM288 232v48c0 22.1-17.9 40-40 40H200c-22.1 0-40-17.9-40-40V232c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40zM160 392c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40v48c0 22.1-17.9 40-40 40H200c-22.1 0-40-17.9-40-40V392zM448 72v48c0 22.1-17.9 40-40 40H360c-22.1 0-40-17.9-40-40V72c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40zM320 232c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40v48c0 22.1-17.9 40-40 40H360c-22.1 0-40-17.9-40-40V232zM448 392v48c0 22.1-17.9 40-40 40H360c-22.1 0-40-17.9-40-40V392c0-22.1 17.9-40 40-40h48c22.1 0 40 17.9 40 40z"/></svg>'), */
				"grid"=>array("default"=>"true", "svg"=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M224 80c0-26.5-21.5-48-48-48H80C53.5 32 32 53.5 32 80v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V80zm0 256c0-26.5-21.5-48-48-48H80c-26.5 0-48 21.5-48 48v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V336zM288 80v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48zM480 336c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V336z"/></svg>'),
				"list"=>array("svg"=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z"/></svg>'),
		);
		?>
		<?if (!empty($view_type)) {?>
		<div class="view_type d-flex justify-content-end">
			<?foreach ($view_type as $k=>$view){
				
				$active=false;
				if ($view["default"]) {
					$active=true;
					$view_type_active=$k;
				}
				
				?>
				<a href="javascript:void(0);" <?=$active ? "class='active'":"" ?> data-view="<?=$k ?>"><?=$view["svg"] ?></a>
			<?
			}
			
			if ($_REQUEST["view_type"]) $view_type_active=htmlspecialcharsbx($_REQUEST["view_type"]);
			?>
		</div>
		<?} ?>
	</div>
</div>
</div>
</div>
<div class="air p20"></div>