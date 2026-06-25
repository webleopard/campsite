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


$block_name="uslugi";
$page_block=GetMessage("INDEX_PAGE_BLOCK")[$block_name];

$block_header="";
if (isset($GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name])) $block_header=$GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name];
else
$block_header=$page_block["header"]!="" ? $page_block["header"]:$page_block["name"];

$header_tag="h1";
if ($arParams["HEADER_H2"]=="Y") $header_tag="h2";
?>
<script>
var SLIDER_ON_MOBILE_USLUGI=<?=$arParams["SLIDER_ON_MOBILE"] ? "true":"false" ?>
</script>
<div class="content_container">
	<<?=$header_tag ?> class="page_block_header"><?=$block_header ?></<?=$header_tag ?>>
	<div class="uslugi_container">
	<div class="uslugi d-flex flex-wrap justify-content-center justify-content-xl-between type<?=$block_type?> count_line<?=$arParams["COUNT_LINE"] ?>">
	<?
	$i=0;
	foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$i++;
		
		?>
		<div class="item_container" style="width: <?=$css_width ?>%">
			
			
			<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="item d-flex <?=$arItem["PROPERTIES"]["TEXT_COLOR"]["VALUE_XML_ID"] ?> <?=$arItem["PROPERTIES"]["SHADOW_COLOR"]["VALUE_XML_ID"] ?>">
				
				<?if ($arItem["PROPERTIES"]["HREF_DISABLE"]["VALUE_XML_ID"]!="Y") {?>
				<a class="href" href="<?=$arItem["DETAIL_PAGE_URL"]?>"></a>
				<?} ?>
				
				<?if ($arItem["PROPERTIES"]["SHOW_SHADOW"]["VALUE_XML_ID"]=="Y") {?>
					<div class="shadow <?=$arItem["PROPERTIES"]["SHADOW_TYPE"]["VALUE_XML_ID"] ?>"></div>
				<?}?>
				
				<div class="img" style="background-image: url(<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>)"></div>
				<div class="text d-flex">
					<div class="align-self-center">
						<div class="name bold">
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
	
