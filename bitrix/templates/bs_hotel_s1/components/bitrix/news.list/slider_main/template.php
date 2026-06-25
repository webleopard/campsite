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

$slider_type="3";
if (!empty($GLOBALS["PAGE_BLOCK_SLIDER"]) && $GLOBALS["PAGE_BLOCK_SLIDER"]>0)
{
	$slider_type=$GLOBALS["PAGE_BLOCK_SLIDER"];
}

/*Если нет активных доп. баннеров*/
if ($slider_type==3 && (!is_array($arResult["arResult_by_type"]["top_additional"]) || count($arResult["arResult_by_type"]["top_additional"])==0))
$slider_type=1;	
else $with_right=true;

if ($slider_type==4 && (!is_array($arResult["arResult_by_type"]["top_additional"]) || count($arResult["arResult_by_type"]["top_additional"])<2))
$slider_type=1;
else $with_left_right=true;

if(!function_exists('draw_small_banner'))
{
	function draw_small_banner($arItem)
	{

		/*Цвет шрифта*/
		$text_color="css_text_light";
		if ($arItem["PROPERTIES"]["TEXT_COLOR"]["VALUE_XML_ID"]!='')
		$text_color=$arItem["PROPERTIES"]["TEXT_COLOR"]["VALUE_XML_ID"];
		?>		
		<div class="item <?=$text_color ?>" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"] ?>');">
			<?if ($arItem["PROPERTIES"]["SHOW_SHADOW"]["VALUE_XML_ID"]!="") {?>
				<div class="slider_shadow <?=$arItem["PROPERTIES"]["SHOW_SHADOW"]["VALUE_XML_ID"] ?> <?=$arItem["PROPERTIES"]["SHADOW_TYPE"]["VALUE_XML_ID"] ?>"></div>
			<?}?> 
			
			<div class="item_content d-flex align-items-end">
			<div>					
				<?=$arItem["PREVIEW_TEXT"] ?>
				
				<div class="btn_container d-flex text-left">
					<?if ($arItem["PROPERTIES"]["BTN1_TEXT"]["VALUE"]!="") {
						 $arItem["PROPERTIES"]["BTN1_TYPE"]["VALUE_XML_ID"].=" ripple";
						?>
						<div><a class="btn small <?=$arItem["PROPERTIES"]["BTN1_TYPE"]["VALUE_XML_ID"] ?>" href="<?=$arItem["PROPERTIES"]["BTN1_HREF"]["VALUE"] ?>"><?=$arItem["PROPERTIES"]["BTN1_TEXT"]["VALUE"] ?></a></div>
					<?} ?>
					<?if ($arItem["PROPERTIES"]["BTN2_TEXT"]["VALUE"]!="") {
						$arItem["PROPERTIES"]["BTN2_TYPE"]["VALUE_XML_ID"].=" ripple";
						?>
						<div><a class="btn small <?=$arItem["PROPERTIES"]["BTN2_TYPE"]["VALUE_XML_ID"] ?>" href="<?=$arItem["PROPERTIES"]["BTN2_HREF"]["VALUE"] ?>"><?=$arItem["PROPERTIES"]["BTN2_TEXT"]["VALUE"] ?></a></div>
					<?} ?>
				</div>
			</div>
			</div>
		</div>
		<?
	}
}
?>
<script>
	var SLIDER_AUTO_PLAY=<?=$arParams["SLIDER_AUTO_PLAY"]=="Y" ? "true":"false" ?>;
</script>

<div class="slider_block_container type<?=$slider_type?> <?=$with_left_right ? "with_left_right":""?> <?=$with_right ? "with_right":""?>">



<div class="slider d-flex header_type_<?=$GLOBALS["OPTION_HEADER_TYPE"]?>">

<div class="main_slide main_slider_container flex-grow-1">
	<?=$slider_type==2 ? "<div class='content_container'>":"" ?>
	<div class="slider owl-carousel owl-theme" style="width: 100%;">
			<?foreach($arResult["arResult_by_type"]["top_main"] as $arItem):?>
					<?
					
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					
					$href="";
					if ($arItem['PROPERTIES']['HREF']['VALUE']!='')
					$href=$arItem['PROPERTIES']['HREF']['VALUE'];
					elseif ($arItem["DETAIL_TEXT"]!='')
					$href="/slider/".$arItem['ID']."/";
					
					$path_info = pathinfo($arItem["PREVIEW_PICTURE"]["SRC"]);
					
					/*Картинка справа*/
					$right_img="";
					if ($arItem["PROPERTIES"]["RIGHT_IMAGE"]["VALUE"]>0)
					$right_img=CFile::GetPath($arItem["PROPERTIES"]["RIGHT_IMAGE"]["VALUE"]);
					
					
					/*Цвет шрифта*/
					$text_color="css_text_light";
					if ($arItem["PROPERTIES"]["TEXT_COLOR"]["VALUE_XML_ID"]!='')
					$text_color=$arItem["PROPERTIES"]["TEXT_COLOR"]["VALUE_XML_ID"];
					
					
					
					?>	
					<div style="background: url(<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>); " class="item <?=$text_color ?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">	
							<?
							if ($arItem["PROPERTIES"]["VIDEO"]["VALUE"]>0)
							{
								$video = CFile::GetPath($arItem["PROPERTIES"]["VIDEO"]["VALUE"]);
								?>
								<div class="video-container">
									<video autoplay="" loop="" muted="" id="background" poster="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>">
									   <source src="<?=$video ?>" type="video/mp4">
									</video>
							    </div>
				    			<?
							}
							
							if ($href!=''){
							?>
								<a class="slider_href" href="<?=$href?>"></a>
							<?} ?>
							
							<?if ($arItem["PROPERTIES"]["SHOW_SHADOW"]["VALUE_XML_ID"]!="") {?>
								<div class="slider_shadow <?=$arItem["PROPERTIES"]["SHOW_SHADOW"]["VALUE_XML_ID"] ?> <?=$arItem["PROPERTIES"]["SHADOW_TYPE"]["VALUE_XML_ID"] ?>"></div>
							<?}?>
							
							
							<div class="content_container h100p">
								<div class="slider_content_container h100p">
								
									<div class="d-flex h100p slider_content">
										<div class="align-self-center text w100p flex-grow-1">
											<?$arItem["PREVIEW_TEXT"]=str_replace('/s6/', SITE_DIR, $arItem["PREVIEW_TEXT"]);?>
											<?=$arItem["PREVIEW_TEXT"] ?>
											
											<div class="btn_container">
												<?if ($arItem["PROPERTIES"]["BTN1_TEXT"]["VALUE"]!="") {
													 $arItem["PROPERTIES"]["BTN1_TYPE"]["VALUE_XML_ID"].=" ripple";
													?>
													<div><a class="btn <?=$arItem["PROPERTIES"]["BTN1_TYPE"]["VALUE_XML_ID"] ?>" href="<?=$arItem["PROPERTIES"]["BTN1_HREF"]["VALUE"] ?>"><?=$arItem["PROPERTIES"]["BTN1_TEXT"]["VALUE"] ?></a></div>
												<?} ?>
												<?if ($arItem["PROPERTIES"]["BTN2_TEXT"]["VALUE"]!="") {
													$arItem["PROPERTIES"]["BTN2_TYPE"]["VALUE_XML_ID"].=" ripple";
													?>
													<div><a class="btn <?=$arItem["PROPERTIES"]["BTN2_TYPE"]["VALUE_XML_ID"] ?>" href="<?=$arItem["PROPERTIES"]["BTN2_HREF"]["VALUE"] ?>"><?=$arItem["PROPERTIES"]["BTN2_TEXT"]["VALUE"] ?></a></div>
												<?} ?>
											</div>
										</div>
													
									</div>
								</div>
									
								<?if ($right_img!="") {?>
								<div class="right_img d-none d-lg-flex h100p justify-content-end">
									<div class="align-self-center">
										<div><img src="<?=$right_img?>" alt=""></div>
									</div>							
								</div>
								<?} ?>
							</div>
					</div>
			<?endforeach;?>
	 				
	</div>
	<?=$slider_type==2 ? "</div>":"" ?>
</div>







<?
/*Баннер слева*/
if ($slider_type==4 && is_array($arResult["arResult_by_type"]["top_additional"]) && count($arResult["arResult_by_type"]["top_additional"])>0)
{
	$arItem=$arResult["arResult_by_type"]["top_additional"][0];
	?>
	<div class="small_banner small_left">
		<?draw_small_banner($arItem); ?>
	</div>
<?} ?>
<?
/*Баннер справа*/
if (
		($slider_type==3 && is_array($arResult["arResult_by_type"]["top_additional"]) && count($arResult["arResult_by_type"]["top_additional"])>0) ||
		($slider_type==4 && is_array($arResult["arResult_by_type"]["top_additional"]) && count($arResult["arResult_by_type"]["top_additional"])>1)
		
)
{
	$arItem=$arResult["arResult_by_type"]["top_additional"][0];
?>

	<div class="small_banner small_right">
		<?draw_small_banner($arItem); ?>
	</div>
<?} ?>

</div>

<?
$i=0;
$limit=4;
if ($slider_type==5 && is_array($arResult["arResult_by_type"]["top_additional"]) && count($arResult["arResult_by_type"]["top_additional"])>0)
{
	?><div class="banners_bottom d-flex"><?
	foreach ($arResult["arResult_by_type"]["top_additional"] as $arItem)
	if ($i<$limit)
	{
		?>
		<div class="small_banner flex-grow-1">
			<div class="item" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"] ?>');">
				<?if ($arItem["PROPERTIES"]["SHOW_SHADOW"]["VALUE_XML_ID"]!="") {?>
					<div class="slider_shadow <?=$arItem["PROPERTIES"]["SHOW_SHADOW"]["VALUE_XML_ID"] ?>"></div>
				<?}?>
			</div>
		</div>
		<?	
		$i++;
	}
	?></div><?
}
?>

</div>

