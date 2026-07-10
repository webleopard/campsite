<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	"map_contacts", 
	[
		"PATH" => SITE_TEMPLATE_PATH."/include/main_include_empty.php",
		"COMPONENT_TEMPLATE" => "map_contacts",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_RECURSIVE" => "Y",
		"EDIT_TEMPLATE" => ".default",
		"COORDS" => "53.415924, 50.124587",
		"FORM_HEADER" => "Адрес базы отдыха САЛЮТ"
	],
	false
);
?>