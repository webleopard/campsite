<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="prop_list d-flex flex-wrap">
<?foreach($arResult["ITEMS"] as $arItem) {?>
	<div class="prop_item"><div class="name"><?=$arItem["NAME"]?></div></div>
<?}?>
</div>