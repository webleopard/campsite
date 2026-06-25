<?
$show_fix_header=true;

if (!empty($GLOBALS["OPTION_SHOW_FIX_HEADER"]) && $GLOBALS["OPTION_SHOW_FIX_HEADER"]=="Y")
$show_fix_header=true;
elseif (!empty($GLOBALS["OPTION_SHOW_FIX_HEADER"]) && $GLOBALS["OPTION_SHOW_FIX_HEADER"]=="N")
$show_fix_header=false;

if ($show_fix_header){
?>
<div class="fixed_header">
	<div class="content_container">
		<div class="d-flex">
			<div class="mobile_menu"><div class="icon"><div class="button"></div></div></div>
			<div class="logo flex-grow-1 text-center text-xl-left align-self-center">
				<?=$logo_href[0]?><?$APPLICATION->IncludeFile(SITE_DIR."include/logo_fixed.php");?><?=$logo_href[1]?>
			</div>
			<div class="align-self-center d-none d-md-block">
				<div class="callback"><a class="fancybox btn ripple" data-comment="Заказ звонка" href="#popup_callback"><?=GetMessage("CALLBACK_BTN_TEXT") ?></a></div>
			</div>
		</div>
	</div>	
</div>
<?} ?>