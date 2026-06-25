<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"USE_SLIDER" => Array(
		"NAME" => GetMessage("T_IBLOCK_USE_SLIDER"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"PARENT" => "BASE",
	),
	"SHOW_ADDIT_BUTTON" => Array(
		"NAME" => GetMessage("T_IBLOCK_SHOW_ADDIT_BUTTON"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
		"PARENT" => "BASE",
	),
	"ADDIT_BUTTON_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_ADDIT_BUTTON_TEXT"),
		"TYPE" => "TEXT",
		"DEFAULT" => GetMessage("T_IBLOCK_ADDIT_BUTTON_TEXT_DEFAULT"),
		"PARENT" => "BASE",
	),
	"HEADER_H2" => Array(
		"NAME" => GetMessage("T_IBLOCK_HEADER_H2"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"PARENT" => "BASE",
	)
	
		
);
?>
