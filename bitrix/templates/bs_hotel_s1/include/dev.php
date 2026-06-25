<?
$dev_img="include/images/dev.png";

if ($GLOBALS["OPTION_FOOTER_FONT_COLOR"]=="CSS_DARK")
$dev_img="include/images/dev_css_dark.png";

?>
<div class="dev text-left">
	<div class="dev_text"><a href="https://brain-site.ru/" target="_blank"><?=GetMessage("DEV_TITLE")?></a>:</div>
	<div><a href="https://brain-site.ru/" title="Создание сайтов" target="_blank"><img src="<?=SITE_DIR ?><?=$dev_img ?>" alt="Создание сайтов"/></a></div>
</div>