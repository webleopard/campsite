<?

if ($GLOBALS["OPTION_BG_USE"]=="Y")
{
	
	$url_dir=$_SERVER['REQUEST_URI']; 
	$url_dir_no_get_param= explode("?",$url_dir)[0];
	
	$bg_page=array();
	
	if (CModule::IncludeModule('iblock'))
	{
		
		
		/*Фон для всех страниц*/
		$arSelect = Array("IBLOCK_ID", "*", "PROPERTY_*");
		$arFilter = Array(
			"IBLOCK_ID"=>53, 
			"ACTIVE"=>"Y", 
			"CODE"=>"bg_page",
			array(
					"LOGIC" => "OR",
					array("PROPERTY_PAGE_FILTER" => false),
					array("PROPERTY_PAGE_FILTER" => $url_dir_no_get_param),
			)
		);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();
			
			if (is_array($arFields) && is_array($arProps))
			$bg_page=array_merge($arFields, $arProps);
		
		}
		
		
		/*Фон для страницы по фильтру*/
		if (!$bg_page["ID"]>0)	
		{
			$arSelect = Array("IBLOCK_ID", "*", "PROPERTY_*");
			$arFilter = Array(
				"IBLOCK_ID"=>53, 
				"ACTIVE"=>"Y", 
				"!CODE"=>"bg_page",
				"PROPERTY_PAGE_FILTER" => $url_dir_no_get_param
			);
			$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1), $arSelect);
			while($ob = $res->GetNextElement())
			{
				$arFields = $ob->GetFields();
				$arProps = $ob->GetProperties();
				
				if (is_array($arFields) && is_array($arProps))
				$bg_page=array_merge($arFields, $arProps);
			
			}
		}
		
		
	}
	
	
	if ($bg_page["ID"]>0)
	{
		$rsFile = CFile::GetByID($bg_page["PREVIEW_PICTURE"]);
		$bgFile = $rsFile->Fetch();
		if ($bgFile["SRC"]!="")
		{
			$bg_css_str="background-image: url('".$bgFile["SRC"]."');";
			
			if ($bg_page["BG_SIZE"]["VALUE_XML_ID"]!="") $bg_css_str.="background-size:".$bg_page["BG_SIZE"]["VALUE_XML_ID"].";";
			
			if ($bg_page["BG_REPEAT"]["VALUE_XML_ID"]!="") 
			$bg_css_str.="background-repeat:".($bg_page["BG_REPEAT"]["VALUE_XML_ID"]=="Y" ? "repeat":"no-repeat").";";

					
			if ($bg_css_str!="")
			{
				$bg_css_str='style="'.$bg_css_str.'"';
				$GLOBALS["bg_css_str"]=$bg_css_str;
				
				$GLOBALS["bg_page"]=$bg_page;
				
			}
		}
	}
}

?>