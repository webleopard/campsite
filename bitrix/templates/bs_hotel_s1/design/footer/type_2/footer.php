<footer class="footer_type_<?=$footer_type?> <?=strtolower($GLOBALS["OPTION_FOOTER_FONT_COLOR"])?> <?=$footer_css_filter_logo ? "footer_css_filter_logo":""?>">	
	<div class="content_container h100p">
	<div class="d-flex flex-column h100p">
				
				<div class="top_block row mr-0 ml-0 flex-grow-1">
						
						<div class="col-3 d-none d-lg-block">
							<div class="logo text-center">
							 	<?$APPLICATION->IncludeFile(SITE_DIR."include/logo_footer.php");?>
							 	<div class="air p10"></div>
							 	<div class="slogan"><?$APPLICATION->IncludeFile(SITE_DIR."include/slogan.php");?></div>
							</div>				
						</div>
						
						<div class="col-12 col-lg-9">
							<div class="row mr-0 ml-0">
								
								<div class="col-7 d-none d-sm-block">
									<div class="d-flex text-left justify-content-left justify-content-lg-center">
										<div class="col-6 footer_menu_container">
											
											<div class="footer_menu">
											<?$APPLICATION->IncludeComponent(
												"bitrix:menu", 
												"footer_menu", 
												array(
													"ALLOW_MULTI_SELECT" => "N",
													"CHILD_MENU_TYPE" => "",
													"COMPONENT_TEMPLATE" => "footer_menu_2level",
													"DELAY" => "N",
													"MAX_LEVEL" => "1",
													"MENU_CACHE_GET_VARS" => array(
													),
													"MENU_CACHE_TIME" => "3600",
													"MENU_CACHE_TYPE" => "A",
													"MENU_CACHE_USE_GROUPS" => "Y",
													"MENU_THEME" => "",
													"ROOT_MENU_TYPE" => "top",
													"USE_EXT" => "Y"
												),
												false
											);?>
											</div>
											<div class="air p30"></div>
										</div>
									</div>
									
								</div>
								
								
								<div class="col-12 col-sm-5 text-center text-sm-left">
									<div class="contacts">
										<div class="address d-inline-block iconfont_container flex-grow-1">
											<?$APPLICATION->IncludeFile(SITE_DIR."include/address.php");?>
										</div>
										
										<div class="phone iconfont_a_container">
											<?$APPLICATION->IncludeFile(SITE_DIR."include/phone1.php");?>
										</div>
										
										<?if(filesize($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/phone2.php")) {?>
										<div class="phone iconfont_a_container">
											<?$APPLICATION->IncludeFile(SITE_DIR."include/phone2.php");?>
										</div>
										<?} ?>
										
										<?if(filesize($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/phone3.php")) {?>
										<div class="phone iconfont_a_container">
											<?$APPLICATION->IncludeFile(SITE_DIR."include/phone3.php");?>
										</div>
										<?} ?>
										
										<?if(filesize($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/email.php")) {?>
										<div class="email iconfont_a_container flex-grow-1 d-none d-md-block">
											<?$APPLICATION->IncludeFile(SITE_DIR."include/email.php");?>
										</div>
										<?} ?>
									</div>
										
									<?
									if ($GLOBALS["OPTION_SHOW_VSV"]=="Y"){
										?>
										<div class="vsv iconfont_a_container">
											<a class="show_vsv nodecor" href="javascript:void(0);">Версия для слабовидящих</a>
										</div>
										<div class="air p10"></div>
										<?	
									}
									?>
									
									<div class="air p10"></div>
									<div class="callback"><a class="fancybox btn ripple" data-comment="Заказ звонка" href="#popup_callback"><?=GetMessage("CALLBACK_BTN_TEXT") ?></a></div>
									
								</div>
							</div>
					</div>
				</div>
		
				<div class="bottom_block">
					<div class="footer_bottom_block row mr-0 ml-0">
						<div class="col-3 text-center text-sm-left d-none d-md-block">
							<?$APPLICATION->IncludeFile(SITE_DIR."include/copyright.php");?>
						</div>
						
						<div class="col-12 col-md-6 text-center">
							<div class="social">
								<?require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/footer/include/social.php");?>
								<?$APPLICATION->IncludeFile(SITE_DIR."include/phone_viber.php");?>
								<?$APPLICATION->IncludeFile(SITE_DIR."include/phone_whatsapp.php");?>
							</div>
						</div>
						
						
						<div class="col-3 text-right d-none d-md-block"><?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"EDIT_TEMPLATE" => "",
										"PATH" => SITE_TEMPLATE_PATH."/include/dev.php"
									)
								);?>
						</div>
					</div>
				</div>
		
	</div>
	</div>
</footer>