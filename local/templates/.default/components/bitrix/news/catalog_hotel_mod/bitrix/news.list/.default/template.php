<?
/*Параметры передаваемые в ajax запросах*/
$jsParams=array("IBLOCK_ID", "IBLOCK_RESERV_ID", "IBLOCK_ROOMS_ID", "NEWS_COUNT", "SORT_BY1", "SORT_ORDER1", "SEF_FOLDER");

if ($_REQUEST["ajax_mode"]=="y")
{
	require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule('iblock');
	
	foreach ($_REQUEST as $k=>$v)
	{
		if (!empty($v) && in_array($k, $jsParams))
		{
			$arParams[$k]=$v;
		}
	}
}
else 
{
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	$this->setFrameMode(true);
}


/*Сортировка*/
$sort_array=array(
		"PROPERTY_PRICE ASC"=>"Стоимость (возрастание)",
		"PROPERTY_PRICE DESC"=>"Стоимость (убывание)",
		"PROPERTY_AREA ASC"=>"Площадь (возрастание)",
		"PROPERTY_AREA DESC"=>"Площадь (убывание)",
);
if ($arParams["SORT_BY1"]!="" && $arParams["SORT_ORDER1"]!="" && array_key_exists($arParams["SORT_BY1"]." ".$arParams["SORT_ORDER1"], $sort_array))
$sort_active=$arParams["SORT_BY1"]." ".$arParams["SORT_ORDER1"];
else
{
	$sort_active=array_key_first($sort_array);
	$sort_active_arr=explode(" ", $sort_active);
	$arParams["SORT_BY1"]=$sort_active_arr[0];
	$arParams["SORT_ORDER1"]=$sort_active_arr[1];
}



use Bitrix\Main\Page\Asset;
Asset::getInstance()->addJs($templateFolder."/search/script.js");
Asset::getInstance()->addCss($templateFolder."/search/style.css");



$block_id="catalog_hotel";



$block_name="catalog";
$page_block=GetMessage("INDEX_PAGE_BLOCK")[$block_name];
$block_header="";
if (isset($GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name])) $block_header=$GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name];
else
$block_header=$page_block["header"]!="" ? $page_block["header"]:$page_block["name"];
$header_tag="h1";
if ($arParams["HEADER_H2"]=="Y") $header_tag="h2";
?>

<script>
var templateCatalogPath = "<?=$templateFolder?>";
var blockCatalogSelector=".<?=$block_id?>_block_selector";
var on_input_change_listener=true;
</script>

<div class="<?=$block_id ?>_block_selector catalog_block_wrapper">
	
	<?include('search/filter_props.php');?>
	<?include('search/search_items.php');?>
	<?include('search/search_panel.php');?>
	
	<?
	if (empty($items)) $items=array();
	
	$on_page=$arParams["NEWS_COUNT"];
	
	$page=$_REQUEST['page'];
	if ($page==0) $page=1;
	$count=count($items);
	
	$pages_count=ceil($count/$on_page);
	if ($page>$pages_count) $page=1;
	
	$i=1;
	$limit_start=($page-1)*$on_page;
	if ($limit_start==0) $limit_start=1;
	$limit_end=$page*$on_page;
	
	
	?>
	<div class="rel">
		<div class="search_loader" style="display: none;"><span class="loader"></span></div>
		<div class="content_container catalog">
			<div class="search_result view_<?=$view_type_active ?> d-flex flex-wrap justify-content-center justify-content-xl-start">
			<?
			foreach($items as $item)
			{
				if (($i>$limit_start || ($i==1 && $page==1)) && $i<=$limit_end)
				{
					
					$item["COUNT_HAVE"]["VALUE"]=0;
					if ($GLOBALS["OPTION_MODUL_USE"]=="Y" && $arParams["IBLOCK_ROOMS_ID"]>0)
					{
						$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ROOMS_ID"], "ACTIVE"=>"Y", "PROPERTY_CATEG_ID"=>$item["ID"]);
						$res_count = CIBlockElement::GetList(Array(), $arFilter, false, false);
						$item["COUNT_HAVE"]["VALUE"]=$res_count->SelectedRowsCount();
					}
					?>
					<div class="item">
					<div class="item_content">
						<div class="descr_container">
							<div class="labels d-flex flex-wrap">
								<?
								if (is_array($item["LABELS"]["VALUE"]))
								foreach ($item["LABELS"]["VALUE"] as $label)
								{
									?><div><?=$label ?></div><?	
								}
								?>	
							</div>
							<div class="name"><a href="<?=$item["DETAIL_PAGE_URL"] ?>"><?=$item["NAME"] ?></a></div>	
							
							<div class="icon_list d-flex flex-wrap">
								<?
								if (is_array($item["OPTION_ID"]["VALUE"]))
								foreach ($item["OPTION_ID"]["VALUE"] as $option_id)
								{
									$arFilter = Array("IBLOCK_ID"=>$arItem["PROPERTIES"]["OPTION_ID"]["LINK_IBLOCK_ID"], "ACTIVE"=>"Y", "ID"=>$option_id);
									$res = CIBlockElement::GetList(Array(), $arFilter, false, false);
									while($ob = $res->GetNextElement())
									{
										$arFields_icon = $ob->GetFields();
										$arProps_icon = $ob->GetProperties();
		
										$icon_file='';
										$icon_file=CFile::GetPath($arProps_icon["SVG_ICON"]["VALUE"]);
										
										$arFields_icon["NAME"]=preg_replace("/\ \((.*)\)$/", "", $arFields_icon["NAME"]);
										
										?><div class="icon_item <?=$arProps_icon["SVG_ICON_CLASS"]["VALUE"] ?>"><?=file_get_contents($_SERVER["DOCUMENT_ROOT"].$icon_file) ?><?=($arFields_icon["NAME"]!='-') ? $arFields_icon["NAME"]:'' ?></div><?
									
									}
								}
									
		
								?>	
							</div>
							
							
							<div class="descr d-flex">
								<div class="flex-grow-1 d-flex align-self-center">
									
									<?
									if (!empty($item["GUESTS"]["VALUE"])) {
									$min_guests=0;
									$max_guests=0;
									
									foreach ($item["GUESTS"]["VALUE"] as $guest_val)
									{
										if ($min_guests==0 || $guest_val<$min_guests) $min_guests=$guest_val;
										
										if ($guest_val>0 || $guest_val>$max_guests) $max_guests=$guest_val;
									}
									?>
									<div class="flex-grow-1 text-left">
										<div class="digit d-flex">
											<div>
												<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M3 18C3 15.3945 4.66081 13.1768 6.98156 12.348C7.61232 12.1227 8.29183 12 9 12C9.70817 12 10.3877 12.1227 11.0184 12.348C11.3611 12.4703 11.6893 12.623 12 12.8027C12.3107 12.623 12.6389 12.4703 12.9816 12.348C13.6123 12.1227 14.2918 12 15 12C15.7082 12 16.3877 12.1227 17.0184 12.348C19.3392 13.1768 21 15.3945 21 18V21H15.75V19.5H19.5V18C19.5 15.5147 17.4853 13.5 15 13.5C14.4029 13.5 13.833 13.6163 13.3116 13.8275C14.3568 14.9073 15 16.3785 15 18V21H3V18ZM9 11.25C8.31104 11.25 7.66548 11.0642 7.11068 10.74C5.9977 10.0896 5.25 8.88211 5.25 7.5C5.25 5.42893 6.92893 3.75 9 3.75C10.2267 3.75 11.3158 4.33901 12 5.24963C12.6842 4.33901 13.7733 3.75 15 3.75C17.0711 3.75 18.75 5.42893 18.75 7.5C18.75 8.88211 18.0023 10.0896 16.8893 10.74C16.3345 11.0642 15.689 11.25 15 11.25C14.311 11.25 13.6655 11.0642 13.1107 10.74C12.6776 10.4869 12.2999 10.1495 12 9.75036C11.7001 10.1496 11.3224 10.4869 10.8893 10.74C10.3345 11.0642 9.68896 11.25 9 11.25ZM13.5 18V19.5H4.5V18C4.5 15.5147 6.51472 13.5 9 13.5C11.4853 13.5 13.5 15.5147 13.5 18ZM11.25 7.5C11.25 8.74264 10.2426 9.75 9 9.75C7.75736 9.75 6.75 8.74264 6.75 7.5C6.75 6.25736 7.75736 5.25 9 5.25C10.2426 5.25 11.25 6.25736 11.25 7.5ZM15 5.25C13.7574 5.25 12.75 6.25736 12.75 7.5C12.75 8.74264 13.7574 9.75 15 9.75C16.2426 9.75 17.25 8.74264 17.25 7.5C17.25 6.25736 16.2426 5.25 15 5.25Z" fill="#949499"/>
												</svg>
											</div>
											<div>
												<?=($min_guests!=$max_guests && $min_guests>0 && $max_guests>0) ? $min_guests."-":""?><?=$max_guests ?></div>
										</div>
										<div class="digit_comment"><?=GetMessage("catalog_guests_count") ?></div>
									</div>
									<?} ?>
									<?if ($item["AREA"]["VALUE"]>0){?>
									<div class="flex-grow-1 text-left">
										<div class="digit d-flex">
											<div>
												<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M4.58579 4.58579C4.73329 4.43829 4.90386 4.31386 5.09202 4.21799C5.51984 4 6.0799 4 7.2 4H16.8C17.9201 4 18.4802 4 18.908 4.21799C19.0961 4.31386 19.2667 4.43829 19.4142 4.58579M4.58579 4.58579C4.43829 4.73329 4.31386 4.90386 4.21799 5.09202C4 5.51984 4 6.07989 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.31386 19.0961 4.43829 19.2667 4.58579 19.4142M4.58579 4.58579L19.4142 19.4142M19.4142 4.58579C19.5617 4.73329 19.6861 4.90386 19.782 5.09202C20 5.51984 20 6.0799 20 7.2V16.8C20 17.9201 20 18.4802 19.782 18.908C19.6861 19.0961 19.5617 19.2667 19.4142 19.4142M19.4142 4.58579L4.58579 19.4142M4.58579 19.4142C4.73329 19.5617 4.90386 19.6861 5.09202 19.782C5.51984 20 6.07989 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.0961 19.6861 19.2667 19.5617 19.4142 19.4142" stroke="#949499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
											</div>
											<div><?=$item["AREA"]["VALUE"] ?> <small><?=GetMessage("catalog_descr_m2") ?></small></div>
										</div>
										<div class="digit_comment"><?=GetMessage("catalog_descr_area") ?></div>
									</div>
									<?} ?>
									<?
									/*Количество номеров в категории*/
									if ($item["COUNT_HAVE"]["VALUE"]>0 && $GLOBALS["OPTION_MODUL_SHOW_ROOM_HAVE_COUNT"]=="Y"){?>
									<div class="text-left">
										<div class="digit d-flex">
											<div>
												<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="19.89px" viewBox="390 383.308 20 19.89" enable-background="new 390 383.308 20 19.89" xml:space="preserve">
												<path fill="#949499" d="M407.667,400.433v-14H404v-3.125l-11,1.896v15.229h-3v1.333h3.621L404,403.197v-15.432h2.333v14H410v-1.333H407.667z M402.667,401.667l-8.333-1.149v-14.19l8.333-1.437V401.667z"/>
												<rect x="400" y="392.433" fill="#949499" width="1.333" height="2.667"/>
												</svg>
											</div>
											<div><?=$item["ROOM_COUNT_INFO"]!="" ? $item["ROOM_COUNT_INFO"]:$item["COUNT_HAVE"]["VALUE"] ?></div>
										</div>
										<div class="digit_comment"><?=GetMessage("catalog_have_count") ?></div>
									</div>
									<?} ?>
								</div>
								<div class="price_container d-flex">
									<div class="flex-grow-1 d-flex flex-column price_content align-self-center">
										<div>
											<?if (!empty($item["PRICE_OLD"]["VALUE"])) {?><div class="price_old"><?=number_format($item["PRICE_OLD"]["VALUE"], 0, '.', ' ');?></div><?} ?>
											<?if (!empty($item["PRICE"]["VALUE"])) {?><div class="price"><?=number_format($item["PRICE"]["VALUE"], 0, '.', ' ');?> <?=GetMessage("catalog_price_code") ?></div><?} ?>
										</div>
										
									</div>
								</div>
							</div>
						
							<div class="buttons d-flex order_container">
								<div class="flex-grow-1 text-left"><a class="btn css_border_color small ripple" href="<?=$arParams["SEF_FOLDER"].$item["ID"]."/" ?>"><?=GetMessage("catalog_adit_button") ?></a></div>
								<div class="flex-grow-1 text-right"><a class="btn small ripple fancybox" data-iblock-categ-id="<?=$item["IBLOCK_ID"] ?>" data-iblock-rooms-id="<?=$arParams["IBLOCK_ROOMS_ID"] ?>"  data-categ-id="<?=$item["ID"] ?>" data-header="<?=$item["NAME"] ?>" data-comment="<?=$item["NAME"] ?>" href="#popup_form_modul"><?=GetMessage("catalog_order_button") ?></a></div>
							</div>
							
														
						</div>
						<?
						$images=array();
						if (is_array($item["IMAGES"]["VALUE"])) $images=array_merge($images, $item["IMAGES"]["VALUE"]);;
						if ($item["PREVIEW_PICTURE"]>0) array_unshift($images, $item["PREVIEW_PICTURE"]);
						?>
						<div class="images_wrapper">
							<div class="images slider_images <?=(count($images)>1) ? "owl-carousel owl-theme d-flex flex-wrap small-controls":""?>">
								<?
								foreach ($images as $img_id)
								{
									$img = CFile::GetPath($img_id);
									?>
									<div class="item_img">
										<img src="<?=$img ?>">
									</div>
									<?
								}
								?>
							</div>
							
						</div>
						
						
						
					</div>
					</div>
					<?
				}
				$i++;
			}
			?>
			</div>
		</div>
	</div>
	<?
	$_REQUEST['page']=$page;
	
	$paging_html="";
	if ($pages_count>1)
	{
		$paging_html.='<div class="paging_buttons d-flex flex-wrap justify-content-center justify-content-xl-start">';
		$dif=5;
	
		for ($i=1; $i<=$pages_count; $i++)
		{
			$inner = '';
			$block = array('<a href="javascript:void(0);" class="item">','</a>');
	
	
			if (
					($i>($_REQUEST['page']-($dif/2))) && ($i<($_REQUEST['page']+($dif/2)))
	
					|| ($i<=$dif && $_REQUEST['page']<=$dif-$dif/2)
					|| ($i>$pages_count-$dif && $_REQUEST['page']>$pages_count-$dif/2+1)
	
					)
			{
				$inner = $i;
				if ($i==$_REQUEST['page']) $block = array('<span class="item active">','</span>');
			}
	
			if ($inner!='') $paging_html.=$block[0].$inner.$block[1];
		}
	
		if ($_REQUEST['page']!=$pages_count && $pages_count>1) $paging_html.='<a href="javascript:void(0);" class="item">'.GetMessage("catalog_next_page").'</a>';
		$paging_html.='</div>';
	}
	
	if ($paging_html!=""){
	?>
	<div class="content_container">
		<div class="paging_container">
			<?=$paging_html ?>
		</div>
		
	</div>
	<?} ?>
</div>
<div class="air p20"></div>