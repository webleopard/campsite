<?
$footer_type="1";

if (!empty($GLOBALS["OPTION_FOOTER_TYPE"]) && $GLOBALS["OPTION_FOOTER_TYPE"]>0)
{
	$footer_type=$GLOBALS["OPTION_FOOTER_TYPE"];
}


$footer_css_filter_logo=false;
if (empty($GLOBALS["OPTION_FOOTER_CSS_FILTER_LOGO"]) || $GLOBALS["OPTION_FOOTER_CSS_FILTER_LOGO"]=="Y")
{
	$footer_css_filter_logo=true;
}



require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/footer/type_$footer_type/footer.php");
?>