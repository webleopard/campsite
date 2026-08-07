<?
/*Свойства для фильтра*/
$filter_prop_ids=array();
$filter_prop_items=array();
$prop_filter_list=CIBlockSectionPropertyLink::GetArray($arParams["IBLOCK_ID"], $SECTION_ID = 0);
foreach ($prop_filter_list as $id=>$prop_filter)
if (!empty($prop_filter) && $prop_filter["ACTIVE"]=="Y" && $prop_filter["SMART_FILTER"]=="Y")
{
	$filter_prop_ids[]=$id;
	
	$properties = CIBlockProperty::GetList(Array("SORT"=>"ASC"), Array("ID"=>$id, "ACTIVE"=>"Y", "IBLOCK_ID"=>$arParams["IBLOCK_ID"]));
	while($property = $properties->Fetch())
	{
		$property=array_merge($property, $prop_filter);
		$filter_prop_items[$property["ID"]]=$property;
	}
}

/*Если в фильтре не все параметры развернуты*/
$filter_expand=false;

foreach ($filter_prop_items as $id=>$filter_prop)
if ($filter_prop["DISPLAY_EXPANDED"]=="Y") 
{
	$filter_expand=true;
}

if ($filter_expand) 
{
	$filter_prop_items_tmp=array();	
	
	foreach ($filter_prop_items as $id=>$filter_prop)
	if ($filter_prop["DISPLAY_EXPANDED"]=="Y")
	$filter_prop_items_tmp[$id]=$filter_prop;
	 
	foreach ($filter_prop_items as $id=>$filter_prop)
	if ($filter_prop["DISPLAY_EXPANDED"]=="N")
	$filter_prop_items_tmp[$id]=$filter_prop;
	
	$filter_prop_items=$filter_prop_items_tmp;
}
?>