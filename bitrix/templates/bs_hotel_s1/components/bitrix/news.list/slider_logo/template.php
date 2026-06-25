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


$block_name="logos";
$page_block=GetMessage("INDEX_PAGE_BLOCK")[$block_name];

$block_header="";
if (isset($GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name])) $block_header=$GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name];
else
$block_header=$page_block["header"]!="" ? $page_block["header"]:$page_block["name"];
 

?>
<div class="content_container">
	<?if ($block_header!=""){ ?><h2 class="page_block_header"><?=$block_header?></h2><?} ?>
	
	<div class="slider_logos small-controls
	owl-carousel owl-theme
	d-flex flex-wrap justify-content-center justify-content-xl-between">
	<?
	$i=0;
	foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$i++;
		?>
		<div class="item_container">	
			<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="item d-flex justify-content-center">
				<div class="img align-self-center ">
					<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"/>
				</div>
			</div>
		</div>
	<?endforeach;?>
	</div>
	
</div>
