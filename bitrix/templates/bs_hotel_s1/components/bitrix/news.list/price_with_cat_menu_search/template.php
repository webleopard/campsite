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
<div class="price_block d-flex">
	<?if (!empty($arResult["section_arr"]) && count($arResult["section_arr"])>1 && $arParams["SHOW_LEFT_MENU"]=="Y") {?>
	<div class="left_col">
		<div><a class="show_filter btn small ripple" href="javascript:void(0);" style="display: none;"><?=GetMessage("BTN_FILTER_LABEL") ?></a></div>
		<div class="cat_menu">
			<?foreach ($arResult["section_arr"] as $key => $section){?>
				<a href="javascript:void(0);" data-id="<?=$key ?>">
					
					<?=$section["DEPTH_LEVEL"]> 2 ? str_repeat("<span class='menu_pad'></span>", ($section["DEPTH_LEVEL"]-1)) : ""?>
					<?=($section["DEPTH_LEVEL"]>1) ? "-":""?>
					<?=$section['NAME'];?>
				</a>
			<?} ?>
		
			<div class="show_all_container">
				<a class="show_all btn small ripple" style="display: none;" href="javascript:void(0);"><?=GetMessage("BTN_CLEAR_FILTER_LABEL") ?></a>
			</div>
		</div>
	</div>
	<?} ?>
	
	<div class="right_col flex-grow-1">
		<div class="price_cat">
		
		<? 
		if ($arResult["element_count"]>1 && $arParams["SHOW_SEARCH"]=="Y"){
		?>
		<div class="search">
			<input placeholder="<?=GetMessage("SEARCH_FILED_LABEL") ?>" type="text" name="query" value="" autocomplete="off">
			<a class="clear_search d-none"><span class="icon-xmark"></span></a>
		</div>
		<?} ?>
		
		<?
		$i=0;
		foreach ($arResult["section_arr"] as $sec)
		{
			if ($sec["ID"]=="") $sec["DEPTH_LEVEL"]=1;
			
			if ($previousLevel && $previousLevel==$sec["DEPTH_LEVEL"])
			{
				print "</div>";
			}
			
			if ($previousLevel>$sec["DEPTH_LEVEL"])
			{
				print str_repeat("</div>", ($previousLevel - $sec["DEPTH_LEVEL"] + 1));
			}	
			
			if ($sec["DEPTH_LEVEL"]==1 && $i>0) print "<div class='air p10'></div>";
				
			?>
			<div class="section_block" data-id="<?=$sec["ID"] ?>"><?
		
			if ($sec["NAME"]!="")
			print "<h".($sec["DEPTH_LEVEL"]+2).">".$sec["NAME"]."</h".($sec["DEPTH_LEVEL"]+2).">";
		
			foreach($sec["ITEMS"] as $arItem)
			{
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				$i++;
				
				?>
				<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="item">
					<div class="d-flex flex-wrap">
						<div class="name align-self-center flex-grow-1"><?=$arItem['NAME'] ?></div>
						
						
						<?if ($arParams["SHOW_ORDER_BTN"]=="Y" || $arItem['PROPERTIES']['PRICE']['VALUE']>0){ 
						?>
							<div class="price_info d-flex  justify-content-end">
								<?if ($arItem['PROPERTIES']["PRICE"]['VALUE']>0) {?>
									<div class="price_val align-self-center"><?=$arItem['PROPERTIES']['PRICE']['VALUE'] ?></div>
								<?} ?>
								
								<?if ($arParams["SHOW_ORDER_BTN"]=="Y"){ ?>
									<div class="price_btn_form_container">
										<a class="btn small price_btn_form" href="#popup_callback" data-header="<?=GetMessage("BTN_PRICE_TEXT") ?>" data-comment="<?=$arItem['NAME'] ?>"><?=GetMessage("BTN_PRICE_TEXT") ?></a>
									</div>
								<?} ?>
							</div>
						<?} ?>
					</div>
				</div>
				
				<?
				
				
			}?>
		
			<?
			$i++;
			$previousLevel=$sec["DEPTH_LEVEL"];
		}
		if ($i>0)
		{
			print str_repeat("</div>", ($previousLevel - $sec["DEPTH_LEVEL"] + 1));
		}
		
		if (empty($arResult["section_arr"])) print "</div>";
		?>
	</div>
	</div>
</div>
