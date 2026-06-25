<?
$config_file=$_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/design/settings_config.php';




/*Конфиг демо*/
if(!$USER->IsAdmin())
{
	$demo_config_dir=$_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/design/demo/';
	$demo_config_name=$demo_config_dir.'settings_config_'.session_id().'.php';
	if (file_exists($demo_config_name))
	$config_file=$demo_config_name;
	/*Чистим старые демо конфиги*/
	if ($handle = opendir($demo_config_dir)) 
	{
		while (false !== ($entry = readdir($handle)))
		{
			if ($entry != "." && $entry != "..") {
	
				$diff = time()-filemtime($demo_config_dir.$entry);
				$days = round($diff/86400);
				
				if ($days>1)
				unlink($demo_config_dir.$entry);
			}
		}
	}
}





include($config_file);
include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/design/functions.php');
include($_SERVER["DOCUMENT_ROOT"].'/bitrix/components/brainsite/settings.hotel/templates/.default/lang/'.LANGUAGE_ID.'/template.php');
/* if (!empty($settings_array)) */
{

	if (empty($settings_array))
	include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/design/pre_settings.php');
	
	foreach ($settings_array as $k=>$v)
	{
		$GLOBALS[$k]=$v;
	}


	/*Шрифт*/
	$all_fonts=GetMessage("OPTION_FONT");
	if ($GLOBALS["OPTION_FONT"]!='')
	{
		$font=$all_fonts[$GLOBALS["OPTION_FONT"]];
	}
	else
	{
		foreach (GetMessage("OPTION_FONT") as $k=>$item)
		if ($item["default"]) $font=$item;
	} 

	/*Ширина сайта*/
	if ($GLOBALS["OPTION_SITE_WIDTH"]!='')
	{
		$site_width=$GLOBALS["OPTION_SITE_WIDTH"]."px";
		$GLOBALS["SITE_WIDTH"]=$GLOBALS["OPTION_SITE_WIDTH"];
	}
	else
	{
		foreach (GetMessage("OPTION_SITE_WIDTH") as $k=>$item)
		if ($item["default"]) 
		{
			$site_width=$k."px";
			$GLOBALS["SITE_WIDTH"]=$k;
		}
	}
	
	/*Основной цвет*/
	if ($GLOBALS["OPTION_COLOR_CUSTOM"]!='')
	{
		$base_color=$GLOBALS["OPTION_COLOR_CUSTOM"];
	}
	elseif ($GLOBALS["OPTION_BASE_COLOR"]!="")
	{
		$base_color=$GLOBALS["OPTION_BASE_COLOR"];
	}
	if ($base_color=="")  
	{
		foreach (GetMessage("BASE_COLORS") as $k=>$item)
		if ($item["default"]==true) $base_color=$item["color"];
	}
	
	/*Цвет футера*/
	if ($GLOBALS["OPTION_COLOR_FOOTER_CUSTOM"]!='')
	{
		$footer_color=$GLOBALS["OPTION_COLOR_FOOTER_CUSTOM"];
	}
	elseif ($GLOBALS["OPTION_COLOR_FOOTER"]!="")
	{
		$footer_color=$GLOBALS["OPTION_COLOR_FOOTER"];
	}
	
	if ($footer_color=="")
	{
		foreach (GetMessage("OPTION_FOOTER_COLOR") as $k=>$item)
		if ($item["default"]==true) $footer_color=$item["color"];
	
	}
	
	$GLOBALS["OPTION_BASE_COLOR"]=$base_color;
	$OPTION_BASE_COLOR_L=adjustBrightness($base_color, 20);
	$OPTION_BASE_COLOR_D=adjustBrightness($base_color, -20);
	$OPTION_BASE_COLOR_D2=adjustBrightness($base_color, -40);
	$OPTION_BASE_COLOR_L2=adjustBrightness($base_color, 40);
	$OPTION_BASE_COLOR_L4=adjustBrightness($base_color, 80);
	$OPTION_BASE_COLOR_L8=adjustBrightness($base_color, 160);
	

	$GLOBALS["OPTION_FOOTER_COLOR"]=$footer_color;
	$OPTION_FOOTER_COLOR_L=adjustBrightness($footer_color, 20);
	$OPTION_FOOTER_COLOR_D=adjustBrightness($footer_color, -20);


}


$GLOBALS["IMG_HOVER_EFFECT"]="shine";


if ($GLOBALS["NO_SETTINGS_STYLE"]!="Y"){
?>

<style>
<?=$font["import"] ?>;
:root {
	
	--SITE_WIDTH: <?=$site_width?>;
	
	--OPTION_FONT_FAMILY: <?=$font["font-family"] ?>;
    
    --OPTION_BASE_COLOR: <?=$GLOBALS["OPTION_BASE_COLOR"] ?>;
	--OPTION_BASE_COLOR_L:  <?=$OPTION_BASE_COLOR_L ?>;
	--OPTION_BASE_COLOR_D:  <?=$OPTION_BASE_COLOR_D ?>;
	--OPTION_BASE_COLOR_L2: <?=$OPTION_BASE_COLOR_L2 ?>;
	--OPTION_BASE_COLOR_L4: <?=$OPTION_BASE_COLOR_L4 ?>;	
	--OPTION_BASE_COLOR_L8: <?=$OPTION_BASE_COLOR_L8 ?>;	
		
	--OPTION_FOOTER_COLOR: <?=$footer_color ?>;
	--OPTION_FOOTER_COLOR_L: <?=$OPTION_FOOTER_COLOR_L ?>;
	--OPTION_FOOTER_COLOR_D: <?=$OPTION_FOOTER_COLOR_D ?>;
	
	--OPTION_BASE_COLOR_FILTER: <?=$GLOBALS["OPTION_BASE_COLOR_FILTER"] ?>;
	
	--OPTION_GRADIENT: linear-gradient(to right, <?=$OPTION_BASE_COLOR_L2?> 0%, <?=$OPTION_BASE_COLOR_D2?> 100%);
}
</style>
<?} ?>
