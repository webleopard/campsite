<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Шаблон сайта для гостиницы, отеля, хостела с адаптивным дизайном и модулем управления бронированием на Битриксе");
$APPLICATION->SetTitle("Заказать сайт для для гостинцы, отеля, хостела, шаблон 1С Битрикс");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
?>

<?
require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/index_page/index_page.php");
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>