<div class="top_panel d-none d-sm-block">
	<div class="content_container">
		<div class="d-flex">		
			<div class="address iconfont_container flex-grow-1 d-none d-sm-block">
				<?$APPLICATION->IncludeFile(SITE_DIR."include/address.php");?>
			</div>
			
			<div class="phone iconfont_a_container flex-grow-1 text-center">
				<?$APPLICATION->IncludeFile(SITE_DIR."include/phone1.php");?>
			</div>
		
			
			<?if(filesize($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/email.php")) {?>
			<div class="email iconfont_a_container flex-grow-1 d-none d-md-block <?=$GLOBALS["SHOW_TOP_PANEL_CALLBACK"]!="Y" ? "text-right":"text-center"?>">
				<?$APPLICATION->IncludeFile(SITE_DIR."include/email.php");?>
			</div>
			<?} ?>
			
			<?if ($GLOBALS["OPTION_HEADER_SEARCH"]=="Y" || empty($GLOBALS["OPTION_HEADER_SEARCH"])){?>
			<div class="flex-grow-1 d-none d-lg-block text-center">
				<a href="javascript:void(0);" class="show_top_search iconfont_a">Поиск</a>
			</div>
			<?} ?>
			
			<?if ($GLOBALS["OPTION_SHOW_VSV"]=="Y") {?>
			<div class="vsv iconfont_a_container">
				<a class="show_vsv" href="javascript:void(0);"></a>
			</div>
			<?} ?>
			
			<?if ($GLOBALS["SHOW_TOP_PANEL_CALLBACK"]=="Y") {?>
			<div class="flex-grow-1 text-center callback_container d-none d-lg-block">
				<a class="fancybox btn panel_btn ripple" data-comment="Заказ звонка" href="#popup_callback">Заказать звонок</a>
			</div>
			<?} ?>
			
		</div>
	</div>
</div>