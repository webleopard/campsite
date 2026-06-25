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

$block_name="price";
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
	
	<div class="price">
	<div class="air p10"></div>
	<div class="slider_price d-flex <?=$arParams['USE_SLIDER']=='Y' ? 'owl-carousel owl-theme small-controls':'flex-wrap'?> news-list ">
		<?
		
		$i=0;
		foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$i++;
		
		$price=$arItem['PROPERTIES']['PRICE']['VALUE'];
		$trans = array("от " => "<small>от</small> ", " руб" => " <small>руб</small>");
		$price=strtr($price, $trans);
		
		if ($arItem["PREVIEW_PICTURE"]>0)
		$arFileTmp = CFile::ResizeImageGet(
				$arItem["PREVIEW_PICTURE"],
				array('width' => 280, 'height' => 200),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				true
		);
		?>
		<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="item">
			<?if ($arItem["PREVIEW_PICTURE"]>0) {?>
			<div class="img <?=$GLOBALS["IMG_HOVER_EFFECT"] ?>">
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arFileTmp["src"]?>" loading="lazy"/></a>			
			</div>
			<?} ?>
			
			<div class="name"><?=htmlspecialchars_decode($arItem['NAME']) ?></div>
			
			<?if ($price!="") {?>
				<div class="price"><?=$price?></div>
			<?} ?>
			
			<?if ($arItem['PROPERTIES']['HIDE_ORDER_BTN']['VALUE_XML_ID']!="Y"){?>
			<div class="text-center">
				<a class="btn small ripple fancybox" data-header="<?=GetMessage("PRICE_POPUP_HEADER_NAME") ?>: <?=htmlspecialchars($arItem['NAME']) ?>" data-comment="<?=htmlspecialchars($arItem['NAME']) ?>" href="#popup_callback">Заказать</a>
			</div>
			<?}?>
		</div>
	<?endforeach;?>
	</div>
	

	</div>
	<?if ($arParams["SHOW_ADDIT_BUTTON"]=="Y"){
		$url=str_replace("/s6/", SITE_DIR, $arResult["LIST_PAGE_URL"]);
		?>
		<div class="text-center"><a class="btn ripple" href="<?=$url ?>"><?=$arParams["ADDIT_BUTTON_TEXT"]?></a></div>
		<div class="air p20"></div>
	<?} ?>
</div>

