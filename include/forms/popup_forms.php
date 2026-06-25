<div id="message_form" class="ajax_form popup color">
	<div class="popup_content">
		<div class="header3"></div>
		<p></p>
		<div class="air p20"></div>
		<div class="center">
			<a class="btn ripple" data-fancybox-close="" onclick="return false" href="#">Закрыть</a>
		</div>
	</div>
</div>


<div id="popup_form_modul" class="ajax_form popup color">
	<div class="popup_content">
	<?$APPLICATION->IncludeComponent(
	"brainsite:iblock.element.add.form", 
	"popup_form_hotel", 
	array(
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "popup_modul",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
		"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
		"CUSTOM_TITLE_DETAIL_PICTURE" => "",
		"CUSTOM_TITLE_DETAIL_TEXT" => "",
		"CUSTOM_TITLE_IBLOCK_SECTION" => "",
		"CUSTOM_TITLE_NAME" => "Имя",
		"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
		"CUSTOM_TITLE_PREVIEW_TEXT" => "",
		"CUSTOM_TITLE_TAGS" => "",
		"DEFAULT_INPUT_SIZE" => "30",
		"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
		"ELEMENT_ASSOC" => "CREATED_BY",
		"GROUPS" => array(
			0 => "2",
		),
		"HIDE_LABEL" => "Y",
		"HIDE_NAME_INPUT" => "Y",
		"IBLOCK_ID" => "15",
		"IBLOCK_TYPE" => "",
		"LABEL_HIDE" => "Y",
		"LEVEL_LAST" => "Y",
		"LICENSE_SHOW" => "Y",
		"LIST_URL" => "",
		"MAX_FILE_SIZE" => "0",
		"MAX_LEVELS" => "100000",
		"MAX_USER_ENTRIES" => "100000",
		"NAME_REPLACE" => "",
		"PLACEHOLDER_NAME" => "Ваше имя",
		"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
		"PROPERTY_CODES" => array (
  0 => 'NAME',
  1 => '49',
  2 => '50',
  3 => '51',
  4 => '54',
  5 => '55',
  6 => '56',
),
		"PROPERTY_CODES_REQUIRED" => array(
		),
		"RESIZE_IMAGES" => "N",
		"SEF_MODE" => "N",
		"SOURCE_NAME" => "Заказ звонка",
		"STATUS" => "ANY",
		"STATUS_NEW" => "N",
		"SUBMIT_CSS" => "",
		"SUBMIT_PARENT_CSS" => "center",
		"SUBMIT_TEXT" => "Отправить",
		"USER_MESSAGE_ADD" => "Спасибо за вашу заявку! В ближайшее время с вами свяжутся.",
		"USER_MESSAGE_EDIT" => "Ваше сообщение отправлено!",
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => "popup_form_hotel"
	),
	false
);?>
	</div>
</div>
