<?
/*
 $block_name - название блока (для настроек главной)
 blockCatalogSelectorModulAdmin - идентификатор блока
 ajax_search_prefix_xxx - функция поиска
 templateCatalogPath_xxx  - путь
 */


/*Параметры передаваемые в ajax запросах*/
$jsParams=array("IBLOCK_ID", "IBLOCK_ROOMS_ID", "IBLOCK_RESERVE_ID", "NEWS_COUNT", "SORT_BY1", "SORT_ORDER1");

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


/*ID блока категории*/
$properties = CIBlockProperty::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"],"CODE"=>"CATEG_ID"));
while($property = $properties->Fetch())
{
	$CATEG_IBLOCK_ID=$property["LINK_IBLOCK_ID"];
}

/*Демо режим*/
$_SESSION["demo_mode_module_admin"]=false;
if ($arParams["DEMO_MODE"]=="Y") $_SESSION["demo_mode_module_admin"]=true;
if ($_SESSION["demo_mode_module_admin"] && !isset($_REQUEST["CATEG_ID"]))
{
	/*Демо категории номеров*/
	$arFilter = Array("IBLOCK_ID"=>$CATEG_IBLOCK_ID, "ACTIVE"=>"Y");
	$res_categ_filter = CIBlockElement::GetList(Array(), $arFilter, false, false);
	while($ob_categ_filter = $res_categ_filter->GetNextElement())
	{
		if (in_array($ob_categ_filter->fields["NAME"], array("Эконом", "Стандарт (2 кровати)")))
		$_REQUEST["CATEG_ID"][]=$ob_categ_filter->fields["ID"];
	}
	
	if (!isset($_REQUEST["DATE_START"])) 	$_REQUEST["DATE_START"]="14.04.2025";
	if (!isset($_REQUEST["DATE_END"])) 		$_REQUEST["DATE_END"]="30.04.2025"; 
}



global $USER;
if (!$USER->IsAdmin() && !$_SESSION["demo_mode_module_admin"])
{
	?>
	<div class="air p30"></div>
	<div class="content_container"><b><?=GetMessage("ADD_EDIT_NO_ADMIN_COMMENT") ?></b></div>
	<div class="air p30"></div>
	<?
	return;
}



/*Даты*/
if (!isset($_REQUEST["DATE_START"])) 	$_REQUEST["DATE_START"]=date('d.m.Y', strtotime("-1 week"));
if (!isset($_REQUEST["DATE_END"]))		$_REQUEST["DATE_END"]=date('d.m.Y', strtotime("+5 week"));


use Bitrix\Main\Page\Asset;
Asset::getInstance()->addJs($templateFolder."/search/script.js");
Asset::getInstance()->addCss($templateFolder."/search/style.css");

Asset::getInstance()->addJs($templateFolder."/item_edit/script.js");
Asset::getInstance()->addCss($templateFolder."/item_edit/style.css");




$block_id="module_admin";



$block_name="modul_admin_hotel";
$page_block=GetMessage("INDEX_PAGE_BLOCK")[$block_name];
$block_header="";
if (isset($GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name])) $block_header=$GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name];
else
$block_header=$page_block["header"]!="" ? $page_block["header"]:$page_block["name"];


$header_tag="h2";
/* if ($arParams["HEADER_H2"]=="Y") $header_tag="h2"; */
?>

<script>
var templateCatalogPath_ModulAdmin = "<?=$templateFolder?>";
var blockCatalogSelectorModulAdmin=".<?=$block_id?>_block_selector";
var on_input_change_listener=true;
var iblock_reserve_id=<?=$arParams["IBLOCK_ID"] ?>;
var iblock_rooms_id=<?=$arParams["IBLOCK_ID"] ?>;
var add_edit_del_confirm='<?=GetMessage("ADD_EDIT_DEL_CONFIRM") ?>';
</script>

<div id="add_edit_form" class="ajax_form popup color">
	<div class="popup_content"></div>
</div>

<div class="<?=$block_id ?>_block_selector catalog_block_wrapper module_admin">

	
	<?include('search/filter_props.php');?>
	<?include('search/search_items.php');?>
	<?include('search/search_panel.php');?>
	
	
	<?
	include('item_edit/item_edit_form.php');
	?>
	
	<?
	if (empty($items)) $items=array();
	?>
	<div class="rel">
		<div class="search_loader" style="display: none;"><span class="loader"></span></div>
		<div class="content_container catalog">
			<div class="search_result d-flex">
				
				
				<div class="left_col">
					<div class="d-flex flex-column">
						
						<div>
						<?
						
						/*Категории*/
						$categ_array=array();
						$arFilter = Array("IBLOCK_ID"=>$CATEG_IBLOCK_ID, "ACTIVE"=>"Y");
						if (!empty($_REQUEST["CATEG_ID"]))
						$arFilter["ID"]=$_REQUEST["CATEG_ID"];
						$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false);
						while($ob = $res->GetNextElement())
						{
							$arFields = $ob->GetFields();
							$arProps = $ob->GetProperties();
							
							$cat_item=array_merge($arFields, $arProps);
							
							/*Количество номеров в категории*/
							$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ROOMS_ID"], "ACTIVE"=>"Y", "PROPERTY_CATEG_ID"=>$arFields["ID"]);
							
	
							$res_have_count = CIBlockElement::GetList(Array(), $arFilter, false, false);
							$cat_item["COUNT_HAVE"]["VALUE"]=$res_have_count->SelectedRowsCount();
							
							$categ_array[]=$cat_item;
							?>
							<div class="section_block">
								<div class="name"><?=$cat_item["NAME"] ?></div>
								<div class="rooms">
									<?
									$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ROOMS_ID"], "ACTIVE"=>"Y", "PROPERTY_CATEG_ID"=>$arFields["ID"]);
									$res_room = CIBlockElement::GetList(Array(), $arFilter, false, false);
									while($ob_room = $res_room->GetNextElement())
									{
										$arFields_room = $ob_room->GetFields();
									
										?>
										<div class="room_item">Номер: <?=$arFields_room["NAME"] ?></div>
										<?
									}
									?>
								</div>
							</div>
							<?
						
						}
						?>
						</div>
					</div>
				</div>
				<div class="right_col flex-grow-1">
					<div class="right_col_content">
						<?include('info_date_list.php');?>
						<?include('info_reserv.php');?>
					</div>
				</div>
				
			</div>
		</div>
	</div>

	
</div>
<div class="air p20"></div>