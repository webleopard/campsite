<?
global $APPLICATION;


$category=array();
$category_field="CATEGORY";
foreach($arResult["ITEMS"] as $arItem)
{
	
	$category[$arItem["PROPERTIES"][$category_field]["VALUE"]]=array("SORT"=>$arItem["PROPERTIES"][$category_field]["VALUE_SORT"]);
}

function cmp($a, $b) {
	if ($a['SORT'] == $b['SORT']) {
		return 0;
	}
	return ($a['SORT'] < $b['SORT']) ? -1 : 1;
}

uasort($category, 'cmp');
$arResult[$category_field]=$category;

?>