<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"SLIDER_ON_MOBILE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_SLIDER_ON_MOBILE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
		"PARENT" => "BASE",
	),
	"COUNT_LINE" => Array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("T_IBLOCK_DESC_COUNT_LINE"),
		"TYPE" => "STRING",
		"DEFAULT" => "4"
	),
		
);
?>
