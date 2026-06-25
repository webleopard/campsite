<?
$CODE=$filter_prop["CODE"];

if ($min_arr[$CODE]>0 && $max_arr[$CODE]>0)
{

	$slider_float=false;
	if (($min_arr[$CODE] != intval($min_arr[$CODE])) || ($max_arr[$CODE] != intval($max_arr[$CODE]))) $slider_float = true;
	
	$slider_descimals=$slider_float ? "1": "0";	
	
	
?>
<script>
$(function () 
{
	var slider_<?=$block_id?>_<?=$CODE?>=$("#slider_<?=$block_id?>_<?=$CODE?>").slider({
		step: <?=$slider_float ? "0.01":"1"?>,
		range: true,
		min: <?=$min_arr[$CODE] ?>,
		max: <?=$max_arr[$CODE] ?>,
		values: [<?=$min_arr[$CODE] ?>, <?=$max_arr[$CODE] ?>],
		slide: function( event, ui ) 
		{
			var val1 = (ui.values[ 0 ]+'').replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
    	  	var val2 = (ui.values[ 1 ]+'').replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');

    	  	$(blockCatalogSelector+' .slider_data_<?=$CODE?> .slider_from').val(val1);
    	  	$(blockCatalogSelector+' .slider_data_<?=$CODE?> .slider_to').val(val2);

    		$(blockCatalogSelector+' [name=<?=$CODE?>_from]').val(ui.values[0]);
    		$(blockCatalogSelector+' [name=<?=$CODE?>_to]').val(ui.values[1]);


		},
		stop: function( event, ui ) 
		{
			$(blockCatalogSelector+' [name=<?=$CODE?>_from]').trigger("change");	
		},
		change: function( event, ui ) {}
	});

	$(document).on('change','.slider_data_<?=$CODE?> input', function() 
	{
		slider_<?=$block_id?>_<?=$CODE?>.slider("values", [$(this).parents(".slider_data").find(".slider_from").data("inp_val"), $(this).parents(".slider_data").find(".slider_to").data("inp_val")]);
	});
	

	
});
</script>
<div class="block">
	<div class="slider_container">
		<label><?=$filter_prop["NAME"] ?></label>
		<div id="slider_<?=$block_id?>_<?=$CODE?>" class="slider"></div>
		<div class="slider_data slider_data_<?=$CODE?>">
			<div>
				<input data-min="<?=$min_arr[$CODE] ?>" class="slider_from" type="text" value="<?=number_format($min_arr[$CODE], $slider_descimals, '.', ' ')?>">
			</div>
			<div>
				<input data-max="<?=$max_arr[$CODE] ?>" class="slider_to" type="text" value="<?=number_format($max_arr[$CODE], $slider_descimals, '.', ' ')?>">
			</div>
			
			<input type="hidden" data-default="<?=$min_arr[$CODE] ?>" data-input="slider_from" name="<?=$CODE?>_from" value="<?=$_REQUEST[$CODE.'_from']>0 ? $_REQUEST[$CODE.'_from'] : $min_arr[$CODE]?>"/>
			<input type="hidden" data-default="<?=$max_arr[$CODE] ?>" data-input="slider_to" name="<?=$CODE?>_to" value="<?=$_REQUEST[$CODE.'_to']>0 ? $_REQUEST[$CODE.'_to'] : $max_arr[$CODE] ?>"/>
		</div>
	</div>
</div>
	<?
}
?>

