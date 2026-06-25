<?php
namespace WebLeopard;

use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Diag\Debug; // Debug::dumpToFile($arFields, 'arFields'); Debug::writeToFile($arFields, 'arFields'); Debug::dump($myYoutubeLink, '$myYoutubeLink');
use \Bitrix\Main\EventManager;
use \Bitrix\Main\Page\Asset;

class BaseEventHandlers extends Project{

    protected static $eventManager;

    protected static function getEventManager() {
        if (self::$eventManager === null){
            self::$eventManager = EventManager::getInstance();
        }
        return self::$eventManager;
    }

    public static function init(){

        $eventManager = self::getEventManager();

        $eventManager->addEventHandlerCompatible('iblock', 'OnBeforeIBlockUpdate', [self::class, 'OnBeforeIBlockUpdateHandlerBase']);
        $eventManager->addEventHandlerCompatible('iblock', 'OnBeforeIBlockPropertyAdd', [self::class, 'OnBeforeIBlockPropertyAddHandlerBase']);
        $eventManager->addEventHandlerCompatible('iblock', 'OnBeforeIBlockPropertyUpdate', [self::class, 'OnBeforeIBlockPropertyUpdateHandlerBase']);
        $eventManager->addEventHandlerCompatible('iblock', 'OnBeforeIBlockPropertyDelete', [self::class, 'OnBeforeIBlockPropertyDeleteHandlerBase']);
        $eventManager->addEventHandlerCompatible('catalog', 'OnBeforeGroupAdd', [self::class, 'OnBeforeGroupAddHandlerBase']);
        $eventManager->addEventHandlerCompatible('main', 'OnBeforeEndBufferContent', [self::class, 'OnBeforeEndBufferContentHandlerBase']);
        $eventManager->addEventHandlerCompatible('main', 'OnBeforeEventSend', [self::class, 'OnBeforeEventSendHandlerBase']);
        $eventManager->addEventHandlerCompatible('sale', 'OnBeforeUserAccountAdd', [self::class, 'OnBeforeUserAccountAddHandlerBase']);

    }

    public static function OnBeforeIBlockUpdateHandlerBase(&$arFields){
        if($_GET['mode'] == 'import'){
            $arFields['NAME'] = null;
            $arFields['DESCRIPTION'] = null;
            $arFields['CODE'] = null;
        }
    }

    public static function OnBeforeIBlockPropertyAddHandlerBase(&$arFields){
        if($_GET['mode'] == 'import'){
            $arFields['SORT'] = 10000; // Всем новым свойствам из 1С задавать сортировку 10000
        }
    }

    public static function OnBeforeIBlockPropertyUpdateHandlerBase(&$arFields){
        if($_GET['mode'] == 'import'){
            $arFields['NAME'] = null;
            $arFields['CODE'] = null;
            $arFields['DISPLAY_TYPE'] = null;
            if($arFields['PROPERTY_TYPE'] != 'L') $arFields['PROPERTY_TYPE'] = null; // Запретить изменять типы свойств, кроме списка. Т.к. для списка плохие значения будут.
        }
    }

    public static function OnBeforeIBlockPropertyDeleteHandlerBase($Id){
        global $APPLICATION;
        if($Id <= self::LAST_DECIDE_PROP){
            $APPLICATION->throwException("Свойство с ID={$Id} нельзя удалить. Т.к. это свойство решения.");
            return false;
        }
    }

    public static function OnBeforeGroupAddHandlerBase(&$arFields){
        if($_GET['mode'] == 'import' && self::USELESS_GROUP_ID > 0){
            $arFields['USER_GROUP'] = [self::USELESS_GROUP_ID];
            $arFields['USER_GROUP_BUY'] = [self::USELESS_GROUP_ID];
        }
    }

    public static function OnBeforeEndBufferContentHandlerBase(){
        // ---- START ---- Удаление элементов из визуального редактора
        // https://dev.1c-bitrix.ru/api_help/js_lib/kernel/castom_events/bx_addcustomevent.php
        Asset::getInstance()->addString('<script>BX.addCustomEvent("GetControlsMap", BX.delegate(function(buttonsList){buttonsList.forEach(function(item, i){if(item["id"] === "FontSelector" || item["id"] === "FontSize" || item["id"] === "Underline" || item["id"] === "Color"){buttonsList.splice(i, 1);}});}, this));</script>', true);
        // ---- STOP ----- Удаление элементов из визуального редактора
    }

    public static function OnBeforeEventSendHandlerBase(&$arFields, &$arTemplate){
        $baseEmail = Option::get('main', 'email_from');
        if($baseEmail){
            $arTemplate['EMAIL_FROM'] = $baseEmail; // Отправитель по умолчанию из главного модуля. Важно для SMTP. Должно совподать с настройками SMTP
        }
        // $arTemplate['REPLY_TO'] = '#DEFAULT_EMAIL_FROM#'; // Почта для ответа из настроек сайта
    }

    // ---- START ---- Запрет на создание внутреннего счёта
    // https://dev.1c-bitrix.ru/community/forums/messages/forum6/topic39591/message593969/#message593969, https://bxapi.ru/src/?module_id=sale&name=CSaleUserAccount::Add
    // Нужно ещё настроить компонент bitrix:sale.personal.section
    // "SHOW_ACCOUNT_COMPONENT" => "N", "SHOW_ACCOUNT_PAGE" => "N", "SHOW_ACCOUNT_PAY_COMPONENT" => "N", // "account" => "account/", (Последнее закомментировать)
    public static function OnBeforeUserAccountAddHandlerBase(&$arFields){
        return false;
    }
    // ---- STOP ----- Запрет на создание внутреннего счёта

}
?>