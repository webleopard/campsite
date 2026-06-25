<?
$no_container=true;
$GLOBALS['no_footer_padding']=true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Об отеле");
?>
<div class="content_container">
<?
$APPLICATION->IncludeFile($APPLICATION->GetCurDir()."block_text.php", Array(), Array("MODE" => "html", "NAME" => ""));
?>
<?include("block_prop_list.php");?>
<?include("block_photo_section.php");?>
</div>
<div class="air p50"></div>
<?
$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	".default",
	Array(
		"AREA_FILE_RECURSIVE" => "Y",
		"AREA_FILE_SHOW" => "file",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => ".default",
		"PATH" => SITE_TEMPLATE_PATH."/include/blocks/advantage.php"
	)
);?>
<?
$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	".default",
	Array(
		"AREA_FILE_RECURSIVE" => "Y",
		"AREA_FILE_SHOW" => "file",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => ".default",
		"PATH" => SITE_TEMPLATE_PATH."/include/blocks/map.php"
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>