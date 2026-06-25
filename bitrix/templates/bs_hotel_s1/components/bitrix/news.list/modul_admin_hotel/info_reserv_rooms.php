<?
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ROOMS_ID"], "ACTIVE"=>"Y", "PROPERTY_CATEG_ID"=>$categ["ID"]);
$res_room = CIBlockElement::GetList(Array(), $arFilter, false, false);
while($ob_room = $res_room->GetNextElement())
{
	$arFields_room = $ob_room->GetFields();

	?>
	<div class="room_line_container" style="width: <?=($day_count+1)*100?>px">
		<div class="room_line d-flex" >
		<?
		/*Сетка даты по номерам*/
		foreach ($period as $dt)
		{
			$arFilter = Array(
		    		"IBLOCK_ID"=>$arParams["IBLOCK_RESERV_ID"],
		    		"PROPERTY_CATEG_ID"=>$categ["ID"],
		    		"ACTIVE"=>"Y",
					array(
							"LOGIC" => "AND",
							array("<=PROPERTY_DATE_FROM" => $dt->format("Y-m-d")),
							array(">PROPERTY_DATE_TO" => $dt->format("Y-m-d")),
					)
					
		    );
			
			/* Сколько номеров свободно на дату */
			$res_have_count_by_day = CIBlockElement::GetList(Array(), $arFilter, false, false);
			$count_by_day=$categ["COUNT_HAVE"]["VALUE"]-$res_have_count_by_day->SelectedRowsCount();
			
			
			/*Текущий номер занят*/
			$reserv_id=0;
			$arFilter["PROPERTY_ROOM_ID"]=$arFields_room["ID"];
			$res_room_by_date=CIBlockElement::GetList(Array(), $arFilter, false, false);
			while($ob_room_by_date = $res_room_by_date->GetNextElement())
			{
				$reserv_id=$ob_room_by_date->fields["ID"];
				
			
			}
			?>
			<div class="<?=in_array($dt->format('N'), array(6,7)) ? "is_weekend":"" ?><?=($count_by_day>0 && !$reserv_id>0) ? " active":"" ?>" data-categ_id="<?=$categ["ID"] ?>" data-room_id="<?=$arFields_room["ID"] ?>" data-date="<?=$dt->format("d.m.Y") ?>"><?/*$count_by_day*/ ?></div>
			<?
		}
		?>
		</div>
	
		<?
		/*Брони номера*/  
		$arFilter = Array(
	    		"IBLOCK_ID"=>$arParams["IBLOCK_RESERV_ID"],
	    		"PROPERTY_ROOM_ID"=>$arFields_room["ID"],
	    		"ACTIVE"=>"Y",
	    		array(
	    				"LOGIC" => "OR",
	    				array(
	    					"LOGIC" => "AND",
	    					array("<=PROPERTY_DATE_TO" => $DATE_END->format("Y-m-d")),
	    					array(">=PROPERTY_DATE_TO" => $DATE_START->format("Y-m-d")),
	    				),
	    				array(
	    					"LOGIC" => "AND",
	    					array(">=PROPERTY_DATE_TO" => $DATE_END->format("Y-m-d")),
	    					array("<=PROPERTY_DATE_FROM" => $DATE_START->format("Y-m-d")),
	    				),
	    				array(
	    						"LOGIC" => "AND",
	    						array("<PROPERTY_DATE_FROM" => $DATE_END->format("Y-m-d")),
	    						array(">=PROPERTY_DATE_FROM" => $DATE_START->format("Y-m-d")),
	    				)
	    		)
	    );
		
		/* print_r($arFilter); */
		
		/*Фильтр по бронь подтверждена*/
		if ($arFilterItems["PROPERTY_RESERV_CONFIRM_VALUE"]!="")
		$arFilter["PROPERTY_RESERV_CONFIRM_VALUE"]=$arFilterItems["PROPERTY_RESERV_CONFIRM_VALUE"];
		
		if ($arFilterItems["PROPERTY_RESERV_CONFIRM_VALUE"]=="Нет")
		{
			$arFilter["PROPERTY_RESERV_CONFIRM_VALUE"]=array($arFilterItems["PROPERTY_RESERV_CONFIRM_VALUE"], false);
		
		}
		
		$res_reserv = CIBlockElement::GetList(Array(), $arFilter, false, false);
		while($ob_reserv = $res_reserv->GetNextElement())
		{
			$arFields_reserv = $ob_reserv->GetFields();
			$arProps_reserv = $ob_reserv->GetProperties();

			$grid_width=101;
			
			
			
			/*left_pos*/
			$seconds = strtotime($arProps_reserv["DATE_FROM"]["VALUE"]) - strtotime($DATE_START->format('Y-m-d'));
			$day_start_count_dif=round($seconds / 86400, 1);
			$offset_x=$grid_width*$day_start_count_dif;
			
			/*width*/
			$seconds_reserv_days = strtotime($arProps_reserv["DATE_TO"]["VALUE"]) -  strtotime($arProps_reserv["DATE_FROM"]["VALUE"]);
			$seconds_reserv_days=round($seconds_reserv_days / 86400, 1);
			$item_width=$grid_width*$seconds_reserv_days;
			
			
			$status="status_not_confirm";
			if ($arProps_reserv["RESERV_CONFIRM"]["VALUE"]=="Да")
			$status="status_confirm";
			?>
				<div class="reserv_item <?=$status ?>" data-categ_id="<?=$categ["ID"]?>" data-id="<?=$arFields_reserv["ID"] ?>" style="left: <?=$offset_x ?>px; width: <?=$item_width ?>px"><?=$arFields_reserv["NAME"] ?></div>
			<?
		}
		
		?>
	
	</div>
	<?
}
?>