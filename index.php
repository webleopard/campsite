<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "База отдыха «Салют»");
$APPLICATION->SetTitle("База отдыха «Салют»");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
?>

<?
require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/index_page/index_page.php");
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>