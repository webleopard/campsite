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
<script>
$(function() {
	
	var mouseDragEnabled = true;
	if ($(window).width()<1200) mouseDragEnabled = false;

	$(".slider_photo<?=$arParams["IBLOCK_SECTION_ID"]?>").owlCarousel({
		pagination: true,
		//autoplay: true,
		nav: true,
		loop: false,
		items: 1,
		dots: true,
		autoWidth:true,
	    mouseDrag: mouseDragEnabled,
		navText : ['<svg width="24" height="24" viewBox="0 0 595.279 841.89" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"><path fill="#FFF" d="M326.391,209.918L130.01,388.8h429.494c16.132,0,29.823,16.489,29.823,32.622c0,16.133-14.882,37.74-31.015,37.74H129.95L308.712,628.58c11.489,11.428,10.239,37.979-4.286,50.658c-12.263,10.654-30.121,11.428-41.609,0L14.346,447.435c-6.132-6.131-8.751-14.227-8.334-22.264c-0.417-7.977,2.202-18.751,8.334-24.882l266.745-238.588c11.488-11.429,32.323-8.75,44.05,2.441C337.881,176.226,337.881,198.43,326.391,209.918z"/></svg>',
		           '<svg width="24" height="24" viewBox="0 0 595.279 841.89" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"><path fill="#FFF" d="M270.155,164.142c11.727-11.191,32.562-13.87,44.05-2.441L580.95,400.289c6.132,6.131,8.751,16.906,8.334,24.882c0.417,8.037-2.202,16.133-8.334,22.264L332.48,679.238c-11.488,11.428-29.347,10.654-41.609,0c-14.525-12.68-15.775-39.23-4.286-50.658l178.762-169.418H36.984c-16.133,0-31.015-21.607-31.015-37.74c0-16.132,13.691-32.622,29.823-32.622h429.494L268.905,209.918C257.416,198.43,257.416,176.226,270.155,164.142z"/></svg>'],
		//autoWidth:true,
		//lazyLoad: true //<img class="owl-lazy" data-src="SRC" alt="">
		//stagePadding:0
		//dotsEach: 3 
	});
	
});
</script>

<div class="content_container">
<div class="slider_photo slider_photo<?=$arParams["IBLOCK_SECTION_ID"]?> small-controls
owl-carousel owl-theme
d-flex flex-wrap justify-content-center justify-content-xl-between">
	<?
	foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$i++;
		
		$images=array();
		if ($arItem["PREVIEW_PICTURE"]["ID"]>0)
		$images[]=array("ID"=>$arItem["PREVIEW_PICTURE"]["ID"], "SRC"=>$arItem["PREVIEW_PICTURE"]["SRC"]);
		

		foreach ($arItem["PROPERTIES"]["GALLERY"]["VALUE"] as $k=>$img_id)
		{
			$tmp_img=array();
			$tmp_img["ID"]=$img_id;
			$tmp_img["SRC"]=CFile::GetPath($img_id);
			$images[]=$tmp_img;
				
		}
		
		foreach ($images as $img)
		{
		?>
		<div class="item_container">	
			<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="item d-flex justify-content-center">
				<?
				$arFileTmp = CFile::ResizeImageGet($img["ID"], array('width'=>300, 'height'=>200), BX_RESIZE_IMAGE_EXACT);
				?>
				<a data-fancybox="gallery<?=$arParams["IBLOCK_SECTION_ID"]?>" href="<?=$img["SRC"]?>">
					<img data-ext="<?=$path_info['extension'] ?>" src="<?=$arFileTmp["src"]?>"/>
				</a>
		
			</div>
		</div>
		<?}?>
	<?endforeach;?>
</div>
</div>
	
