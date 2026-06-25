<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main\Localization\Loc;

?>
<script>
	var templateFolder='<?=$templateFolder?>';
</script>
<div class="subscribe_form d-flex">
	<div class="flex-grow-1">
		<input type="text" name="email" value="" placeholder="<?=GetMessage("subscr_form_title") ?>" autocomplete="off"> 
		<input type="hidden" name="name" value="">
	</div>
	<div>
		<span class="iconfont_a_container"><a class="btn_subscribe" href="javascript:void(0);"></a></span>
	</div>
</div>