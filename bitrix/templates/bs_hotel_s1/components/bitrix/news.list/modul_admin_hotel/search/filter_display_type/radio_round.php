<?
$CODE=$filter_prop["CODE"];

$arr_values=$value_arr[$CODE];

/*Тип список, тип фильтра - выводить все значения из инфоблока*/
if ($filter_items_type=="from_iblock" && $filter_prop["PROPERTY_TYPE"]=="L")
{
	$prop_array=array();
	$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>$CODE));
	while($enum_fields = $property_enums->GetNext())
	{
		$prop_array[$enum_fields["ID"]]=$enum_fields["VALUE"]; 
	}
	
	$arr_values=$prop_array;
}

$yes_no_input=false;
if (is_array($arr_values) && count($arr_values)==2 && in_array(GetMessage("modul_admin_yes"), $arr_values))
{
	$yes_no_input=true;
}


if ((!empty($arr_values) && is_array($arr_values) && count($arr_values)>1)  || $filter_items_type=="from_iblock")
{
	?>
	<div class="block radio_round_container <?=$filter_prop["MULTIPLE"]=="Y" ? "is_multiple":""?> <?=$yes_no_input ? "yes_no_input" :""?>">
		<div class="text-center"><label><?=$filter_prop["NAME"] ?>:</label></div>
		<div class="radio_round d-flex flex-wrap justify-content-center">
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
						<input name="<?=$CODE ?>[]" type="checkbox" value="<?=$arr_value ?>">
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