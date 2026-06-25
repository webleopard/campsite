<?
$CODE=$property["CODE"];

$prop_array=array();
$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ADD_EDIT, "CODE"=>$CODE));
while($enum_fields = $property_enums->GetNext())
{
	/* $prop_array[$enum_fields["ID"]]=$enum_fields["VALUE"]; */
	$yes_value=$enum_fields["VALUE"];
	break;
}

?>
<div class="block">
	<div class="air p5"></div>
	<div class="d-flex">
		<div class="styled_switch justify-content-center">
			<input id="styled_switch_<?=$CODE ?>" name="<?=$CODE ?>" type="checkbox" class="checkbox" value="<?=$yes_value ?>" <?=$item_add_edit[$CODE]["VALUE"]==$yes_value ? "checked":"" ?>>
			<label for="styled_switch_<?=$CODE ?>"><?=$property["NAME"] ?></label>
		</div>
	</div>
	<div class="air p10"></div>
</div>
