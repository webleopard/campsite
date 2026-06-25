<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?require($_SERVER["DOCUMENT_ROOT"].htmlspecialcharsbx($_REQUEST["COMPONENT_PATH_FORM_HOTEL"])."/lang/ru/template.php");?>
<?

$GLOBALS["NO_SETTINGS_STYLE"]="Y";
require($_SERVER["DOCUMENT_ROOT"].htmlspecialcharsbx($_REQUEST["SITE_TEMPLATE_PATH"])."/design/settings_final.php");
?>
<?
/* http://bs_hotel/local/templates/bs_hotel/include/ajax/ajax_modul_form.php */
/* $_REQUEST["IBLOCK_ID"]="62";
$_REQUEST["IBLOCK_CATEG_ID"]="60";
$_REQUEST["IBLOCK_ROOMS_ID"]="61";
$_REQUEST["CATEG_ID"]="636";
$_REQUEST["DATE_FROM"]="01.04.2025";
$_REQUEST["DATE_TO"]="20.04.2025"; */
if ($_REQUEST["DATE_FROM"]!="" && $_REQUEST["DATE_TO"]!="")
{
	
	$return=array();
	
	$DATE_FROM = new DateTime($_REQUEST["DATE_FROM"]);
	$DATE_TO = new DateTime($_REQUEST["DATE_TO"]);
	
	$interval = $DATE_FROM->diff($DATE_TO);
	if ($interval->d>0 && $interval->invert!=1)
	$return["days"]=GetMessage("MODUL_ITEM_DAYS_NAME").": ".$interval->d;
	
	
	/*Если количество дней не больше нуля*/
	$date_alert="N";
	if ($interval->invert==1 || !$interval->d>0)
	$date_alert="Y";
	$return["date_alert"]=$date_alert;
	
	if ($interval->d>0)
	{
		CModule::IncludeModule('iblock');
		
		
		$arFilter = Array("IBLOCK_ID"=>$_REQUEST["IBLOCK_CATEG_ID"], "ID"=>$_REQUEST["CATEG_ID"], "ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false);
		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();
			$item=array_merge($arFields, $arProps);
			
			
			$item["COUNT_HAVE"]["VALUE"]=0;
			if ($GLOBALS["OPTION_MODUL_USE"]=="Y" && $_REQUEST["IBLOCK_ROOMS_ID"]>0)
			{
				$arFilter = Array("IBLOCK_ID"=>$_REQUEST["IBLOCK_ROOMS_ID"], "ACTIVE"=>"Y", "PROPERTY_CATEG_ID"=>$item["ID"]);
				$res = CIBlockElement::GetList(Array(), $arFilter, false, false);
				$item["COUNT_HAVE"]["VALUE"]=$res->SelectedRowsCount();
			}
			
			/*Количество доступных номеров этой категории*/
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
				$room_id_reserve=array();
				
				foreach ($period as $dt) 
				{
				  
				    $max_reserv_count_i=0;
				    $arFilter = Array(
				    		"IBLOCK_ID"=>$_REQUEST["IBLOCK_ID"],
				    		"PROPERTY_CATEG_ID"=>$_REQUEST["CATEG_ID"],
				    		"PROPERTY_RESERV_CONFIRM_VALUE"=>"Да",
				    		"ACTIVE"=>"Y",
				    		array(
				    				"LOGIC" => "AND",
				    				array("<=PROPERTY_DATE_FROM" => $dt->format("Y-m-d")),
				    				array(">PROPERTY_DATE_TO" => $dt->format("Y-m-d")),
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
				    		$room_id_reserve[]=$ar_res["ID"];
				    	}
				    	
				    	$max_reserv_count_i++;
				    		
				    }
				    /* print $dt->format("Y-m-d")."[".$max_reserv_count_i."]:<br>"; */
				    
				    if ($max_reserv_count_i>$max_reserv_count_per_day) $max_reserv_count_per_day=$max_reserv_count_i;
				    
				}
				
				/*Кол. доступных номеров [Общее количество - максимальное количество занятых в день]*/
				$enabled_room_on_interval=$COUNT_HAVE-$max_reserv_count_per_day;
				
				

				if ($GLOBALS["OPTION_MODUL_USE"]=="Y")
				if ($GLOBALS["OPTION_MODUL_SHOW_ROOM_FREE_COUNT"]=="Y")
				if ($enabled_room_on_interval>0 && $COUNT_HAVE>0)
				{
					
					/*Доступны 3 из 10 номеров*/
					if ($enabled_room_on_interval!=$COUNT_HAVE)
					$return["ROOM_COUNT_INFO"]=GetMessage("MODUL_FREE_COUNT").": "." ".$enabled_room_on_interval." ".GetMessage("MODUL_FREE_COUNT_FROM")." ".$COUNT_HAVE;
					
					/*Доступны 10 номеров*/
					if ($enabled_room_on_interval==$COUNT_HAVE)
					$return["ROOM_COUNT_INFO"]=GetMessage("MODUL_FREE_COUNT").": ".$enabled_room_on_interval;
				}
				
				
				if ($GLOBALS["OPTION_MODUL_USE"]=="Y" && !$enabled_room_on_interval>0)
				{
					$return["ROOM_COUNT_INFO"]=GetMessage("MODUL_DISABLED_ORDER_BY_FREE");
					$return["MODUL_DISABLED_ORDER"]="Y";
				}
				
				/*Привязка номера*/
				$arFilter = Array("IBLOCK_ID"=>$_REQUEST["IBLOCK_ROOMS_ID"], "ACTIVE"=>"Y", "!ID"=>$room_id_reserve, "PROPERTY_CATEG_ID"=>$item["ID"]);
				$res_room_free = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false);
				while($ob_room_free= $res_room_free->GetNextElement())
				{
					$return["ROOM_ID"]=$ob_room_free->fields["ID"];
					break;
				}
				
			}
		}
	}
	
	
	/* print_r($return); */
	print json_encode($return);
}
?>