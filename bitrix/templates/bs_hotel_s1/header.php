<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noyaca"/>
	<meta name="robots" content="noodp"/>
    <title><? $APPLICATION->ShowTitle(); ?></title>
    
    <link href="<?=SITE_DIR?>favicon.png" rel="icon" />
	<?
	$APPLICATION->ShowHead();
	
	use Bitrix\Main\Page\Asset;
	?>
	<script>
    BX.message({
    	'DEF_POPUP_HEADER': '<?=GetMessageJS("DEF_POPUP_HEADER")?>',//BX.message("DEF_POPUP_HEADER")
    });
    </script>
	<?
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery.js");
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/main.js");
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/project.js");
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery.maskedinput.min.js");
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery.mobile.custom.js");
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery.dragscroll.min.js");
	
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/css/fontawesome/css/font-awesome.min.css');
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/iconfont/style.css");
	
	$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/design/settings_final.php");
	$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/design/bg/index.php");
	
	
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/default.css");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/universal.css");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/site.css");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/media.css");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/custom.css");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/page.css");
	
	
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/bootstrap/bootstrap-grid.css");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/bootstrap/bootstrap-custom.css");
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/bootstrap.min.js");
	
	
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/js/fancybox/jquery.fancybox.min.css");
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/fancybox/jquery.fancybox.min.js");
	
	
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/js/OwlCarousel2-2.3.3/assets/owl.carousel.css");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/js/OwlCarousel2-2.3.3/assets/owl.theme.default.css");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/js/OwlCarousel2-2.3.3/assets/owl.theme.imagebutton.css");
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/OwlCarousel2-2.3.3/owl.carousel.js");
	
	
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery-ui-1.12.1.custom/jquery-ui.js");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/js/jquery-ui-1.12.1.custom/jquery-ui.css");
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery-ui-1.12.1.custom/jquery.ui.touch-punch.min.js");
	
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/select2-4.1.0-rc.0/js/select2.min.js");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/js/select2-4.1.0-rc.0/css/select2.css");
	
	
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/tooltipster/tooltipster.bundle.min.js");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/js/tooltipster/tooltipster.bundle.min.css");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/js/tooltipster/assets/tooltipster-sideTip-chess.css");
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/js/tooltipster/assets/tooltipster-sideTip-custom.css");
?>

<?
/*reCaptha*/
if ($GLOBALS["OPTION_USE_CAPTCHA"]=="Y" && isset($GLOBALS["OPTION_CAPTCHA_SETTINGS_captha_key"]) && isset($GLOBALS["OPTION_CAPTCHA_SETTINGS_captha_key"])) {?>
<script src="https://www.google.com/recaptcha/api.js?render=<?=$GLOBALS["OPTION_CAPTCHA_SETTINGS_captha_key"] ?>"></script>
<script>
        grecaptcha.ready(function () {
            grecaptcha.execute('<?=$GLOBALS["OPTION_CAPTCHA_SETTINGS_captha_key"] ?>', { action: 'contact' }).then(function (token) {
                $("input[name=recaptcha_response]").each(function(){ 
	                $(this).val(token); 
	            });
            });
        });      
</script>
<?} ?>


<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

</head>
<body class="<?=($APPLICATION->getCurPage(false)!=SITE_DIR ? 'second_page' : 'index_page')?> <?=$GLOBALS["OPTION_SITE_THEME"]?> site_width_<?=$GLOBALS["SITE_WIDTH"]?> <?=$GLOBALS["bg_page"]["BG_FILL_BG_CONTAINER"]["VALUE_XML_ID"]=="Y" ? "bg_container":"" ?> <?=$_SESSION['vsv_settings']?>" <?/*style*/?> <?=($GLOBALS["bg_css_str"]!="" && $GLOBALS["bg_page"]["BG_ONLY_PAGE_CONTAINER"]["VALUE_XML_ID"]!="Y") ? $GLOBALS["bg_css_str"]:"" ?>>


<?$APPLICATION->ShowPanel();?>

<?
$logo_href=array();
if ($APPLICATION->getCurPage(false) != SITE_DIR) $logo_href=array('<a href="'.SITE_DIR.'">', '</a>');
?>
<?
/*Версия для слабовидящих*/
if ($GLOBALS["OPTION_SHOW_VSV"]=="Y"){$APPLICATION->IncludeComponent("brainsite:vsv", ".default");}


/*Настройки компонент*/
$GLOBALS["solution_demo"]=false;
$APPLICATION->IncludeComponent("brainsite:settings.hotel", ".default");




if ($GLOBALS["OPTION_HEADER_FIT_TO_CONTAINER"]=="Y") print '<div class="content_container">';

/*Шапка по типу*/
require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/header/index.php");

/*Слайдер*/
if ($APPLICATION->getCurPage(false)==SITE_DIR)
include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/blocks/slider.php");

if ($GLOBALS["OPTION_HEADER_FIT_TO_CONTAINER"]=="Y") print '</div>';

?>



<div class="page_content_container <?=$GLOBALS["bg_page"]["BG_FILL_BG_CONTAINER"]["VALUE_XML_ID"]=="Y" ? "bg_container":"" ?>" <?/*style*/?> <?=($GLOBALS["bg_css_str"]!="" && $GLOBALS["bg_page"]["BG_ONLY_PAGE_CONTAINER"]["VALUE_XML_ID"]=="Y") ? $GLOBALS["bg_css_str"]:"" ?>>
<?
/*Левое меню*/
$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"left_menu",
	array(
			"ALLOW_MULTI_SELECT" => "N",
			"CHILD_MENU_TYPE" => "",
			"COMPONENT_TEMPLATE" => "main_menu",
			"DELAY" => "N",
			"MAX_LEVEL" => "1",
			"MENU_CACHE_GET_VARS" => array(
			),
			"MENU_CACHE_TIME" => "3600",
			"MENU_CACHE_TYPE" => "N",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_THEME" => "green",
			"ROOT_MENU_TYPE" => "left",
			"USE_EXT" => "Y",
			"SHOW_SEARCH_MENU" => "N"
	),
	false
);
?>
<div class="container_page page_content">
	
	<?if ($APPLICATION->getCurPage(false) != SITE_DIR):?><div class="content_container"><?endif;?>

	<?
	$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb", 
	"breadcrumb", 
	array(
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => "0",
		"COMPONENT_TEMPLATE" => "breadcrumb"
	),
	false
);
	

	

	/*$hide_h1=true;*/
	if ($APPLICATION->getCurPage(false) != SITE_DIR && !$hide_h1):?>
	<div class="content_container"><h1 class="styled"><?=$APPLICATION->ShowTitle(false)?></h1></div>
	<?endif;?>
	
	<?
	/*Закрываем content_container*/
	if ($no_container):?></div><?endif;?>
	