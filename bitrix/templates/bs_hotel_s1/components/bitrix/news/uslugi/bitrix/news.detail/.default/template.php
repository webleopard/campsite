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

?>
<div class="uslugi_detail item">
		<h1><?=$arResult["NAME"]?></h1>
		<?=$arResult["DETAIL_TEXT"] ?>
		
		<?
		if (!empty($arResult["PROPERTIES"]["GALLERY"]["VALUE"])) {
		?>
			<div class="air p30"></div>
			<div class="detail_slider owl-carousel owl-theme small-controls d-flex flex-wrap">
			<?
			foreach ($arResult["PROPERTIES"]["GALLERY"]["VALUE"] as $img)
			{
				$img_path = CFile::GetPath($img);
				
				?>
				<div class="item">
					<a href="<?=$img_path ?>" data-fancybox="gallery_detail"><img src="<?=$img_path ?>"></a>
				</div>
				<?
			}
			?>
			</div>
			<div class="air p30"></div>
		<?} ?>
		
		<div class="d-flex flex-wrap flex-sm-nowrap bordered rounded grey-bg order_block">
			<div class="flex-grow-1 d-flex align-self-center">
				<div><b><?=GetMessage("T_IBLOCK_USLUGI_ORDER_COMMENT") ?></b></div>
			</div>
			<div><a data-header="<?=$arResult["NAME"]?>" data-comment="<?=$arResult["NAME"]?>" class="btn ripple fancybox nobr" href="#popup_callback">Заказать услугу</a></div>
		</div>
	
</div>