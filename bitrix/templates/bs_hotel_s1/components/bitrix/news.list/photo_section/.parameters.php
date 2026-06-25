<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule("iblock")) return;


/*Секции*/
$arIBlocksSections[0]="";

$arFilter = Array('IBLOCK_ID'=>$arCurrentValues["IBLOCK_ID"]);
$db_list = CIBlockSection::GetList(Array(), $arFilter, true);
while($ar_result = $db_list->GetNext())
{
	$arIBlocksSections[$ar_result["ID"]] = "[".$ar_result["ID"]."] ".$ar_result["NAME"];
}


$arTemplateParameters = array(
	"IBLOCK_SECTION_ID" => Array(
		"PARENT" => "BASE",
		"NAME" => "Раздел",
		"TYPE" => "LIST",
		"VALUES" => $arIBlocksSections,			
	),
	"IBLOCK_SECTION_NAME" => Array(
		"PARENT" => "BASE",
		"NAME" => "Название раздела(вместо ID)",
		"TYPE" => "STRING"		
	)
	

);
?>
