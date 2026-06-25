<?
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("CustomSubmitForm_s1", "OnAfterIBlockElementAddHandler"));

class CustomSubmitForm_s1
{
	//    "OnAfterIBlockElementAdd"
	static function OnAfterIBlockElementAddHandler(&$arFields)
	{
		//  
		$arIBlockElement = GetIBlockElement($arFields["ID"]);

		if ($arIBlockElement["IBLOCK_CODE"]=="form_s1")
		{
			//    
			$props_fields='';

			foreach ($arIBlockElement['PROPERTIES'] as $key => $prop) {
				if($prop['VALUE']!=''){
					$props_fields.='<b>'.$prop['NAME'].':</b> '.$prop['VALUE'].'<br>';
				}
			}

			$arSend = array(
					'THEME' => $arIBlockElement['IBLOCK_NAME'],
					'TEXT' =>
					'<b>'.$arFields['NAME'].'</b><br/>'.
					($arFields['PREVIEW_TEXT']!='' ? $arFields['PREVIEW_TEXT'].'<br/>':'').
					$props_fields
			);
			
			CEvent::Send('SEND_FORM_s1',"s1",$arSend);
		}
	}
}


$siteTemplate = CSite::GetCurTemplate();
define("SITE_TEMPLATE_PATH", getLocalPath('templates/'.$siteTemplate, BX_PERSONAL_ROOT));
include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/design/settings_config.php');

if (!isset($settings_array["OPTION_CAPTCHA_SETTINGS_captha_point"]) || !$settings_array["OPTION_CAPTCHA_SETTINGS_captha_point"]>0) 
$captha_point="0.6";
else
$captha_point=$settings_array["OPTION_CAPTCHA_SETTINGS_captha_point"];

/*   re-captcha 3*/
if ($settings_array["OPTION_USE_CAPTCHA"]=="Y" && isset($settings_array["OPTION_CAPTCHA_SETTINGS_captha_key_secret"]) && isset($settings_array["OPTION_CAPTCHA_SETTINGS_captha_key"]))
{


	AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("reCaptcha_s1", "OnBeforeIBlockElementAddHandler"));
	class reCaptcha {
		static function OnBeforeIBlockElementAddHandler(&$arFields)
		{

			global $APPLICATION, $settings_array;


			//  
			$arIBlock = GetIBlock($arFields["IBLOCK_ID"]);

			if ($arIBlock["IBLOCK_TYPE_ID"] == "forms_s1")
			{
				global $APPLICATION;


				if ($_POST['recaptcha_response']=='')
				{
					$APPLICATION->throwException("reCAPTCHA");
					return false;
				}

				$recaptcha_url = '';
				$recaptcha_secret = $settings_array["OPTION_CAPTCHA_SETTINGS_captha_key_secret"];

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify?secret='.$recaptcha_secret.'&response='.$_POST['recaptcha_response']);
				curl_setopt($ch, CURLOPT_REFERER, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				$result = curl_exec($ch);
				curl_close($ch);


				$recaptcha = json_decode($result);
					
					
				if (isset($recaptcha->score) && $recaptcha->score<=$captha_point)
				{
					$APPLICATION->throwException("reCAPTCHA (".$recaptcha->score.")");
					return false;
				}


			}


		}
	}
}

?>