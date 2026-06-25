<?
/*Категории*/
foreach ($categ_array as $categ)
{
	
		?>
		<div class="categ_data">
		<div class="free_count d-flex">
		<?
		/*Свободных номеров на дату*/
		foreach ($period as $dt) 
		{
			$arFilter = Array(
			    		"IBLOCK_ID"=>$_REQUEST["IBLOCK_ID"],
			    		"PROPERTY_CATEG_ID"=>$categ["ID"],
			    		/* "PROPERTY_RESERV_CONFIRM_VALUE"=>"Да", */
			    		"ACTIVE"=>"Y",
			    		array(
			    				"LOGIC" => "AND",
			    				array("<=PROPERTY_DATE_FROM" => $dt->format("Y-m-d")),
			    				array(">PROPERTY_DATE_TO" => $dt->format("Y-m-d")),
			    		)
			  );
			
			/*Количество занятых номеров на дату*/
			$reserv_date_count=0;
			$res_reserv = CIBlockElement::GetList(Array(), $arFilter, false, false, array("*", "PROPERTY_ROOM_ID"));
			while($ob_reserv = $res_reserv->GetNextElement())
			{
				$reserv_date_count=$res_reserv->SelectedRowsCount();
				
			}
			$free_count=$categ["COUNT_HAVE"]["VALUE"]-$reserv_date_count;
			?>
			<div <?=!$free_count>0 ? "class='alert'":"" ?>><?=$free_count ?></div>
			<?

		}
		?>
		</div>
		<?
		/*Номера*/
		include('info_reserv_rooms.php');
		
		?>
		</div>
		<?

}
?>