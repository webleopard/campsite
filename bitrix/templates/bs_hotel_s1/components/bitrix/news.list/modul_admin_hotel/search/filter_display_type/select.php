<?
$CODE=$filter_prop["CODE"];
$arr_values=$value_arr[$CODE];

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
		
		if ($filter_items_type!="from_result" || in_array($arFields_link_item["ID"], $arr_values))
		$link_items_array[$arFields_link_item["ID"]]=$arFields_link_item["NAME"];
	
	}
	
	$arr_values=$link_items_array;
}



if (!empty($arr_values) && is_array($arr_values) && count($arr_values)>1)
{
	?>
	<div class="block">
		<select class="select_<?=$block_id?>_<?=$CODE ?>" name="<?=$CODE ?><?=$filter_prop["MULTIPLE"]=="Y" ? "[]":"" ?>" <?=$filter_prop["MULTIPLE"]=="Y" ? 'multiple="multiple"':"" ?>>
			<option></option>
			<?
		 	foreach ($arr_values as $k=>$arr_value)
			{
				if (!$filter_prop["LINK_IBLOCK_ID"]>0) $k=$arr_value;
				
				?>
				<option value="<?=$k?>"><?=$arr_value ?></option>
				<?	
			}
		 
		 ?> 
		</select>
	</div>
	<script>
	$(function () 
	{
		 $('.select_<?=$block_id?>_<?=$CODE ?>').select2({
			 placeholder: "<?=$filter_prop["NAME"] ?>",
			 allowClear: true
		 });
	});
	</script>
	<?
}
?>