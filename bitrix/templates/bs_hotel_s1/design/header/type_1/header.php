<?require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/header/include/fix_header.php");?>
<?require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/header/include/top_search.php");?>
<?require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/header/include/top_panel.php");?>
<header class="header_type_<?=$header_type?>">
	<div class="content_container">
		<div class="header_content d-flex justify-content-between">
			<div class="align-self-center logo text-center text-xl-left flex-grow-1 flex-xl-grow-0">
				<div class="mobile_menu" style="display: none;"><div class="icon"><div class="button"></div></div></div>
				<?=$logo_href[0]?><?$APPLICATION->IncludeFile(SITE_DIR."include/logo.php");?><?=$logo_href[1]?>
			</div>
			
			<div class="flex-grow-1 justify-content-center d-none d-lg-flex">
				<div class="slogan flex-grow-1 align-self-center text-center d-block"><?$APPLICATION->IncludeFile(SITE_DIR."include/slogan.php");?></div>
			</div>
			
			<div class="callback nobr d-none d-sm-flex"><div class="align-self-center"><a class="fancybox btn ripple" data-comment="Заказ звонка" href="#popup_callback"><?=GetMessage("CALLBACK_BTN_TEXT") ?></a></div></div>
			
			
		</div>
	</div>
	

<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"main_menu", 
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
</header>