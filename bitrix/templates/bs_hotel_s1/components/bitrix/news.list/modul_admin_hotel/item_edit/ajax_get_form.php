<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');
require(str_replace('\\', '/', dirname(__DIR__))."/lang/ru/template.php");

$IBLOCK_ADD_EDIT=$_REQUEST["iblock_reserve_id"];

$hidden_fields=array();
$disabled_fields=array("CATEG_ID");



/*Элемент (редактирование)*/
if($_REQUEST["id"]>0)
{
	$arFilter = Array("IBLOCK_ID"=>$IBLOCK_ADD_EDIT, "ID"=>$_REQUEST["id"]);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$arProps = $ob->GetProperties();
		$item_add_edit=array_merge($arFields, $arProps);
	
	}
}

/*Добавление элемента*/
if (!$item_add_edit["ID"]>0)
{
	if (isset($_REQUEST["date"])) 
	{
		$item_add_edit["DATE_FROM"]["VALUE"]=$_REQUEST["date"];
		$item_add_edit["DATE_TO"]["VALUE"] = date('d.m.Y', strtotime($_REQUEST["date"] . ' +1 day'));
	}
	
	/*Включаем бронь подтверждена*/
	$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ADD_EDIT, "CODE"=>"RESERV_CONFIRM"));
	while($enum_fields = $property_enums->GetNext())
	{
		$item_add_edit["RESERV_CONFIRM"]["VALUE"]=$enum_fields["VALUE"];
		break;
	}
	
	$item_add_edit["CATEG_ID"]["VALUE"]=$_REQUEST["categ_id"];
	$item_add_edit["ROOM_ID"]["VALUE"]=$_REQUEST["room_id"];
	$disabled_fields[]="ROOM_ID";
}

?>
<div class="content_container">
	<form class="add_edit_form" id="add_edit_form" onsubmit="event.preventDefault();">
		<div class="header3"><?=$item_add_edit["ID"]>0 ? GetMessage("ADD_EDIT_HEADER_EDIT"):GetMessage("ADD_EDIT_HEADER_ADD") ?></div>
		
		<?
		if ($item_add_edit["ID"]>0){
			?>
			<div class="text-right"><a data-id="<?=$item_add_edit["ID"] ?>" href="javascript:void(0);" class="delete_item"><?=GetMessage("ADD_EDIT_HEADER_DEL") ?></a></div>
			<div class="air p20"></div>
			<?
		}
		?>
		
		<input class="hidden" name="ID" value="<?=$item_add_edit["ID"] ?>">
		<?
		
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
		
		
		
		
		
		$i=0;
		foreach ($property_array as $property)
		{
			/*NAME*/
			if ($i==1) include('input_fields/custom_name.php');
			
			if ($property["CODE"]=="ROOM_ID")
			{
				include('input_fields/custom_room_id.php');
			}
			elseif ($property["CODE"]=="RESERV_CONFIRM" || stripos($property["CODE"], "CHECKBOX_YN_")!==false)
			/*Чекбокс да\нет из списка*/
			{
				include('input_fields/checkbox_yn.php');
			}
			elseif (stripos($property["CODE"], "DATE")!==false)
			/*Дата*/
			{
				include('input_fields/date.php');
			}
			elseif ($property["PROPERTY_TYPE"]=="E" || $property["PROPERTY_TYPE"]=="L")
			{
				include('input_fields/select.php');
			}
			else
			include('input_fields/string.php');
			
			$i++;
		}
		

		if (is_array($jsParams))
		foreach ($arParams as $k=>$v)
		if (in_array($k,$jsParams))
		{
			?><input type="hidden" name="<?=$k ?>" value="<?=$v ?>"><?
		}
		
		?>
		<div class="air p10"></div>
		
		<?if ($_SESSION["demo_mode_module_admin"]) 
		{
			print "<b>".GetMessage("ADD_EDIT_DEMO_COMMENT")."</b>";
		}
		?>
		<div class="text-center">
			<div class="btn_container ripple"><input type="submit" class="btn" name="add_edit_submit" value="<?=$item_add_edit["ID"]>0 ? GetMessage("ADD_EDIT_HEADER_EDIT_BTN"):GetMessage("ADD_EDIT_HEADER_ADD_BTN") ?>"></div>
		</div>
	</form>
</div>