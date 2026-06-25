<?
$CODE=$filter_prop["CODE"];

$arr_values=$value_arr[$CODE];
if (!empty($arr_values) && is_array($arr_values) && count($arr_values)>1)
{
	?>
	<div class="block">
		<select class="select_<?=$block_id?>_<?=$CODE ?>" name="<?=$CODE ?><?=$filter_prop["MULTIPLE"]=="Y" ? "[]":"" ?>" <?=$filter_prop["MULTIPLE"]=="Y" ? 'multiple="multiple"':"" ?>>
			<option></option>
			<?
		 	foreach ($arr_values as $k=>$arr_value)
			{
				?>
				<option value="<?=$arr_value ?>"><?=$arr_value ?></option>
				<?	
			}
		 
		 ?> 
		</select>
	</div>
	<script>
	$(function () 
	{
		 $('.select_<?=$block_id?>_<?=$CODE ?>').select2({
			 placeholder: "<?=$filter_prop["NAME"] ?>",
			 allowClear: true
		 });
	});
	</script>
	<?
}
?>