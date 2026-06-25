<?
$debug_search=false;

/* $arFilterItems=array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "PROPERTY_CATEG_NAME_VALUE"=>"Стандарт"); */
$arFilterItems=array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y",  "PROPERTY_OPTION_ID_VALUE"=>"Популярный номер");

/*Фильтр ajax*/
include('search_filter.php');

/*Элементы инфоблока*/
$min_arr=array();
$max_arr=array();


$value_arr=array();
$value_arr_group_by_field=array(); /*"FIELD_CODE", "FIELD_CODE2"*/


/*Поля для счетчика количества значений*/
$counts_arr=array();
$count_fileds_group_by=array();
$count_fileds_group_by_field=array(); /*"STATUS"=>"ROOMS", ...*/

/*Поля для счетчика суммы*/
$summ_arr=array();
$summ_arr_group_by=array();
$summ_arr_group_by_field=array(); /*"STATUS"=>"PRICE", ...*/


/*Поиск*/
$arSort=array($arParams["SORT_BY1"]=>$arParams["SORT_ORDER1"]);
$res = CIBlockElement::GetList($arSort, $arFilterItems, false, false);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	$arProps = $ob->GetProperties();
	
	/* print $arFields["ID"]."<br>"; */

	$item=array_merge($arFields, $arProps);

	/*Стандартные данные по массиву элементов min_arr, max_arr, value_arr*/
	foreach ($arProps as $k=>$prop)
	{
		/*Минимальные, максимальные значения*/
		$prop["VALUE"]=str_replace(",",".",$prop["VALUE"]);
		if (is_numeric($prop["VALUE"]))
		{
			if (empty($min_arr[$k]) || $prop["VALUE"]<$min_arr[$k]) $min_arr[$k]=$prop["VALUE"];
			if (empty($max_arr[$k]) || $prop["VALUE"]>$max_arr[$k]) $max_arr[$k]=$prop["VALUE"];
		}

		/*Массив уникальных значений параметров*/
		if (!empty($prop["VALUE"]))
		{
			if (is_array($prop["VALUE"]))
			{
				foreach ($prop["VALUE"] as $k_prop=>$v_prop)
				{
					if (!is_array($value_arr[$k]) || !in_array($v_prop, $value_arr[$k]))
					$value_arr[$k][]=$v_prop;
					
				}
				
				/*Группировка*/
				foreach ($value_arr_group_by_field as $gr)
				{
					foreach ($prop["VALUE"] as $k_prop=>$v_prop)
					{
						if (!is_array($value_arr_group_by[$k][$arProps[$gr]["VALUE"]]))
						$value_arr_group_by[$k][$arProps[$gr]["VALUE"]]=array();
							
						if (!in_array($v_prop, $value_arr_group_by[$k][$arProps[$gr]["VALUE"]]))
						$value_arr_group_by[$k][$arProps[$gr]["VALUE"]][]=$v_prop;
								
					}
				}
			}
			else
			{
				if (!is_array($value_arr[$k]) || !in_array($prop["VALUE"], $value_arr[$k]))
				$value_arr[$k][]=$prop["VALUE"];
				
				
				/*Группировка*/
				foreach ($value_arr_group_by_field as $gr)
				{
					if (!is_array($value_arr_group_by[$k][$arProps[$gr]["VALUE"]])) 
					$value_arr_group_by[$k][$arProps[$gr]["VALUE"]]=array();
					
					if (!in_array($prop["VALUE"], $value_arr_group_by[$k][$arProps[$gr]["VALUE"]]))
					$value_arr_group_by[$k][$arProps[$gr]["VALUE"]][]=$prop["VALUE"];
				}
			}
		}
		
		/*Счетчик значений*/
		$counts_arr[$k][strval($prop["VALUE"])]+=1;		
		
		/*Сумма значений*/
		if (is_numeric($prop["VALUE"]))
		{
			if (is_null($summ_arr[$k])) $summ_arr[$k]=0;
			$summ_arr[$k]+=(float)$prop["VALUE"];
		}
	}
	
	/*С группировками по количеству*/
	foreach ($count_fileds_group_by_field as $k_gr=>$v_gr)
	{
		$count_fileds_group_by[$k_gr][$arProps[$k_gr]["VALUE"]][$arProps[$v_gr]["VALUE"]]+=1;
	}
	
	/*С группировками по сумме*/
	foreach ($summ_arr_group_by_field as $k_gr=>$v_gr)
	{
		$summ_arr_group_by[$k_gr][$arProps[$k_gr]["VALUE"]]+=$arProps[$v_gr]["VALUE"];
	}

	/*Модуль*/
	$GLOBALS["NO_SETTINGS_STYLE"]="Y";
	$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/design/settings_final.php");
	if ($GLOBALS["OPTION_MODUL_USE"]=="Y")
	{
		include('modul_item.php');
	}
	else
	$items[]=$item;

}

if ($debug_search)
{
	echo '<br><br>';
	
	echo '$min_arr='.print_r($min_arr,1).'<br>';
	echo '$max_arr='.print_r($max_arr,1).'<br>';
	
	echo '$value_arr='.print_r($value_arr,1).'<br>';
	echo '$value_arr_group_by_field='.print_r($value_arr_group_by_field,1).'<br>';
	
	echo '$counts_arr='.print_r($counts_arr,1).'<br>';
	echo '$count_fileds_group_by='.print_r($count_fileds_group_by,1).'<br>';
	echo '$count_fileds_group_by_field='.print_r($count_fileds_group_by_field,1).'<br>';
	
	echo '$summ_arr='.print_r($summ_arr,1).'<br>';
	echo '$summ_arr_group_by='.print_r($summ_arr_group_by,1).'<br>';
	echo '$summ_arr_group_by_field='.print_r($summ_arr_group_by_field,1).'<br>';
	
	echo '<br><br>';
	
}

if (!is_array($items)) $items=array();
?>