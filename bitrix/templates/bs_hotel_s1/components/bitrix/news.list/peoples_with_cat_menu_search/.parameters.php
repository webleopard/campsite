<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule("iblock")) return;

/*Инфоблоки объектов*/
$res_iblocks = CIBlock::GetList(Array(), Array('TYPE'=>'objects', 'ACTIVE'=>'Y'), true);
$arIBlocks=array();
while($arRes = $res_iblocks->Fetch())
{
	$arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];
}

$arTemplateParameters = array(		
	"SHOW_LEFT_MENU" => Array(
		"PARENT" => "BASE",
		"NAME" => "Показывать меню слева",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y"
	),
	"SHOW_SEARCH" => Array(
		"PARENT" => "BASE",
		"NAME" => "Показывать поиск",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y"
	),
	"CATEGORY_FILTER" => Array(
		"PARENT" => "BASE",
		"NAME" => "ID категории(ий)",
		"TYPE" => "STRING",
		"DEFAULT" => ""
	),	
	"HIDE_HEADER_WITH_FILTER" => Array(
		"PARENT" => "BASE",
		"NAME" => "Скрыть название раздела при наличии фильтра по ID категории",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N"
	),
		
);


?>
