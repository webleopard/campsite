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

$category_field="CATEGORY";

?>
<div class="vacancy">
<?
foreach ($arResult[$category_field] as $cat=>$cat_data)
{
	?>
	<h3 class="left"><?=$cat ?></h3>
	<ul class="list">
	<?
	$i=0;
	foreach($arResult["ITEMS"] as $arItem):
		if ($arItem["PROPERTIES"][$category_field]["VALUE"]==$cat){
		?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			$i++;
			
			$price=$arItem['PROPERTIES']['PRICE']['VALUE'];
			$trans = array("от " => "<small>от</small> ", " руб" => " <small>руб</small>");
			$price=strtr($price, $trans);
			?>
			<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="item active">
					<div class="item_descr expand">
						<div class="d-flex">
							<div class="name flex-grow-1"><a href="javascript:void(0);"><?=$arItem["NAME"]?></a></div>
							<div class="price"><?=$price ?></div>
						</div>
						
						<div class="text">
							<div class="anons"><?=$arItem["PREVIEW_TEXT"] ?></div>
							<table>
								<?if ($arItem['PROPERTIES']['RESPON']['VALUE']['TEXT']!='') {?>
								<tr>
									<td class="label">Обязанности:</td>
									<td><?=htmlspecialchars_decode($arItem['PROPERTIES']['RESPON']['VALUE']['TEXT'])?></td>
								</tr>
								<?} ?>
								
								<?if ($arItem['PROPERTIES']['REQUIRE']['VALUE']['TEXT']!='') {?>
								<tr>
									<td class="label">Требования:</td>
									<td><?=htmlspecialchars_decode($arItem['PROPERTIES']['REQUIRE']['VALUE']['TEXT'])?></td>
								</tr>
								<?} ?>
								
								<?if ($arItem['PROPERTIES']['TERMS']['VALUE']['TEXT']!='') {
									?>
								<tr>
									<td class="label">Условия:</td>
									<td><?=htmlspecialchars_decode($arItem['PROPERTIES']['TERMS']['VALUE']['TEXT'])?></td>
								</tr>
								<?} ?>
								<?if ($price!='') {
									?>
								<tr>
									<td class="label">Оплата:</td>
									<td class="price_tab"><?=$price?></td>
								</tr>
								<?} ?>
							</table>
						</div>
						
					</div>
					<div class="clear"></div>
			</li>
		<?} ?>
	<?endforeach;?>
	</ul>
<?
}
?>
</div>
<div class="clear"></div>
