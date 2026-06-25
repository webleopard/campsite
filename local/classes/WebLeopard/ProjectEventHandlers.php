<?php
namespace WebLeopard;

use \Bitrix\Main\Diag\Debug; // Debug::dumpToFile($arFields, 'arFields'); Debug::writeToFile($arFields, 'arFields'); Debug::dump($myYoutubeLink, '$myYoutubeLink');
use \Bitrix\Main\Loader;

class ProjectEventHandlers extends BaseEventHandlers{ // https://docs.1c-bitrix.ru/pages/orm/entity-operations.html

    public static function init(){

        parent::init();
        $eventManager = parent::getEventManager();
        
        $eventManager->addEventHandler('iblock', 'OnBeforeIBlockElementAdd', [self::class, 'OnBeforeIBlockElementAddHandler']);

    }

    public static function OnBeforeIBlockElementAddHandler(&$arFields){
        // Debug::writeToFile($arFields);
    }

}
// ---- START ---- Действие
// ---- STOP ----- Действие
?>