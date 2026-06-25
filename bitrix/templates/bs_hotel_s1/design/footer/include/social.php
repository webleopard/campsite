
<?
foreach (GetMessage("OPTION_SOCIAL") as $k=>$item)
if (!empty($GLOBALS["OPTION_SOCIAL_".$k]))
{
	?><a class="item <?=$k ?>" href="<?=$GLOBALS["OPTION_SOCIAL_".$k] ?>" target="_blank"></a><?
}
?>
