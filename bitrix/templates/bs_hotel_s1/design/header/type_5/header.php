<?
if (!isset($GLOBALS["OPTION_MENU_COLOR_TYPE"])) $GLOBALS["OPTION_MENU_COLOR_TYPE"]="CSS_TRANS";

use Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/design/header/type_$header_type/style.css");
?>
<header class="header_type_<?=$header_type?> <?=strtolower($GLOBALS["OPTION_MENU_COLOR_TYPE"]) ?>">
<div class="content_container d-flex">
		<div class="logo d-flex align-self-center">
			<?=$logo_href[0]?><?$APPLICATION->IncludeFile(SITE_DIR."include/logo.php");?><?=$logo_href[1]?>
		</div>
		<div class="d-flex align-self-center flex-grow-1">
		<?$APPLICATION->IncludeComponent(
			"bitrix:menu", 
			"main_menu_fly", 
			array(
				"ALLOW_MULTI_SELECT" => "N",
				"CHILD_MENU_TYPE" => "",
				"COMPONENT_TEMPLATE" => "main_menu",
				"DELAY" => "N",
				"MAX_LEVEL" => "3",
				"MENU_CACHE_GET_VARS" => array(
				),
				"MENU_CACHE_TIME" => "3600",
				"MENU_CACHE_TYPE" => "N",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"MENU_THEME" => "green",
				"ROOT_MENU_TYPE" => "top",
				"USE_EXT" => "Y",
				"SHOW_SEARCH_MENU" => "N"
			),
			false
		);?>
		</div>
		<div class="d-none d-sm-flex align-self-center">
			<div class="phone iconfont_a_container"><?$APPLICATION->IncludeFile(SITE_DIR."include/phone1.php");?></div>
		</div>
		<div class="d-flex align-self-center"><div class="mobile_menu" style="display: none;"><div class="icon"><div class="button"></div></div></div></div>
	</div>
	


</header>