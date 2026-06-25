<?
$CODE=$property["CODE"];
?>

<div class="block">
	<input autocomplete="off" <?=in_array($CODE, $disabled_fields) ? 'readonly="readonly"':"" ?> <?=$property["IS_REQUIRED"]=="Y" ? 'required=""':'' ?> placeholder="<?=$property["NAME"] ?><?=$property["IS_REQUIRED"]=="Y" ? ' *':'' ?>" type="text" name="<?=$property["CODE"] ?>" value="<?=$item_add_edit[$CODE]["VALUE"] ?>">
</div>