<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	"map_contacts", 
	array(
		"PATH" => SITE_TEMPLATE_PATH."/include/main_include_empty.php",
		"COMPONENT_TEMPLATE" => "map_contacts",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_RECURSIVE" => "Y",
		"EDIT_TEMPLATE" => ".default",
		"COORDS" => "53.426188, 50.121340",
		"FORM_HEADER" => "Заказать сайт"
	),
	false
);
?>