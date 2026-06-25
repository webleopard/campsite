<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;
//delayed function must return a string
if(empty($arResult))
	return "";

$newResult=array();
foreach ($arResult as $ar)
{
	if ($ar['LINK']!='/aditional/')	
	$newResult[]=$ar;
}
$arResult=$newResult;

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
/* $css = $APPLICATION->GetCSSArray();
if(!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css))
{
	$strReturn .= '<link href="'.CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css").'" type="text/css" rel="stylesheet" />'."\n";
} */

$itemSize = count($arResult);

$strReturn .= '<div class="bx-breadcrumb">';

if ($itemSize>0) $strReturn.='<div class="bx-breadcrumb-item"itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.SITE_DIR.'" title="Главная" itemprop="url"><span itemprop="title" class="home">Главная</span></a><span class="arrow"><img src="'.SITE_DIR.'include/images/svg/arrow_nav.svg"></span></div>';

for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	$nextRef = ($index < $itemSize-2 && $arResult[$index+1]["LINK"] <> ""? ' itemref="bx_breadcrumb_'.($index+1).'"' : '');
	$child = ($index > 0? ' itemprop="child"' : '');
	$arrow = ($index > 0? '<span class="arrow"><img src="'.SITE_DIR.'include/images/svg/arrow_nav.svg"></span>' : '');

	if ($arResult[$index]["LINK"]=='/slider/') $arResult[$index]["LINK"]='';

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1 )
	{
		$strReturn .= '
			<div class="bx-breadcrumb-item" id="bx_breadcrumb_'.$index.'" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"'.$child.$nextRef.'>
				'.$arrow.'
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="url">
					<span itemprop="title">'.$title.'</span>
				</a>
			</div>';
	}
	else
	{
		$strReturn .= '
			<div class="bx-breadcrumb-item">
				'.$arrow.'
				<span>'.$title.'</span>
			</div>';
	}
}

$strReturn .= '</div><div class="clear"></div>';


return $strReturn;
