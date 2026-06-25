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


$block_name="feedback";
$page_block=GetMessage("INDEX_PAGE_BLOCK")[$block_name];

$block_header="";
if (isset($GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name])) $block_header=$GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name];
else
$block_header=$page_block["header"]!="" ? $page_block["header"]:$page_block["name"];


if (!function_exists("printRating"))
{
	function printRating($score=0, $title='', $vote_count=0, $max=5)
	{
		$path=SITE_TEMPLATE_PATH.'/js/raty/images/';
		$on_stars=floor(floatval($score)/1);
	
		for ($i=1; $i<=$max; $i++)
		{
			$img='star-off.png';
			if ($i<=$on_stars) $img='star-on.png';
	
			if ($i==$on_stars+1)
			{
				$ostatok=$score-$on_stars;
				if ($ostatok>0)
				{
					$img='star-off.png'; /* <=0.25 */
					if ($ostatok>=0.26 || $ostatok<=0.75) $img='star-half.png';
					if ($ostatok>=0.76) $img='star-on.png';
				}
			}
	
			?><img alt="<?=$i ?>" src="<?=$path ?><?=$img ?>" title="<?=$title!='' ? $title:$score ?>"><?
		}
		if ($vote_count>0) print '<span class="vote_count">('.$vote_count.' '.pluralForm($vote_count, 'отзыв', 'отзыва', 'отзывов').')</span>';
	}
	
}

?>
<div class="content_container">
<?if ($block_header!=""){ ?><h2 class="page_block_header"><?=$block_header?></h2><?} ?>
<div class="feedback slider_feedback owl-carousel owl-theme small-controls">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="item_content">
			<?
			$letter=mb_strtoupper(mb_substr($arItem["NAME"], 0, 1, 'UTF-8'));
			?>
			<div class="date_star d-flex">
			
				
				<div class="name d-flex flex-grow-1">
					<div class="letter"><?=$letter ?></div>
					<div class="d-flex align-self-center name"><div><?echo $arItem["NAME"]?></div></div>
				</div>
				<div class="star d-flex align-self-center"><?=printRating($arItem["PROPERTIES"]["RATING"]["VALUE"], '') ?></div>		
				<div class="date d-flex align-self-center"><?=$arItem["PROPERTIES"]["DATE"]["VALUE"] ?></div>	
			</div>
			
			<div class="air p10"></div>
			<div class="d-flex">
				<div class="img">
					<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"] ?>">
				</div>
				<div class="descr_container flex-grow-1">
					
					<div class="text"><?=$arItem["PREVIEW_TEXT"] ?></div>
			
					
					<div class="source">Отзыв взят с сайта: <?=$arItem["PROPERTIES"]["SOURCE"]["VALUE"] ?></div>
				</div>
			</div>
			
		</div>
	</div>
<?endforeach;?>
</div>
</div>
