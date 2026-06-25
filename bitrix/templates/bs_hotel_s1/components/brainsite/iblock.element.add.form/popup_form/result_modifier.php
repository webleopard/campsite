<?
if ($arParams["SOURCE_NAME"]!='')
{
	if(CModule::IncludeModule("iblock"))
	{

	    $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>"SOURCE_NAME"));
	    while ($prop_fields = $properties->GetNext())
	    {
	    	$arResult["SOURCE_NAME_ID"]=$prop_fields["ID"];
	    }
	    
	    $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>"PRICE"));
	    while ($prop_fields = $properties->GetNext())
	    {
	    	$arResult["PRICE_ID"]=$prop_fields["ID"];
	    }

	}
	
}
?>