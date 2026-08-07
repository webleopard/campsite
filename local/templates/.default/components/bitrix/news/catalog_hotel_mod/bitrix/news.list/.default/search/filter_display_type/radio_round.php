<?
$CODE=$filter_prop["CODE"];

$arr_values=$value_arr[$CODE];
if (!empty($arr_values) && is_array($arr_values) && count($arr_values)>1)
{
	?>
	<div class="block radio_round_container <?=$filter_prop["MULTIPLE"]=="Y" ? "is_multiple":""?>">
		<div class="text-center"><label><?=$filter_prop["NAME"] ?>:</label></div>
		<div class="radio_round d-flex">
			<?
			/*Сортируем значение если число*/
			$nubmer_values=true;
			foreach ($arr_values as $k=>$arr_value)
			{
				if (!floatval($arr_value)>0)	
				$nubmer_values=false;
			}
			
			if ($nubmer_values) sort($arr_values); 
			
			foreach ($arr_values as $k=>$arr_value)
			{
				?>
				<div class="item">
					<input name="<?=$CODE ?>[]" type="checkbox" value="<?=$arr_value ?>">
					<?=$arr_value ?>
				</div>
				<?	
			}
			?>
		</div>
	</div>
	<?
}
?>