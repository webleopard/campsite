<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//*************************************
//show confirmation form
//*************************************
?>
<form action="<?=$arResult["FORM_ACTION"]?>" method="get">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
<thead><tr><td colspan="2"><h5><?echo GetMessage("subscr_title_confirm")?></h5></td></tr></thead>
<tr valign="top">
	<td width="100%">
		<p><?echo GetMessage("subscr_conf_code")?><span class="star">*</span><br />
		<input type="text" name="CONFIRM_CODE" value="<?echo $arResult["REQUEST"]["CONFIRM_CODE"];?>" size="20" /></p>
		<p><?echo GetMessage("subscr_conf_date")?></p>
		<p><?echo $arResult["SUBSCRIPTION"]["DATE_CONFIRM"];?></p>	
	</td>
</tr>
<tfoot><tr><td colspan="2">
	<div class="btn_container ripple"><input class="btn" type="submit" name="confirm" value="<?echo GetMessage("subscr_conf_button")?>" /></div>
	<div class="air p10"></div>
	<?echo GetMessage("subscr_conf_note1")?> <a class="color1" title="<?echo GetMessage("adm_send_code")?>" href="<?echo $arResult["FORM_ACTION"]?>?ID=<?echo $arResult["ID"]?>&amp;action=sendcode&amp;<?echo bitrix_sessid_get()?>"><?echo GetMessage("subscr_conf_note2")?></a>.
</td></tr></tfoot>
</table>
<input type="hidden" name="ID" value="<?echo $arResult["ID"];?>" />
<?echo bitrix_sessid_post();?>
</form>
<br />
