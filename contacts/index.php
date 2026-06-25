<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");?>

<div class="content_container">
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	"map", 
	array(
		"PATH" => SITE_TEMPLATE_PATH."/include/main_include_empty.php",
		"COMPONENT_TEMPLATE" => "map",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_RECURSIVE" => "Y",
		"EDIT_TEMPLATE" => ".default",
		"COORDS" => "53.426188, 50.121340",
		"FORM_HEADER" => "Заказать сайт под ключ"
	),
	false
);
?>
<div class="air p30"></div>
<div class="d-flex about flex-wrap">	
			<div class="contacts_content col-12 col-md-4">
				
				<div class="address_container flex-grow-1 d-inline-block text-left">
					<div class="align-self-center">
						<div class="address">
							<label>Адрес:</label>
							<div><?$APPLICATION->IncludeFile(SITE_DIR."include/address.php");?></div>
						</div>
					</div>
				</div>
				
				<div class="air p15"></div>
				<div class="phone_container">
					<div class="align-self-center">
						<div class="phone">
							<label>Телефон:</label>
							<div><?$APPLICATION->IncludeFile(SITE_DIR."include/phone1.php");?></div>
						</div>
					</div>
				</div>
				
				<?if(filesize($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/phone2.php")) {?>
				<div class="air p15"></div>
				<div class="phone_container">
					<div class="align-self-center">
						<div class="phone">
							<label>Телефон:</label>
							<div><?$APPLICATION->IncludeFile(SITE_DIR."include/phone2.php");?></div>
						</div>
					</div>
				</div>
				<?} ?>
				
				<div class="air p15"></div>
				<div class="email_container">
					<label>E-mail:</label>
					<div><?$APPLICATION->IncludeFile(SITE_DIR."include/email.php");?></div>
				</div>
				
								
				<?if(filesize($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/schedule.php")) {?>
				<div class="air p15"></div>
				<div class="phone_container">
					<div class="align-self-center">
						<div class="schedule">
							<div><?$APPLICATION->IncludeFile(SITE_DIR."include/schedule.php");?></div>
						</div>
					</div>
				</div>
				<?} ?>
					
			</div>
			<div class="col-12 col-md-8">
				<div class="air p20 d-md-none"></div>
				<div class="block type1"><?$APPLICATION->IncludeFile(SITE_DIR."include/about.php");?></div>
			</div>
				
				

</div>
<div class="air p40"></div>
<?include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/blocks/form.php"); ?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>