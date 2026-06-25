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

$block_type="1";
if (!empty($GLOBALS["PAGE_BLOCK_ADVANTAGE"]) && $GLOBALS["PAGE_BLOCK_ADVANTAGE"]>0)
{
	$block_type=$GLOBALS["PAGE_BLOCK_ADVANTAGE"];
}

/*Кол-во элементов в строке*/
if (!isset($arParams["COUNT_LINE"]) || !$arParams["COUNT_LINE"]>0)
$arParams["COUNT_LINE"]=4;
$css_width=round((100/(int)$arParams["COUNT_LINE"]),2);


$use_css_filter=true;
if ($GLOBALS["OPTION_PAGE_BLOCK_ADVANTAGE_CSS_FILTER"]=="N") $use_css_filter=false;


$block_name="advantage";
$page_block=GetMessage("INDEX_PAGE_BLOCK")[$block_name];

$block_header="";
if (isset($GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name])) $block_header=$GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name];
else
$block_header=$page_block["header"]!="" ? $page_block["header"]:$page_block["name"];

$advantage_theme="css_light";

?>
<script>
var SLIDER_ON_MOBILE_ADVANTAGE=<?=$arParams["SLIDER_ON_MOBILE"] ? "true":"false" ?>
</script>
<div class="advantage_wrapper <?=$advantage_theme?>" style=" background: url(<?=SITE_DIR?>include/images/bg/advantage.jpg) center bottom no-repeat;">
<div class="content_container">
	<?if ($block_header!=""){ ?><h2 class="page_block_header"><?=$block_header?></h2><?} ?>
	<div class="advantage_container">
	<div class="advantage d-flex flex-wrap justify-content-center justify-content-xl-start type<?=$block_type?> <?=$GLOBALS["OPTION_PAGE_BLOCK_ADVANTAGE_BORDER"]=="Y" ? "with_border":"" ?> <?=$GLOBALS["OPTION_PAGE_BLOCK_ADVANTAGE_BORDER"]=="Y" ? "with_border":"" ?>">
	<?
	$i=0;
	foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$i++;
		?>
		<div class="item_container" style="width: <?=$css_width ?>%">
		<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="item d-flex" >
			<div class="img">
				<img <?=$use_css_filter ? "class='css_filter'":"" ?> src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"/>						
			</div>	
			<div class="text d-flex">
				<div class="align-self-center">
					<div class="name <?=$arItem['PREVIEW_TEXT']!="" ? "bold":"" ?>">
						<?=htmlspecialchars_decode($arItem['NAME']) ?>
					</div>
					<?if ($arItem['PREVIEW_TEXT']!='') {?>
						<div class="descr"><?=$arItem['PREVIEW_TEXT'] ?></div>
					<?} ?>
					
					
				</div>
			</div>
		</div>
		</div>
	<?endforeach;?>
	</div>
	</div>
</div>
</div>
	
