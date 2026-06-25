<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<?

if (CModule::IncludeModule('subscribe'))
{
	if ($_REQUEST["name"]=='' && isset($_REQUEST["email"]))
	if (filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) 
	{
	
	
		$rub = CRubric::GetList(
				array("LID"=>"ASC","SORT"=>"ASC","NAME"=>"ASC"),
				/*ID всех публичных рассылок*/
				array("ACTIVE"=>"Y", "LID"=>LANG, "VISIBLE"=>"Y")
				);
		$arRubIDS = array();
		while ($arRub = $rub->Fetch()){
			$arRubIDS[] = $arRub['ID'];
		}
		
		
		// формируем массив с полями для создания подписки
		$arFields = Array(
				"USER_ID" => ($USER->IsAuthorized() ? $USER->GetID() : false),
				"FORMAT" => "html",
				"EMAIL" => $_REQUEST['email'],
				"ACTIVE" => "N",
				"RUB_ID" => $arRubIDS,
				"SEND_CONFIRM" => 'Y'
		);
		 
		
		$subscr = new CSubscription;
		
		// создаем подписку
		$ID = $subscr->Add($arFields);
		if ($ID > 0)
		{
			$arResult['status'] = 'ok';
		} 
		else 
		{
			$arResult['status'] = 'error';
			$arResult['msg'] = str_replace("<br>","",$subscr->LAST_ERROR);
		}
			
		print json_encode($arResult);

	}

}


?>