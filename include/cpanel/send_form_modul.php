<?
AddEventHandler("iblock", "OnStartIBlockElementAdd", Array("ModulHandlers_s1", "ElementAddBefore"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("ModulHandlers_s1", "ElementAddAfter"));

class ModulHandlers_s1 {
	public static function ElementAddBefore(&$arFields) {
		 $arFields['CATEG_ID'] = $_REQUEST["CATEG_ID"];
	}

	public static function ElementAddAfter(&$arFields) {
		//Получаем данные инфоблока
		$arIBlockElement = GetIBlockElement($arFields["ID"]);
		
		if ($arIBlockElement["IBLOCK_TYPE_ID"] == "hotel_s1" && stripos($arIBlockElement["IBLOCK_CODE"], "hotel_reserv_s1")!==false && $_REQUEST["ajax_mode"]!="y")
		{
			global $APPLICATION;
			
			/*Сохраняем категорию номера*/
			CIBlockElement::SetPropertyValuesEx($arFields["ID"], $arIBlockElement["IBLOCK_ID"], [
				"CATEG_ID" => $arFields["CATEG_ID"],
			]);

			/*Сохраняем номер*/
			CIBlockElement::SetPropertyValuesEx($arFields["ID"], $arIBlockElement["IBLOCK_ID"], [
					"ROOM_ID" => $_REQUEST["ROOM_ID"],
			]);
			
			/*-----Модуль бронирование-----*/
			$GLOBALS["NO_SETTINGS_STYLE"]="Y";
			$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/design/settings_final.php");
	
			if ($settings_array["OPTION_USE_MODUL"]=="Y")
			{	
				/*Список значений типа список*/
				$db_enum_list = CIBlockProperty::GetPropertyEnum("RESERV_CONFIRM", Array('sort' => 'asc'), Array("IBLOCK_ID"=>$arIBlockElement["IBLOCK_ID"]));
				while($ar_enum_list = $db_enum_list->GetNext())
				{$arrProp[$ar_enum_list["VALUE"]]=$ar_enum_list;}

				
				/*Бронь подтверждена*/
				if ($settings_array["OPTION_MODUL_RESERV"]=="ON_SEND" && isset($arrProp["Да"]["ID"]))
				{
					CIBlockElement::SetPropertyValuesEx($arFields["ID"], $arIBlockElement["IBLOCK_ID"], [
							"RESERV_CONFIRM" => $arrProp["Да"]["ID"],
					]);
				} 
				elseif (isset($arrProp["Нет"]["ID"]))
				{
					CIBlockElement::SetPropertyValuesEx($arFields["ID"], $arIBlockElement["IBLOCK_ID"], [
							"RESERV_CONFIRM" => $arrProp["Нет"]["ID"],
					]);
				}
				
				/*Привязка номера*/
				
				
			}
			/*-----Модуль бронирование-----*/
			
			
			/*-----Email уведомление-----*/
			$arIBlockElement = GetIBlockElement($arFields["ID"]);
			$arIBlockElement_categ = GetIBlockElement($arIBlockElement["PROPERTIES"]["CATEG_ID"]["VALUE"]);
			
			$props_fields='';
			foreach ($arIBlockElement['PROPERTIES'] as $key => $prop)
				if (!in_array($key, array("CATEG_ID")))
				{
					if($prop['VALUE']!=''){
						$props_fields.='<b>'.$prop['NAME'].':</b> '.$prop['VALUE'].'<br>';
					}
				}
			$arSend = array(
					'THEME' => $arIBlockElement['IBLOCK_NAME'],
					'TEXT' =>
					'<b>Имя: </b>'.$arFields['NAME'].'<br/>'.
					($arIBlockElement_categ["NAME"]!='' ? '<b>Категория:</b> '.$arIBlockElement_categ["NAME"].'<br/>':'').
					($arFields['PREVIEW_TEXT']!='' ? $arFields['PREVIEW_TEXT'].'<br/>':'').
					$props_fields
			);
				
			CEvent::Send('SEND_FORM_MODUL_s1',"s1",$arSend);
			
		}
	}
}


?>