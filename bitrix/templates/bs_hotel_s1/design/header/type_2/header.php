<?require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/header/include/fix_header.php");?>
<?require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/header/include/top_search.php");?>
<?require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/header/include/top_menu.php");?>
<?
use Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/design/header/type_$header_type/style.css");
?>
<header class="header_type_<?=$header_type?>">
	<div class="content_container">
		<div class="header_content d-flex justify-content-between">
			<div class="align-self-center logo text-center text-xl-left flex-grow-1 flex-xl-grow-0">
				<div class="mobile_menu" style="display: none;"><div class="icon"><div class="button"></div></div></div>
				<?=$logo_href[0]?><?$APPLICATION->IncludeFile(SITE_DIR."include/logo.php");?><?=$logo_href[1]?>
			</div>
			
			<div class="flex-grow-1 justify-content-center d-none d-xl-flex">
				<div class="slogan_search flex-grow-1 align-self-center d-block">
					<div class="slogan"><?$APPLICATION->IncludeFile(SITE_DIR."include/slogan.php");?></div>
					<?if ($GLOBALS["OPTION_HEADER_SEARCH"]=="Y"){?>
						<div class="air p15"></div>
						<div class="menu_search d-inline-block w100p">
							<?require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/header/include/header_search.php");?>
						</div>
					<?} ?>
				</div>
			</div>
			
			
			
			<div class="contacts_container text-left align-self-center d-none d-sm-block">
				
				<div class="address">
					<i  class="vmiddle"><svg width="18px" height="18px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M 16 3 C 11.042969 3 7 7.042969 7 12 C 7 13.40625 7.570313 15.019531 8.34375 16.78125 C 9.117188 18.542969 10.113281 20.414063 11.125 22.15625 C 13.148438 25.644531 15.1875 28.5625 15.1875 28.5625 L 16 29.75 L 16.8125 28.5625 C 16.8125 28.5625 18.851563 25.644531 20.875 22.15625 C 21.886719 20.414063 22.882813 18.542969 23.65625 16.78125 C 24.429688 15.019531 25 13.40625 25 12 C 25 7.042969 20.957031 3 16 3 Z M 16 5 C 19.878906 5 23 8.121094 23 12 C 23 12.800781 22.570313 14.316406 21.84375 15.96875 C 21.117188 17.621094 20.113281 19.453125 19.125 21.15625 C 17.554688 23.867188 16.578125 25.300781 16 26.15625 C 15.421875 25.300781 14.445313 23.867188 12.875 21.15625 C 11.886719 19.453125 10.882813 17.621094 10.15625 15.96875 C 9.429688 14.316406 9 12.800781 9 12 C 9 8.121094 12.121094 5 16 5 Z M 16 10 C 14.894531 10 14 10.894531 14 12 C 14 13.105469 14.894531 14 16 14 C 17.105469 14 18 13.105469 18 12 C 18 10.894531 17.105469 10 16 10 Z"/></svg></i>
					<?$APPLICATION->IncludeFile(SITE_DIR."include/address.php");?>	
				</div>
				<div class="air p10"></div>
				
				<div class="phone svg_hover_container flex-grow-1">
					<i class="vmiddle"><svg class="svg" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M30.637 23.152c-0.109-0.676-0.334-1.282-0.654-1.825l0.013 0.024c-0.114-0.186-0.301-0.317-0.521-0.353l-0.004-0.001-8.969-1.424c-0.035-0.006-0.076-0.009-0.117-0.009-0.207 0-0.395 0.083-0.531 0.218l0-0c-0.675 0.68-1.194 1.516-1.496 2.45l-0.012 0.044c-4.015-1.64-7.139-4.765-8.742-8.674l-0.038-0.105c0.977-0.315 1.814-0.833 2.493-1.509l-0 0c0.136-0.136 0.22-0.324 0.22-0.531 0-0.041-0.003-0.081-0.010-0.121l0.001 0.004-1.423-8.97c-0.037-0.225-0.169-0.413-0.353-0.524l-0.003-0.002c-0.505-0.3-1.094-0.52-1.723-0.626l-0.030-0.004c-0.283-0.072-0.608-0.113-0.943-0.113-0.063 0-0.126 0.001-0.189 0.004l0.009-0c-3.498 0.025-6.326 2.855-6.348 6.351v0.002c0.015 12.761 10.355 23.102 23.115 23.116h0.001c3.5-0.021 6.332-2.852 6.354-6.349v-0.002c0-0.025 0.001-0.054 0.001-0.084 0-0.35-0.037-0.691-0.106-1.021l0.006 0.032zM24.383 29.076c-11.933-0.014-21.602-9.684-21.616-21.615v-0.001c0.019-2.674 2.182-4.836 4.855-4.854h0.002c0.014-0 0.030-0 0.046-0 0.275 0 0.544 0.030 0.802 0.086l-0.025-0.005c0.367 0.060 0.695 0.162 1.002 0.301l-0.025-0.010 1.301 8.201c-0.628 0.529-1.404 0.902-2.257 1.051l-0.029 0.004c-0.355 0.064-0.62 0.37-0.62 0.739 0 0.088 0.015 0.172 0.043 0.25l-0.002-0.005c1.773 5.072 5.696 8.994 10.646 10.73l0.121 0.037c0.073 0.026 0.157 0.041 0.244 0.041 0.14 0 0.272-0.038 0.384-0.105l-0.003 0.002c0.186-0.111 0.318-0.295 0.357-0.511l0.001-0.005c0.153-0.883 0.526-1.66 1.061-2.296l-0.006 0.007 8.201 1.303c0.133 0.296 0.238 0.641 0.297 1.001l0.003 0.024c0.045 0.212 0.071 0.455 0.071 0.704 0 0.024-0 0.049-0.001 0.073l0-0.004c-0.016 2.675-2.179 4.839-4.852 4.857h-0.002z"></path></svg></i>
					<?$APPLICATION->IncludeFile(SITE_DIR."include/phone1.php");?>
				</div>
				
				<?if(filesize($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/email.php")) {?>
				<div class="air p10"></div>
				<div class="email svg_hover_container flex-grow-1 d-none d-lg-block">
					<i class="vmiddle">
					<svg class="svg" fill="#000000" width="14px" height="14px" viewBox="0 0 128 128" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M127,16H1v6.7l63,59.8l55-52.2V104H9V50H1v62h126V16z M64,71.5L14,24H114L64,71.5z"/></g></svg>
					</i>
					<?$APPLICATION->IncludeFile(SITE_DIR."include/email.php");?>
				</div>
				<?} ?>
			
				
			</div>
			
			<div class="align-self-center callback_container d-none d-lg-block">
				<a class="fancybox btn ripple" data-comment="Заказ звонка" href="#popup_callback">Заказать звонок</a>
			</div>
			
			
			
		</div>
	</div>
</header>