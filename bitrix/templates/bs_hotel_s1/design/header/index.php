<?
$header_type="1";

if (!empty($GLOBALS["OPTION_HEADER_TYPE"]) && $GLOBALS["OPTION_HEADER_TYPE"]>0)
{
	$header_type=$GLOBALS["OPTION_HEADER_TYPE"];
}

require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/header/type_$header_type/header.php");



?>