<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"SLIDER_ON_MOBILE" => Array(
		"PARENT" => "BASE",
		"NAME" => "Слайдер на мобильном",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"COUNT_LINE" => Array(
		"PARENT" => "BASE",
		"NAME" => "Элементов в строке",
		"TYPE" => "STRING",
		"DEFAULT" => "4"
	),
	"HEADER_H2" => Array(
		"NAME" => GetMessage("T_IBLOCK_HEADER_H2"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"PARENT" => "BASE",
	)
		
);
?>