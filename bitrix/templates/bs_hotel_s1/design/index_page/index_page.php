<?
$index_page_blocks_all=array();
if (!empty($GLOBALS["INDEX_PAGE_BLOCKS_ORDER"]))
{
	$index_page_blocks_all=explode(",",$GLOBALS["INDEX_PAGE_BLOCKS_ORDER"]);
}
else 
{
	foreach (GetMessage("INDEX_PAGE_BLOCK") as $k=>$item)
	$index_page_blocks_all[]=$k;
}


$index_page_blocks_show=array();
foreach ($index_page_blocks_all as $k)
{
	if (!isset($GLOBALS["INDEX_PAGE_BLOCK_SHOW_".$k]) || $GLOBALS["INDEX_PAGE_BLOCK_SHOW_".$k]=="Y")
		$index_page_blocks_show[]=$k;
}

?>

<div class="index_page_all_blocks_container">
<?

foreach ($index_page_blocks_show as $block)
if ($block!="slider")
{
	?><div class="page_block_container"><?
	
	include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/blocks/$block.php");
	
	?></div><?
}

?>
</div>
