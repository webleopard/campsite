<?
$CODE=$property["CODE"];

/*Если тип - привязка к элементам*/
if ($property["LINK_IBLOCK_ID"]>0)
{
	/*Список всех значений Тип*/
	$link_items_array=array();
	$res_link_items = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>$property["LINK_IBLOCK_ID"]), false, false);
	while($ob_link_item = $res_link_items->GetNextElement())
	{
		$arFields_link_item = $ob_link_item->GetFields();
		$arProps_link_item = $ob_link_item->GetProperties();
		
		/*!!!*/
		if ($arProps_link_item["CATEG_ID"]["VALUE"]==$_REQUEST["categ_id"])
		{
			if ($filter_items_type!="from_result" || in_array($arFields_link_item["ID"], $value_arr[$CODE]))
			$link_items_array[$arFields_link_item["ID"]]=$arFields_link_item["NAME"];
		}

	}

	$value_arr[$CODE]=$link_items_array;
}
?>
	<div class="block">
		<select <?=in_array($CODE, $disabled_fields) ? 'readonly="readonly"':"" ?> class="select_<?=$block_id?>_<?=$CODE ?>" name="<?=$CODE ?><?=$property["MULTIPLE"]=="Y" ? "[]":"" ?>" <?=$property["MULTIPLE"]=="Y" ? 'multiple="multiple"':"" ?>>
			<option></option>
			<?
		 	foreach ($value_arr[$CODE] as $k=>$arr_value)
			{
				$active=false;
				if ($item_add_edit[$CODE]["VALUE"]==$arr_value) $active=true;
				if ($item_add_edit[$CODE]["VALUE"]==$k) $active=true;
				?>
				<option value="<?=$k ?>" <?=$active ? "selected":"" ?>><?=$arr_value ?></option>
				<?	
			}
		 
		 ?> 
		</select>
	</div>