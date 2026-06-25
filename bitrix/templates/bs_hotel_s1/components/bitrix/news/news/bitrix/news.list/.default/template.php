<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if (!function_exists('getMonthRusNameLowerRP')) {
	function getMonthRusNameLowerRP($num){ $months = array("","января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря"); return $months[floor($num)]; }
}

$block_name="news";
$page_block=GetMessage("INDEX_PAGE_BLOCK")[$block_name];

$block_header="";
if (isset($GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name])) $block_header=$GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name];
else
$block_header=$page_block["header"]!="" ? $page_block["header"]:$page_block["name"];

$header_tag="h1";
if ($arParams["HEADER_H2"]=="Y") $header_tag="h2";
?>
<div class="content_container">
<<?=$header_tag ?> class="page_block_header"><?=$block_header ?></<?=$header_tag ?>>
<div class="slider_news <?=$arParams['NO_SLIDER']!='Y' ? 'owl-carousel owl-theme small-controls':''?> d-flex flex-wrap justify-content-center justify-content-xl-between">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<?
	
	$arFileTmp = CFile::ResizeImageGet(
			$arItem["PREVIEW_PICTURE"],
			array('width' => 300, 'height' => 240),
			BX_RESIZE_IMAGE_EXACT,
			true
			);
	
	/* $path_info = pathinfo($arFileTmp["src"]);
	$image_webp=webp($arFileTmp["src"]);
	$arFileTmp["src"]=$image_webp; */

	?>
	<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">	
		<?
		$day=$DB->FormatDate($arItem["ACTIVE_FROM"], "DD.MM.YYYY", "DD");
		$month=$DB->FormatDate($arItem["ACTIVE_FROM"], "DD.MM.YYYY", "MM");
		if ($day!='' && $month!='')
		{
		?>
			<div class="date_news d-flex">
				<div class="align-self-center w100p">
					<div class="date"><?=$day ?></div>
					<div class="month"><?=getMonthRusNameLowerRP($month) ?></div>
				</div>
			</div>
		<?} ?>
		
		<div class="img <?=$GLOBALS["IMG_HOVER_EFFECT"] ?>">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arFileTmp["src"]?>" loading="lazy"/></a>			
		</div>
		<div class="descr">
			<div class="bg"></div>
			<div class="date"><?=$arItem["PROPERTIES"]["DATE"]["VALUE"]?></div>
			<div class="name"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>

	
			<?if ($arItem["DETAIL_TEXT"]!=""){?>
				<div class="text-left"><a class="link" href="<?=$arItem["DETAIL_PAGE_URL"]?>">Подробнее</a></div>
			<?} ?>
		</div>
		
	</div>
<?endforeach;?>
</div>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
<div class="clear"></div>
