<?	
	$return=array();
	$month_array=GetMessage("month_list");
	$week_day_list=GetMessage("week_day_list");
	
	$DATE_START = new DateTime($_REQUEST["DATE_START"]);
	$DATE_END = new DateTime($_REQUEST["DATE_END"]);

	$interval = $DATE_START->diff($DATE_END);
	


	$seconds = abs(strtotime($DATE_END->format('Y-m-d')) - strtotime($DATE_START->format('Y-m-d')));
	$day_count=round($seconds / 86400, 1); 

	$date_array=array();
	if ($day_count>0)
	{
		$start     = $DATE_START;
		$end       = $DATE_END->modify('+1 day');
		$interval  = DateInterval::createFromDateString('1 day');
		$period    = new DatePeriod($start, $interval, $end);
	
		?>
		<div class="dates d-flex">
			<?
			foreach ($period as $dt)
			{
				$dt_name="<div>".$dt->format("d")." ".$month_array[$dt->format("n")]."</div><div>".$week_day_list[$dt->format('N')]."</div>";
				?><div class="date_item d-flex flex-column justify-content-center <?=in_array($dt->format('N'), array(6,7)) ? "is_weekend":"" ?>"><?=$dt_name ?></div>
				<?
				$date_array[]=$dt;
			}?>
		</div>
		<?
	}
?>