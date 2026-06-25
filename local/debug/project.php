<?php
namespace WebLeopard;

use \Bitrix\Main\Diag\Debug; // Debug::dumpToFile($arFields, 'arFields'); Debug::writeToFile($arFields, 'arFields'); Debug::dump($myYoutubeLink, '$myYoutubeLink');
use \Bitrix\Main\Loader;

// ---- START ---- Строки для подключения bitrix и выполнения без вывода шаблона
define('STOP_STATISTICS', true);
define("SITE_TEMPLATE_ID", null); // Запретить применение шаблона. Что-бы не сработали события шаблона, например в решениях Aspro
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$GLOBALS['APPLICATION']->RestartBuffer();
// ---- STOP ----- Строки для подключения bitrix и выполнения без вывода шаблона

// ---- START ---- Ограничение доступа
// if (!$GLOBALS['USER']->IsAdmin() && $GLOBALS['USER']->GetID() != 2){ http_response_code(403); die('Access Denied');}
if (!$GLOBALS['USER']->IsAdmin()){ http_response_code(403); die('Access Denied');}
// ---- STOP ----- Ограничение доступа
// getList [select, filter, group, order, limit, offset, count_total, runtime, data_doubling, private_fields, cache]
// $timeDebug_start = microtime(true); $timeDebug = microtime(true) - $timeDebug_start; Debug::writeToFile($timeDebug, 'timeDebug');

Debug::startTimeLabel("Full");

class Project_debug extends Project{

    public static function setExample(){

        Loader::requireModule('catalog');
        Loader::requireModule('iblock');
    
    }

}

// Project_debug::setExample();

Debug::endTimeLabel("Full");

Debug::dump(Debug::getTimeLabels());
?>