<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="content_container">
	<div class="show_left_menu iconfont_a_container" style="display: none;">
		<a href="javascript:void(0);">Меню</a>
	</div>
</div>	
	
<div class="left_menu_container">
	<div class="content_container">
	<div class="left_menu">
	<ul>
	
	<?
	$previousLevel = 0;
	foreach($arResult as $arItem):?>
		<?
		if (stripos($arItem["LINK"], '#')!==false && $APPLICATION->getCurPage(false) != SITE_DIR)
		{
			$arItem["LINK"]='/'.$arItem["LINK"];
		}
		?>
	
		<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
			<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
		<?endif?>
	
		<?if ($arItem["IS_PARENT"]):?>
	
			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li class="has-child"><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a>
					<i class="fa fa-angle-down"></i><ul>
			<?else:?>
				<li <?=$arItem["SELECTED"] ? 'class="item-selected active"' :''?>><a href="<?=$arItem["LINK"]?>" class="parent"><?=$arItem["TEXT"]?></a>
					<ul>
			<?endif?>
	
		<?else:?>
	
			<?if ($arItem["PERMISSION"] > "D"):?>
	
				<?if ($arItem["DEPTH_LEVEL"] == 1):?>
					<li <?=$arItem["SELECTED"] ? 'class="item-selected active"' :''?>><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a></li>
				<?else:?>
					<li <?=$arItem["SELECTED"] ? 'class="item-selected active"' :''?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
				<?endif?>
	
			<?else:?>
	
				<?if ($arItem["DEPTH_LEVEL"] == 1):?>
					<li><a href="" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
				<?else:?>
					<li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
				<?endif?>
	
			<?endif?>
	
		<?endif?>
	
		<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
	
	<?endforeach?>
	
	<?if ($previousLevel > 1)://close last item tags?>
		<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
	<?endif?>
	
	
	
	</ul>
	</div>
	</div>
</div>


<?endif?>