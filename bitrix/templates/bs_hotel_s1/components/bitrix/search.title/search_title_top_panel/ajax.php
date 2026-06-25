<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (empty($arResult["CATEGORIES"]) || !$arResult['CATEGORIES_ITEMS_EXISTS'])
	return;
?>
<div class="bx_searche search_top_content">
<?

foreach($arResult["CATEGORIES"] as $category_id => $arCategory){?>
<?
foreach ($arCategory["ITEMS"] as $i => $arItem)
{
	
	$arElement=$arResult["ELEMENTS"][$arItem['ITEM_ID']];
	if ($arItem["NAME"]!='остальные') 
	{
		
		$old_price='';
		if ($arElement['IBLOCK_ID']==9)
		{
			$res = CIBlockElement::GetProperty($arElement['IBLOCK_ID'], $arElement['ID'], "sort", "asc", array("CODE" => "OLD_PRICE"));
			while ($ob = $res->GetNext())
			{
				if ($ob['VALUE']>0) $old_price=$ob['VALUE'];
			}	
			
		}
		
		
	?>
		<div class="bx_item_block d-flex">
				<?if (is_array($arElement["PICTURE"])):?>
				<div class="bx_img_element align-self-center">
					<div class="bx_image" style="background-image: url('<?echo $arElement["PICTURE"]["src"]?>')"></div>
				</div>
				<?endif;?>
				<div class="bx_item_element flex-grow-1">
					<a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a>
					<?
					foreach($arElement["PRICES"] as $code=>$arPrice)
					{
						if ($arPrice["MIN_PRICE"] != "Y")
							continue;

						if($arPrice["CAN_ACCESS"])
						{
							if($old_price>0):?>
								<div class="bx_price">
									<?=$arPrice["PRINT_VALUE"]?>
									<span class="old_price"><?=$old_price?> ₽</span>
								</div>
							<?else:?>
								<div class="bx_price"><?=$arPrice["PRINT_VALUE"]?></div>
							<?endif;
						}
						if ($arPrice["MIN_PRICE"] == "Y")
							break;
					}
					?>
				</div>
			</div>
	<?
	}
}
}
?>
</div>