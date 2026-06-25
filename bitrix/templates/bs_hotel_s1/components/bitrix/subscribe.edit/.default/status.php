<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//status and unsubscription/activation section
//***********************************
?>
<h4><?echo GetMessage("subscr_title_status")?></h4>
<form action="<?=$arResult["FORM_ACTION"]?>" method="get">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table data-param">
	<tr valign="top">
		<td nowrap><?echo GetMessage("subscr_conf")?></td>
		<td nowrap class="<?echo ($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"? "notetext":"errortext")?>"><?echo ($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"? GetMessage("subscr_yes"):GetMessage("subscr_no"));?></td>
	</tr>
	<tr>
		<td nowrap><?echo GetMessage("subscr_act")?></td>
		<td nowrap class="<?echo ($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"? "notetext":"errortext")?>"><?echo ($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"? GetMessage("subscr_yes"):GetMessage("subscr_no"));?></td>
	</tr>
	<tr>
		<td nowrap><?echo GetMessage("adm_id")?></td>
		<td nowrap><?echo $arResult["SUBSCRIPTION"]["ID"];?>&nbsp;</td>
	</tr>
	<tr>
		<td nowrap><?echo GetMessage("subscr_date_add")?></td>
		<td nowrap><?echo $arResult["SUBSCRIPTION"]["DATE_INSERT"];?>&nbsp;</td>
	</tr>
	<tr>
		<td nowrap><?echo GetMessage("subscr_date_upd")?></td>
		<td nowrap><?echo $arResult["SUBSCRIPTION"]["DATE_UPDATE"];?>&nbsp;</td>
	</tr>
	<?if($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"):?>
		<tfoot><tr><td colspan="3" class="no_border">
		<?if($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"):?>
			<div class="air p10"></div>
			<div class="btn_container ripple"><input class="btn small" type="submit" name="unsubscribe" value="<?echo GetMessage("subscr_unsubscr")?>" /></div>
			<input type="hidden" name="action" value="unsubscribe" />
		<?else:?>
			<div class="air p10"></div>
			<div class="btn_container ripple"><input class="btn small" type="submit" name="activate" value="<?echo GetMessage("subscr_activate")?>" /></div>
			<input type="hidden" name="action" value="activate" />
		<?endif;?>
		</td></tr></tfoot>
	<?endif;?>
</table>
	
	<div class="air p20"></div>
	
	<?if($arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y"):?>
		<div class="note_alert note_alert_icon"><span class="iconfont icon-triangle-exclamation-regular"></span> <?echo GetMessage("subscr_title_status_note1")?></div>
	<?elseif($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"):?>
		<div class="note_green note_alert_icon"><span class="iconfont icon-triangle-exclamation-regular"></span> <?echo GetMessage("subscr_title_status_note2")?></div>
		<p><?echo GetMessage("subscr_status_note3")?></p>
	<?else:?>
		<p><?echo GetMessage("subscr_status_note4")?></p>
		<p><?echo GetMessage("subscr_status_note5")?></p>
	<?endif;?>
<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
<?echo bitrix_sessid_post();?>
</form>
<br />