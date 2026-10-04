<?php
use \WebLeopard\ProjectEventHandlers;

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/cpanel/include.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/classes/autoload.php';

ProjectEventHandlers::init();
?>