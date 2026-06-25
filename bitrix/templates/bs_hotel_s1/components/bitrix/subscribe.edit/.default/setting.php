<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//setting section
//***********************************
?>
<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
<?echo bitrix_sessid_post();?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
<thead><tr><td colspan="2">
	<div class="air p10"></div>
	<h4><?echo GetMessage("subscr_title_settings")?></h4>
</td></tr></thead>
<tr valign="top">
	<td width="100%">
		<h5><?echo GetMessage("subscr_email")?><span class="star">*</h5>
		<input type="text" name="EMAIL" value="<?=$arResult["SUBSCRIPTION"]["EMAIL"]!=""?$arResult["SUBSCRIPTION"]["EMAIL"]:$arResult["REQUEST"]["EMAIL"];?>" size="30" maxlength="255" /></p>
		<h5><?echo GetMessage("subscr_rub")?><span class="star">*</span></h5>
		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
			<div class="checkbox_style">
				<input id="rubric_<?=$itemValue["ID"] ?>" type="checkbox" name="RUB_ID[]" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> />
				<label for="rubric_<?=$itemValue["ID"] ?>"><?=$itemValue["NAME"]?></label>
			</div>
		<?endforeach;?></p>
		<h5><?echo GetMessage("subscr_fmt")?></h5>
		
		<div class="radio_style d-inline"><input type="radio" id="format_text" name="FORMAT" value="text"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "text") echo " checked"?> /><label for="format_text"><?echo GetMessage("subscr_text")?></label></div>
		&nbsp;/&nbsp;
		<div class="radio_style d-inline"><input type="radio" id="format_html" name="FORMAT" value="html"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo " checked"?> /><label for="format_html">HTML</label></div>
		<div class="air p20"></div>
		<div><small><?echo GetMessage("subscr_settings_note1")?></small></div>
		<div><small><?echo GetMessage("subscr_settings_note2")?></small></div>
		<div class="air p10"></div>
	</td>
</tr>
<tfoot><tr><td colspan="2">
	<div class="btn_container ripple"><input class="btn" type="submit" name="Save" value="<?echo ($arResult["ID"] > 0? GetMessage("subscr_upd"):GetMessage("subscr_add"))?>" /></div>&nbsp;
	<div class="btn_container ripple"><input class="btn"type="reset" value="<?echo GetMessage("subscr_reset")?>" name="reset" /></div>
</td></tr></tfoot>
</table>
<input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
<?if($_REQUEST["register"] == "YES"):?>
	<input type="hidden" name="register" value="YES" />
<?endif;?>
<?if($_REQUEST["authorize"]=="YES"):?>
	<input type="hidden" name="authorize" value="YES" />
<?endif;?>
</form>
<br />
