<?
/* $_REQUEST["DATE_FROM"]="11.04.2025";
$_REQUEST["DATE_TO"]="30.04.2025"; */
if ($_REQUEST["DATE_FROM"]!="" && $_REQUEST["DATE_TO"]!="")
{

	$DATE_FROM = new DateTime($_REQUEST["DATE_FROM"]);
	$DATE_TO = new DateTime($_REQUEST["DATE_TO"]);
	
	$interval = $DATE_FROM->diff($DATE_TO);
	if ($interval->d>0 && $interval->invert==0)
	{		
	
	
			/*Если указано количество доступных номеров этой категории*/
			if ($item["COUNT_HAVE"]["VALUE"]>0)
			{
				$COUNT_HAVE=$item["COUNT_HAVE"]["VALUE"];
				
				/*Количество свободных номеров на каждую дату*/
				$listData2 = [];
				$start     = $DATE_FROM;
				$end       = $DATE_TO->modify('+1 day');
				$interval  = DateInterval::createFromDateString('1 day');
				$period    = new DatePeriod($start, $interval, $end);
				
				
				$max_reserv_count_per_day=0;
				
				/*Массив привязанных к брони - номера комнат*/
				$room_num_reserve=array();
				
				foreach ($period as $dt) 
				{
				  
				    $max_reserv_count_i=0;
				    $arFilter = Array(
				    		"IBLOCK_ID"=>$_REQUEST["IBLOCK_RESERV_ID"],
				    		"PROPERTY_CATEG_ID"=>$item["ID"],
				    		"PROPERTY_RESERV_CONFIRM_VALUE"=>"Да",
				    		"ACTIVE"=>"Y",
				    		array(
				    				"LOGIC" => "AND",
				    				array("<=PROPERTY_DATE_FROM" => $dt->format("Y-m-d")),
				    				array(">=PROPERTY_DATE_TO" => $dt->format("Y-m-d")),
				    		)
				    );
				    
				    
				    /*Количество занятых номеров на дату*/
				    $res_reserv = CIBlockElement::GetList(Array(), $arFilter, false, false, array("*", "PROPERTY_ROOM_ID"));
				    while($ob_reserv = $res_reserv->GetNextElement())
				    {
				    
				    	/*Номера комнат которые заняты (если у брони указана привязка к номеру)*/
				    	$res_room_num = CIBlockElement::GetByID($ob_reserv->fields["PROPERTY_ROOM_ID_VALUE"]);
				    	if($ar_res = $res_room_num->GetNext())
				    	if (!in_array($ar_res["NAME"], $room_num_reserve))
				    	{
				    		$room_num_reserve[]=$ar_res["NAME"];
				    	}
				    	
				    	$max_reserv_count_i++;
				    		
				    }
				    /* print $dt->format("Y-m-d")."[".$max_reserv_count_i."]:<br>"; */
				    
				    if ($max_reserv_count_i>$max_reserv_count_per_day) $max_reserv_count_per_day=$max_reserv_count_i;
				    
				}
				
				/*Кол. доступных номеров [Общее количество - максимальное количество занятых в день]*/
				$enabled_room_on_interval=$COUNT_HAVE-$max_reserv_count_per_day;
			
				
				
				if ($COUNT_HAVE>0 && $COUNT_HAVE!=$enabled_room_on_interval)
				$item["ROOM_COUNT_INFO"]=$enabled_room_on_interval." <small>".GetMessage("MODUL_FREE_COUNT_FROM")."</small> ".$COUNT_HAVE;
					
				

				if ($enabled_room_on_interval>0)
				$items[]=$item;
				
				
			}
				
	}
	else $items[]=$item;

}
else $items[]=$item;

?>