<?
/*Секции инфоблока*/
$iblock_sections=array();
$arFilter = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"]);
$db_list = CIBlockSection::GetList(Array(), $arFilter, true);
while($ar_result = $db_list->GetNext())
{
	$iblock_sections[$ar_result['ID']]=$ar_result;
}

/*Баннеры по типу (коду раздела инфоблока)*/
$arResult_by_type=array();
foreach ($arResult["ITEMS"] as $item)
{
	$section_code=$iblock_sections[$item["IBLOCK_SECTION_ID"]]["CODE"];
	$arResult_by_type[$section_code][]=$item;
	
}


$arResult["arResult_by_type"]=$arResult_by_type;

?>