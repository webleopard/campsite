<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"SUBMIT_TEXT" => Array(
		"NAME" => "Текст кнопки",
		"DEFAULT" => "Отправить",
		"TYPE" => "STRING",
		"COLS" => 25,
	),
	"SUBMIT_CSS" => Array(
		"NAME" => "Css класс для кнопки",
		"DEFAULT" => "",
		"TYPE" => "STRING",
		"COLS" => 25,
	),
	"PLACEHOLDER_NAME" => Array(
			"NAME" => "Placeholder поля 'NAME'",
			"DEFAULT" => "Ваше имя",
			"TYPE" => "STRING",
			"COLS" => 25,
	),
	"LABEL_HIDE" => Array(
		"NAME" => "Скрыть LABEL",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"LICENSE_SHOW" => Array(
		"NAME" => "Показать лицензионное соглашение",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"SOURCE_NAME" => Array(
		"NAME" => "Источник заявки (SOURCE)",
		"DEFAULT" => "",
		"TYPE" => "STRING",
		"COLS" => 25,
	)
);
?>