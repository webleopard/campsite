<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	"about", 
	array(
		"PATH" => SITE_TEMPLATE_PATH."/include/main_include_empty.php",
		"COMPONENT_TEMPLATE" => "map_contacts",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_RECURSIVE" => "Y",
		"EDIT_TEMPLATE" => ".default"
	),
	false
);
?>