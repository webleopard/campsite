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

$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-'.$arParams['TEMPLATE_THEME'] : '';

?>
<div class="top_search_panel">
<div class="content_container" id="top_search_panel_result">
<?

if($arParams["SHOW_INPUT"] !== "N"):?>
<div id="<?echo $CONTAINER_ID?>" class="bx-searchtitle <?=$themeClass;?>">
	<div class="d-flex">
		<div class="flex-grow-1">
			<form action="<?echo $arResult["FORM_ACTION"]?>">
				<div class="d-flex">
					<div class="flex-grow-1">
						<input placeholder="Поиск..." class="mr-2 <?echo $INPUT_ID?>" id="<?echo $INPUT_ID?>" type="text" name="q" value="<?=htmlspecialcharsbx($_REQUEST["q"])?>" autocomplete="off" class="form-control"/>
					</div>
					<div>
						<a class="btn ripple" onclick="$(this).parents('form').submit();">Найти</a>
					</div>
				</div>
			</form>
		</div>
		<div class="align-self-center">
			<a class="button_close" title="Закрыть" href="javascript:void(0);">
				<span class="iconfont icon-xmark"></span>
			</a>
		</div>
	</div>
</div>
<?endif?>
<script>
	BX.ready(function(){
		new JCTitleSearch({
			'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
			'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
			'INPUT_ID': '<?echo $INPUT_ID?>',
			'MIN_QUERY_LEN': 2
		});
	});
</script>
</div>
</div>
