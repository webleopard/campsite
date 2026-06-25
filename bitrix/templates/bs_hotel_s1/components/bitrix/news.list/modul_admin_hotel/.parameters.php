<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule("iblock")) return;

/*Инфоблоки объектов*/
$res_iblocks = CIBlock::GetList(Array(), Array('ACTIVE'=>'Y'), true);
$arIBlocks=array();
while($arRes = $res_iblocks->Fetch())
{
	$arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];
}


$arTemplateParameters = array(
		"IBLOCK_ROOMS_ID" => Array(
				"PARENT" => "BASE",
				"NAME" => "Инфоблок \"Номерной фонд\"",
				"TYPE" => "LIST",
				"VALUES" => $arIBlocks,
					
		),
		"IBLOCK_RESERV_ID" => Array(
				"PARENT" => "BASE",
				"NAME" => "Инфоблок \"Бронь\"",
				"TYPE" => "LIST",
				"VALUES" => $arIBlocks,	
					
		),
		"DEMO_MODE" => Array(
			"NAME" => GetMessage("T_IBLOCK_DESC_DEMO_MODE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		)
);

$arTemplateParameters = array(
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_NAME" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	)
);
?>
