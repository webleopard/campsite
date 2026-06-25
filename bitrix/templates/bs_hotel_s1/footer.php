<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	
<?if ($APPLICATION->getCurPage(false) != SITE_DIR && !$no_container){?></div><?}?><!-- content_container -->
</div><!-- container_page -->
</div><!-- page_content_container -->

<?if ($APPLICATION->getCurPage(false) != SITE_DIR && !$GLOBALS['no_footer_padding']):?><div class="air p50"></div><?endif;?>

<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PATH" => SITE_DIR."/include/forms/popup_callback.php",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "",
		"AREA_FILE_RECURSIVE" => "Y",
		"EDIT_TEMPLATE" => ".default"
	),
	false
);?>

<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PATH" => SITE_DIR."/include/forms/popup_forms.php",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "",
		"AREA_FILE_RECURSIVE" => "Y",
		"EDIT_TEMPLATE" => ".default"
	),
	false
);?>

<?/*Футер по типу*/
require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/footer/index.php");
?>


<?if (empty($GLOBALS["OPTION_SHOW_SCROLL_TOP"]) || $GLOBALS["OPTION_SHOW_SCROLL_TOP"]=="Y"){?>
<a href="#" id="scrollTop"><svg width="30" height="30" viewBox="0 0 595.279 841.89" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"><path fill="#FFF" d="M508.656,449.669L329.774,253.287v429.495c0,16.132-16.489,29.823-32.621,29.822c-16.133,0-37.74-14.882-37.74-31.015V253.228L89.995,431.989c-11.428,11.489-37.979,10.239-50.658-4.286c-10.654-12.262-11.428-30.121,0-41.609l231.803-248.47c6.131-6.132,14.227-8.751,22.264-8.334c7.977-0.417,18.751,2.202,24.882,8.334l238.589,266.745c11.429,11.488,8.75,32.324-2.441,44.05C542.348,461.159,520.144,461.159,508.656,449.669z"/></svg></a>
<?} ?>
<?
/*Куки предупреждение*/
$APPLICATION->IncludeFile(SITE_DIR."include/cookie_modal.php");
?>
</body>
</html>