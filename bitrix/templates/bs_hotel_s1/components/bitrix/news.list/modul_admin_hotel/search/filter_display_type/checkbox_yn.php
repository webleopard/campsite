<?
$CODE=$filter_prop["CODE"];

$arr_values=$value_arr[$CODE];


if ($filter_prop["PROPERTY_TYPE"]=="L") /*Тип список*/
if (!empty($arr_values) && is_array($arr_values) && count($arr_values)>0)
{
	
	$prop_array=array();
	$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>$CODE));
	while($enum_fields = $property_enums->GetNext())
	{
		/* $prop_array[$enum_fields["ID"]]=$enum_fields["VALUE"]; */
		$yes_value=$enum_fields["VALUE"];
		break;
	}
	
	?>
	<div class="block">
		<div class="d-flex justify-content-center">
			<div class="styled_switch justify-content-center">
				<input id="styled_switch_<?=$CODE ?>" name="<?=$CODE ?>" type="checkbox" class="checkbox" value="<?=$yes_value ?>">
				<label for="styled_switch_<?=$CODE ?>"><?=$filter_prop["NAME"] ?></label>
			</div>
		</div>
	</div>
	<?
}
?>