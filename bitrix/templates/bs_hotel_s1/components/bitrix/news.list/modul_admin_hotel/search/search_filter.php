<?
$debug_search_filter=false;

$arFilterAjax=array();
if (!empty($filter_prop_items))
{
	foreach ($filter_prop_items as $id=>$filter_prop)
	{
		if (!empty($_REQUEST[$filter_prop["CODE"]]))
		{
			$CODE=$filter_prop["CODE"];
			
			$CODE_PROP_NAME="PROPERTY_".$filter_prop["CODE"];
			if ($filter_prop["PROPERTY_TYPE"]=="L")
			$CODE_PROP_NAME="PROPERTY_".$filter_prop["CODE"]."_VALUE";
			
			/*Если в массиве один элемент - заменяем первым*/
			if (is_array($_REQUEST[$CODE]) && count($_REQUEST[$CODE])==1)
			{
				$_REQUEST[$CODE]=$_REQUEST[$CODE][0];
			}
			
			/*Массив значений*/
			if (is_array($_REQUEST[$CODE]) && count($_REQUEST[$CODE])>1)
			{
				$tmp_filter=array("LOGIC" => "OR");
				
				$value_arr=$_REQUEST[$CODE];
				foreach ($value_arr as $val)
				{
					$tmp_filter[]=array($CODE_PROP_NAME=>$val);
				}
				
				$arFilterAjax[]=$tmp_filter;
			}
			elseif(!empty($_REQUEST[$filter_prop["CODE"]]))
			{
				$arFilterAjax[$CODE_PROP_NAME]=$_REQUEST[$CODE];
			}
		}
		
		/*Фильты от и до - ползунок*/
		if (!empty($_REQUEST[$filter_prop["CODE"]."_from"]) || !empty($_REQUEST[$filter_prop["CODE"]."_to"]))
		{
			if (!empty($_REQUEST[$filter_prop["CODE"]."_from"]))
			$arFilterAjax[">=PROPERTY_".$filter_prop["CODE"]]=$_REQUEST[$filter_prop["CODE"]."_from"];
			
			if (!empty($_REQUEST[$filter_prop["CODE"]."_to"]))
			$arFilterAjax["<=PROPERTY_".$filter_prop["CODE"]]=$_REQUEST[$filter_prop["CODE"]."_to"];
		}
	}
}

$arFilterItems=array_merge($arFilterItems, $arFilterAjax);

if ($debug_search_filter)
{
	
	print_r($arFilterItems);
	
}
?>