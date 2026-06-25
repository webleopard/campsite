<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

<div class="mobile_submenu_content_overlay" style="display: none;"></div>
<div class="mobile_submenu_container" style="display: none;">

<div class="mobile_submenu_content">
	<div class="text-right">
		<a class="close-x">
			<svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
			<circle cx="20" cy="20" r="19.5" stroke="#E1E2E3"/>
			<path d="M23 17L17 23M23 23L17 17" stroke="#4E4F54" stroke-width="1.2" stroke-linecap="round"/>
			</svg>
		</a>
	</div>
		<div class="logo"><?=$logo_href[0]?><?$APPLICATION->IncludeFile(SITE_DIR."include/logo.php");?><?=$logo_href[1]?></div>
		<div class="menu">
		<ul>
			<?
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
						<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a>
							<ul class="sub">
					<?else:?>
						<li<?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><a href="<?=$arItem["LINK"]?>" class="parent"><?=$arItem["TEXT"]?></a>
							<ul class="sub">
					<?endif?>
			
				<?else:?>
			
					<?if ($arItem["PERMISSION"] > "D"):?>
			
						<?if ($arItem["DEPTH_LEVEL"] == 1):?>
							<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a></li>
						<?else:?>
							<li<?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
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
		</ul>
		</div>
	</div>
</div>

<div class="main_menu_container d-flex flex-grow-1 h100p ">
<div class="content_container align-self-center">
<div class="main_menu">
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
			<li class="has-child">
				<a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>">
					<?=$arItem["TEXT"]?>
					<svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.66675 1.66666L5.00062 4.71999L8.33341 1.66666" stroke="#333333" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</a>
			
		<ul>
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


	<?
	if($arParams['SHOW_SEARCH_MENU']=='Y'){
	$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "file",
			"AREA_FILE_SUFFIX" => "inc",
			"EDIT_TEMPLATE" => "",
			"PATH" => SITE_TEMPLATE_PATH."/include/header/menu_search.php"
		)
	);}
	?>

</ul>
</div>

</div>
</div>
<div class="menu-clear-left"></div>
<?endif?>