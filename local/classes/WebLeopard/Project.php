<?php
namespace WebLeopard;

use \Bitrix\Iblock\ElementPropertyTable;
use \Bitrix\Main\Diag\Debug; // Debug::dumpToFile($arFields, 'arFields'); Debug::writeToFile($arFields, 'arFields'); Debug::dump($myYoutubeLink, '$myYoutubeLink');
use \Bitrix\Main\Loader;
use \Bitrix\Main\Web\Json;

class Project extends Toolkit{

    protected const LAST_DECIDE_PROP = 0; // Последнее свойство решения
    protected const USELESS_GROUP_ID = 0; // Группа «Не использовать» для новых цен.
    public const CATALOG_ID = 0; // Торговый каталог
    public const HIT_PROP_HIT_VALUE = 0; // Наши предложения - значение "Хит"
    public const HIT_PROP_ID = 0; // Наши предложения

}
?>