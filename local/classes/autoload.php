<?php
use \Bitrix\Main\Loader;

// if(stripos($_SERVER['SCRIPT_NAME'], '1c_exchange.php') === false) require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/tools/ammina.stopvirus.php'; // «Ammina StopVirus: Защита от внедрения вирусов на сайт» https://marketplace.1c-bitrix.ru/solutions/ammina.stopvirus/

Loader::registerAutoLoadClasses(
    null,
    [
        '\WebLeopard\Toolkit' => '/local/classes/WebLeopard/Toolkit.php',
        '\WebLeopard\Project' => '/local/classes/WebLeopard/Project.php',
        '\WebLeopard\BaseEventHandlers' => '/local/classes/WebLeopard/BaseEventHandlers.php',
        '\WebLeopard\ProjectEventHandlers' => '/local/classes/WebLeopard/ProjectEventHandlers.php',
        '\WebLeopard\Agents' => '/local/classes/WebLeopard/Agents.php'
    ]
)
?>