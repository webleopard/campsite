<?
/*Опции - кнопки*/
$CODE=$filter_prop["CODE"];

$arr_values=$value_arr[$CODE];

if ($filter_prop["LINK_IBLOCK_ID"]>0)
if (!empty($arr_values) && is_array($arr_values) && count($arr_values)>1)
{
	/*Список всех значений Тип*/
	$link_items_array=array();
	$res_link_items = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>$filter_prop["LINK_IBLOCK_ID"]), false, false);
	while($ob_link_item = $res_link_items->GetNextElement())
	{
		$arFields_link_item = $ob_link_item->GetFields();
		$arProps_link_item = $ob_link_item->GetProperties();
		$link_items_array[$arFields_link_item["ID"]]=array_merge($arFields_link_item, $arProps_link_item);
	
	}
	
	?>
	<div class="block option_button_container">
		<div class="option_button d-flex flex-wrap">
			<?
			/*Сортируем значение если число*/
			$nubmer_values=true;
			foreach ($arr_values as $k=>$arr_value)
			{
				if (!floatval($arr_value)>0)	
				$nubmer_values=false;
			}
			
			if ($nubmer_values) sort($arr_values); 
			
			foreach ($arr_values as $arr_value)
			{
				$arr_item=$link_items_array[$arr_value];
				?>
				<div class="item d-flex">
					<input name="<?=$CODE ?>[]" type="checkbox" value="<?=$arr_item["ID"] ?>">
					<div class="name"><?=$arr_item["NAME"] ?></div>
					<?
					if ($arr_item["SVG_ICON"]["VALUE"]>0){ 
						$img=CFile::GetPath($arr_item["SVG_ICON"]["VALUE"]);
					?>
					<div class="img d-flex align-self-center <?=$arr_item["SVG_ICON_CLASS"]["VALUE"] ?>">
						<?=file_get_contents($_SERVER["DOCUMENT_ROOT"].$img) ?>
					</div>
					<?} ?>
				</div>
				<?	
			}
			?>
		</div>
	</div>
	<?
}
?>