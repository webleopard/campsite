<?
$arParams["IBLOCK_SECTION_NAME"]="О компании";
if ($arParams["IBLOCK_SECTION_ID"]>0 || $arParams["IBLOCK_SECTION_NAME"]!="")
{
	foreach ($arResult["ITEMS"] as $k=>&$item)
	{
		if ($item["IBLOCK_SECTION_ID"]>0)	
		{
			/*Дерево разделов*/
			/* $list = CIBlockSection::GetNavChain(false,$item["IBLOCK_SECTION_ID"], array(), true);
			foreach ($list as $arSectionPath){
				echo '<pre>';print_r($arSectionPath);echo '</pre>';
			} */
			
			
			/*Параметр ID секции*/
			if ($arParams["IBLOCK_SECTION_ID"]>0 && $item["IBLOCK_SECTION_ID"]!=$arParams["IBLOCK_SECTION_ID"])
			{
				unset($arResult["ITEMS"][$k]);
			}
			
			/*Параметр название секции*/
			if ($arParams["IBLOCK_SECTION_NAME"]!="")
			{
				$list = CIBlockSection::GetNavChain(false,$item["IBLOCK_SECTION_ID"], array(), true);
				
				if (!empty($list[0]["NAME"]) && $list[0]["NAME"]!=$arParams["IBLOCK_SECTION_NAME"])
				unset($arResult["ITEMS"][$k]);
			}
		
		}
			
	}
}
?>