<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

$use_css_filter=true;
if ($GLOBALS["OPTION_PAGE_BLOCK_ABOUT_IMG_CSS_FILTER"]=="N") $use_css_filter=false;

$block_name="about";
$page_block=GetMessage("INDEX_PAGE_BLOCK")[$block_name];

$block_header="";
if (isset($GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name])) $block_header=$GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name];
else
$block_header=$page_block["header"]!="" ? $page_block["header"]:$page_block["name"];

?>
<div class="content_container about_block_wrapper">
	<h2 class="page_block_header"><?=$block_header ?></h2>
	<div class="about_block d-flex">
		
		<div class="img_wrapper">
			<div class="img_container" class="d-none d-sm-flex">
				<div class="img <?=$GLOBALS["IMG_HOVER_EFFECT"] ?>">
					<img <?=$use_css_filter ? "class='css_filter'":"" ?> src="<?=SITE_DIR ?>include/images/logo.png">
				</div>
			</div>
		</div>
		<div class="text d-flex">
			<div class="align-self-center">
				<div><?$APPLICATION->IncludeFile(SITE_DIR."include/about.php");?></div>
				<div class="air p10"></div>
				<a class="btn small ripple" href="<?=SITE_DIR ?>about/">Подробнее</a>	
			</div>
		</div>
		
	</div>
</div>