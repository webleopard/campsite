<?
$cat_filter_ids=array();
if (isset($arParams["CATEGORY_FILTER"]))
{
	$cat_str=explode(",",$arParams["CATEGORY_FILTER"]);
	
	foreach ($cat_str as $cat_id)
	if (trim($cat_id)>0)
	$cat_filter_ids[]=trim($cat_id);
}

/*Дерево папок*/
$section_arr=array();
$cat_filter=array('IBLOCK_ID' => $arResult["ID"], "GLOBAL_ACTIVE"=>"Y");
if (!empty($cat_filter_ids)) $cat_filter["ID"]=$cat_filter_ids;

$tree = CIBlockSection::GetTreeList($cat_filter);
while($section = $tree->GetNext()) 
{
	$activeElements=CIBlockSection::GetSectionElementsCount($section["ID"], Array("CNT_ACTIVE"=>"Y"));
	
	if ($activeElements>0)
	$section_arr[$section["ID"]]=$section;
}


/*Привязка элементов к папке*/
foreach($arResult['ITEMS'] as $arItem)
if (isset($section_arr[$arItem['IBLOCK_SECTION_ID']]) || $arItem['IBLOCK_SECTION_ID']==0)
{
	$SID = ($arItem['IBLOCK_SECTION_ID'] ? $arItem['IBLOCK_SECTION_ID'] : 0);

	$section_arr[$SID]["ITEMS"][]=$arItem;
	
	$arResult["element_count"]++;
}

$arResult["section_arr"]=$section_arr;
?>