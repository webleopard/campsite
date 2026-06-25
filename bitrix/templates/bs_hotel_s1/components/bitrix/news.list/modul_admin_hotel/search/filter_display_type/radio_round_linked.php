<?
$CODE=$filter_prop["CODE"];

/*Если тип - привязка к элементам*/
if ($filter_prop["LINK_IBLOCK_ID"]>0)
if ((!empty($arr_values) && is_array($arr_values) && count($arr_values)>1)  || $filter_items_type=="from_iblock")
{
	/*Список всех значений Тип*/
	$link_items_array=array();
	$res_link_items = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>$filter_prop["LINK_IBLOCK_ID"]), false, false);
	while($ob_link_item = $res_link_items->GetNextElement())
	{
		$arFields_link_item = $ob_link_item->GetFields();
		$arProps_link_item = $ob_link_item->GetProperties();
		
		if ($filter_items_type!="from_result" || in_array($arFields_link_item["ID"], $value_arr[$CODE]))
		$link_items_array[$arFields_link_item["ID"]]=$arFields_link_item["NAME"];
	
	}
	
	$value_arr[$CODE]=$link_items_array;
}


$arr_values=$value_arr[$CODE];
if (!empty($arr_values) && is_array($arr_values) && count($arr_values)>1)
{
	?>
	<div class="block radio_round_container <?=$filter_prop["MULTIPLE"]=="Y" ? "is_multiple":""?>">
		<div class="text-center"><label><?=$filter_prop["NAME"] ?>:</label></div>
		<div class="radio_round d-flex flex-wrap">
			<?
			/*Сортируем значение если число*/
			$nubmer_values=true;
			foreach ($arr_values as $k=>$arr_value)
			{
				if (!floatval($arr_value)>0)	
				$nubmer_values=false;
			}
			
			if (is_array($arr_values))
			{
				if ($nubmer_values) sort($arr_values); 
				
				foreach ($arr_values as $k=>$arr_value)
				{
					?>
					<div class="item">
						<input name="<?=$CODE ?>[]" type="checkbox" value="<?=$k ?>">
						<?=$arr_value ?>
					</div>
					<?	
				}
			}
			?>
		</div>
	</div>
	<?
}
?>