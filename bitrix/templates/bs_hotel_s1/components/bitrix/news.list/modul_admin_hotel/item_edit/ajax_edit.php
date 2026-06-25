<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
require(str_replace('\\', '/', dirname(__DIR__))."/lang/ru/template.php");

$IBLOCK_ADD_EDIT=$_REQUEST["iblock_id"];
CModule::IncludeModule('iblock');
$elem = new CIBlockElement;

global $USER;

$return=array();

if ($_SESSION["demo_mode_module_admin"])
{
	$return[""]="";
    print json_encode($return);
}
elseif (!$USER->IsAdmin())
{
	$return["error"]=GetMessage("ADD_EDIT_NO_ADMIN_COMMENT");
    print json_encode($return);
}
elseif ($_REQUEST["action"]=="delete" && $_REQUEST["id"]>0)
{
	
 	$result = CIBlockElement::Delete((int)$_REQUEST["id"]);

    if(!$result)
    {
        global $APPLICATION;
        $return["error"]=$APPLICATION->LAST_ERROR;
        print json_encode($return);
    }
    else $return[""]="";
    print json_encode($return);
}
elseif ($return["error"]=="" && $_REQUEST["ajax_mode"]=="y")
{
	
	/*Свойства инфоблока*/
	$property_array=array();
	$prop_list=CIBlockSectionPropertyLink::GetArray($IBLOCK_ADD_EDIT, $SECTION_ID = 0);
	foreach ($prop_list as $id=>$prop)
	if (!empty($prop) && $prop["ACTIVE"]=="Y")
	{
		$properties = CIBlockProperty::GetList(Array("SORT"=>"ASC"), Array("ID"=>$id, "ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ADD_EDIT));
		while($property = $properties->Fetch())
		{
			$property=array_merge($property, $prop);
			$property_array[$property["ID"]]=$property;
		}
	}

	
	$PROPERTY_VALUES=array();
	foreach ($property_array as $property)
	{
		/*Не заполнены поля*/
		if ($_REQUEST[$property["CODE"]]=="" && ($property["IS_REQUIRED"]=="Y" && !in_array($property["CODE"], array("RESERV_CONFIRM")) &&  stripos($property["CODE"], "CHECKBOX_YN_")==false)) 
		{
			$return["error"].="Не заполнено поле: ".$property["NAME"]."<br>";
		}
		
		if ($_REQUEST[$property["CODE"]]!="")
		{
			/*Свойство да\нет*/
			if ($property["CODE"]=="RESERV_CONFIRM" || stripos($property["CODE"], "CHECKBOX_YN_")!==false)
			{
				$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ADD_EDIT, "CODE"=>$CODE));
				while($enum_fields = $property_enums->GetNext())
				{
					/* $prop_array[$enum_fields["ID"]]=$enum_fields["VALUE"]; */
					$yes_value=$enum_fields;
					break;
				}	
				$PROPERTY_VALUES[$property["CODE"]]=$yes_value["ID"];
			}
			else
			/*Прочие свойства*/
			$PROPERTY_VALUES[$property["CODE"]]=$_REQUEST[$property["CODE"]];
		}
	}
	
	
	if ($return["error"]=="")
	{
		/*Добавление нового элемента*/
		if (!$_REQUEST["ID"]>0)
		{
			$arOfferFields = array(
					'NAME' => $_REQUEST["NAME"],
					'IBLOCK_ID' => $IBLOCK_ADD_EDIT,
					'ACTIVE' => 'Y',
					'PROPERTY_VALUES' => $PROPERTY_VALUES
			);
			if ($add_id = $elem->Add($arOfferFields))
			{
				$return["result"]="Элемент успешно добавлен";
			}
			else
			{
				$return["error"].=$elem->LAST_ERROR."<br>";
			}
		}
		
		/*Редактирование элемента*/
		if ($_REQUEST["ID"]>0)
		{
			$elem->Update($_REQUEST["ID"], 
			array(
				"NAME"=>$_REQUEST["NAME"],
				"PROPERTY_VALUES"=> $PROPERTY_VALUES
			));
			$return["result"]="Элемент успешно изменен";
		}
	}
	print json_encode($return);
}



?>