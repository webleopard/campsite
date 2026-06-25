<?php
namespace WebLeopard;

use \Bitrix\Iblock\ElementTable;
use \Bitrix\Main\Application;
use \Bitrix\Main\Diag\Debug; // Debug::dumpToFile($arFields, 'arFields'); Debug::writeToFile($arFields, 'arFields'); Debug::dump($myYoutubeLink, '$myYoutubeLink');
use \Bitrix\Main\FileTable;
use \Bitrix\Main\Loader;

class Toolkit{

    public static $taggedCache;

    public static function getTaggedCache(){
        if (self::$taggedCache === null){
            self::$taggedCache = Application::getInstance()->getTaggedCache();
        }
        return self::$taggedCache;
    }

    public static function clearTaggedCache(string $tag){
        self::getTaggedCache()->clearByTag($tag);
    }

    public static function clearTaggedCacheIblock(int $id){
        self::getTaggedCache()->clearByTag('iblock_id_' . $id);
        // \Bitrix\Iblock\ElementTable::cleanCache(); // Данный вызов происходит при Add или Update элемента инфоблока. Возможно пригодится. 
    }

    public static function backupFile($baseFile, $baseDir = '/upload/backup/', $toRemove = false){
        $baseDir = (strpos($baseDir, $_SERVER['DOCUMENT_ROOT']) === 0) ? $baseDir : $_SERVER['DOCUMENT_ROOT'] . $baseDir;
        $baseFile = (strpos($baseFile, $_SERVER['DOCUMENT_ROOT']) === 0) ? $baseFile : $_SERVER['DOCUMENT_ROOT'] . $baseFile;
        $timestamp = microtime(true); // Имя архива с точностью до микросекунды
        $backupName = date('Y-m-d H:i:s', $timestamp) . sprintf('_%03d', ($timestamp - floor($timestamp)) * 1000) . '.zip';
        $backupFilePath = $baseDir . $backupName;

        if(!is_file($baseFile)) {
            self::logEvent("Файл {$baseFile} не существует. " . self::getCallerInfo(__FUNCTION__));
            return;
        }

        if(!is_dir($baseDir)) mkdir($baseDir, 0755, true);

        $obZip = new \ZipArchive;
        if ($obZip->open($backupFilePath, \ZipArchive::CREATE) === TRUE) {

            $obZip->addFile($baseFile, basename($baseFile));
            $obZip->close();

            if($toRemove) {
                unlink($baseFile);
                self::logEvent("Файл {$baseFile} добавлен в архив {$backupFilePath} и удалён");
            } else {
                self::logEvent("Файл {$baseFile} добавлен в архив {$backupFilePath}");
            }

        } else {
            self::logEvent("Ошибка при создании архива {$backupFilePath} для файла {$baseFile}");
        }
    }

    public static function checkFilesExistenceFromDB($isRemove = false){
        $arFiles = FileTable::getList([
            "select" => ["ID", "SUBDIR", "FILE_NAME"]
        ])->fetchAll();
        foreach($arFiles as $arFile){
            $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $arFile['SUBDIR'] . '/' . $arFile['FILE_NAME'];
            if(!file_exists($path)){
                self::logEvent("Не найден файл [ID={$arFile['ID']}] по пути {$path}", __FUNCTION__);
                if($isRemove){
                    \CFile::Delete($arFile['ID']);
                    self::logEvent("Ссылка на файл в БД c [ID={$arFile['ID']}] удалена", __FUNCTION__);
                }
            }
        }
    }

    // Генерирует все возможные непустые комбинации элементов из входного массива
    public static function generateCombinations($arr){
        $n = count($arr);
        $totalCombinations = 1 << $n;
        $arResult = [[]]; // Пустой результат то-же важен.

        for ($i = 1; $i < $totalCombinations; $i++) {
            $combination = [];
            for ($j = 0; $j < $n; $j++) {
                if ($i & (1 << $j)) {
                    $combination[] = $arr[$j];
                }
            }
            $arResult[] = $combination;
        }

        return $arResult;
    }
    
    public static function getCallerInfo($callerFunctionName, $positionInStack = 1){ // $positionInStack = 1, второй элемент в стеке т.к. debug_backtrace обёрнут в getCallerInfo
        $backtrace = debug_backtrace();
        $caller = $backtrace[$positionInStack];
        $callingFile = $caller['file'];
        $callingLine = $caller['line'];

        return "Функция {$callerFunctionName} была вызвана из файла: {$callingFile}, строка: {$callingLine}";
    }

    public static function getDirectorySize($baseDir){
        $baseDir = (strpos($baseDir, $_SERVER['DOCUMENT_ROOT']) === 0) ? $baseDir : $_SERVER['DOCUMENT_ROOT'] . $baseDir;
        $size = 0;
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($baseDir));
        foreach ($files as $file) {
            $size += $file->getSize();
        }
        return $size;
    }

    public static function getPhoneHrefFormat($input){
        // Удаляем все символы, кроме цифр и +
        $cleaned = preg_replace('/[^\d+]/', '', $input);

        // Проверяем, начинается ли строка с 7
        if (strlen($cleaned) > 0 && $cleaned[0] === '7') {
            $cleaned = '+' . $cleaned; // Добавляем +
        }
        return $cleaned;
    }

    public static function getUniqueElementCode($iblockId, $baseCode, $maxLen = 100){

        Loader::requireModule('iblock');

        $i = 0;
        $uniqueCode = $baseCode;

        while (ElementTable::getList(['filter' => ['IBLOCK_ID' => $iblockId, 'CODE' => $uniqueCode]])->fetch()) {

            $i++;
            $suffix = '_' . $i;
            $suffix_len = strlen($suffix);

            if(strlen($baseCode) > $maxLen - $suffix_len){
                $uniqueCode = substr($baseCode, 0, $maxLen - $suffix_len) . $suffix;
            }else{
                $uniqueCode = $baseCode . $suffix;
            }

        }

        return $uniqueCode;
        
    }

    public static function logEvent($message, $logFile = 'events', $maxLines = 1000, $baseDir = '/local/debug/logs/', $addToTop = false){
        // Полный путь к директории для логов
        $baseDir = (strpos($baseDir, $_SERVER['DOCUMENT_ROOT']) === 0) ? $baseDir : $_SERVER['DOCUMENT_ROOT'] . $baseDir;
        
        // Создаем директорию, если она не существует
        if(!is_dir($baseDir)) mkdir($baseDir, 0755, true);

        // Путь к лог-файлу
        $logFilePath = $baseDir . $logFile . '.log';

        // Добавляем время события с точностью до долей секунды
        $timestamp = microtime(true);
        $formattedTime = date('Y-m-d H:i:s', $timestamp) . sprintf('.%03d', ($timestamp - floor($timestamp)) * 1000);
        
        // Формируем строку логирования
        $logEntry = "[$formattedTime] $message" . PHP_EOL;

        // Читаем существующие строки из файла
        $lines = file_exists($logFilePath) ? file($logFilePath) : [];

        if($addToTop == true){
            // Добавляем новую запись сверху
            array_unshift($lines, $logEntry);

            // Ограничиваем количество строк в логе
            if (count($lines) > $maxLines) {
                $lines = array_slice($lines, 0, $maxLines);
            }
        }else{
            // Добавляем новую запись в конец
            array_push($lines, $logEntry);

            // Ограничиваем количество строк в логе
            if (count($lines) > $maxLines) {
                $lines = array_slice($lines, -$maxLines);
            }
        }

        // Записываем обратно в файл
        file_put_contents($logFilePath, implode('', $lines));
    }

    public static function removeOldFilesByLimit($baseDir, $max = 50, $format = 'zip'){
        $baseDir = (strpos($baseDir, $_SERVER['DOCUMENT_ROOT']) === 0) ? $baseDir : $_SERVER['DOCUMENT_ROOT'] . $baseDir;

        if (!is_dir($baseDir)) {
            self::logEvent("Директория {$baseDir} не существует. " . self::getCallerInfo(__FUNCTION__));
            return;
        }

        $format = $format ? ('.' . $format) : '';
        $files = array_filter(glob($baseDir . '/*' . $format), 'is_file');

        // Если файлов больше, чем задано
        if (count($files) > $max) {
            // Сортируем файлы по времени последнего изменения (старые первыми)
            usort($files, fn($a, $b) => filemtime($a) - filemtime($b));

            // Удаляем старые файлы, если их больше $max
            $filesToDelete = count($files) - $max;
            for ($i = 0; $i < $filesToDelete; $i++) {
                if (unlink($files[$i])) {
                    self::logEvent("Удалён старый файл: {$files[$i]}");
                } else {
                    self::logEvent("Ошибка при удалении файла: {$files[$i]}");
                }
            }
        }
    }

    public static function getStrFileSize($size, $round=2){
        $sizes = array('байт', 'Кб', 'Мб', 'Гб', 'Тб', 'Пб', 'Eb', 'Zb', 'Yb');
        for ($i=0; $size > 1024 && $i < count($sizes) - 1; $i++) $size /= 1024;
        return round($size,$round)." ".$sizes[$i];
    }

    public static function addNormalizedHyphenTokensForSearch(string $text){
        // ищем любые последовательности без пробелов, содержащие дефис
        if (preg_match_all('/\S*-\S*/u', $text, $matches)){
            $normalizedList = [];

            foreach ($matches[0] as $token){
                // убираем дефисы
                $normalized = str_replace('-', '', $token);

                // пропускаем мусор вроде "-"
                if ($normalized !== '' && $normalized !== $token){
                    $normalizedList[$normalized] = true; // без дублей
                }
            }

            if (!empty($normalizedList)){
                $text .= ' ' . implode(' ', array_keys($normalizedList));
            }
        }

        return $text;
    }

    /**
     * Удаляет визуальные дубликаты из массива элементов.
     *
     * @param array $items
     * @param string $pathKey Ключ, содержащий путь к изображению (например: SRC)
     * @param int $threshold Порог похожести (обычно 3-6)
     * 0      - только полностью идентичные изображения;
     * 1-3    - практически одинаковые (небольшое сжатие, метаданные, качество);
     * 4-6    - одинаковые "на глаз", рекомендуемое значение для каталога;
     * 7-10   - могут попадать похожие, но не всегда одинаковые изображения;
     * >10    - высокий риск ложных совпадений.
     *
     * @return array
     */
    public static function getUniqueItemsByImage(array $items, string $pathKey = 'SRC', int $threshold = 5): array
    {
        $uniqueItems = [];

        $pathHashes = [];
        $fileHashes = [];
        $imageHashes = [];

        foreach ($items as $item) {
            if (!is_array($item) || empty($item[$pathKey])) {
                continue;
            }

            $path = $item[$pathKey];
            $fullPath = self::preparePath($path);

            if (!$fullPath) {
                continue;
            }

            // Быстрая проверка по пути
            $pathHash = md5($path);
            if (isset($pathHashes[$pathHash])) {
                continue;
            }

            // Быстрая проверка по содержимому файла
            $fileHash = @md5_file($fullPath);
            if ($fileHash && isset($fileHashes[$fileHash])) {
                continue;
            }

            // Визуальный hash (дорогой этап)
            $currentHash = self::getDHash($fullPath);

            if (!$currentHash) {
                continue;
            }

            $isDuplicate = false;

            foreach ($imageHashes as $savedHash) {
                if (self::getHammingDistance($currentHash, $savedHash) <= $threshold) {
                    $isDuplicate = true;
                    break;
                }
            }

            if ($isDuplicate) {
                continue;
            }

            // Сохраняем все уровни хешей
            $pathHashes[$pathHash] = true;
            if ($fileHash) {
                $fileHashes[$fileHash] = true;
            }
            $imageHashes[] = $currentHash;

            $uniqueItems[] = $item;
        }

        return $uniqueItems;
    }

    private static function preparePath(string $path): ?string
    {
        if (mb_strpos($path, '/') === 0) {
            $path = $_SERVER['DOCUMENT_ROOT'] . $path;
        }

        if (!file_exists($path)) {
            return null;
        }

        return $path;
    }

    private static function getDHash(string $filePath): ?string
    {
        $content = @file_get_contents($filePath);

        if (!$content) {
            return null;
        }

        $source = @imagecreatefromstring($content);

        if (!$source) {
            return null;
        }

        $resized = imagecreatetruecolor(9, 8);

        imagecopyresampled(
            $resized,
            $source,
            0,
            0,
            0,
            0,
            9,
            8,
            imagesx($source),
            imagesy($source)
        );

        $pixels = [];

        for ($y = 0; $y < 8; $y++) {
            for ($x = 0; $x < 9; $x++) {
                $rgb = imagecolorat($resized, $x, $y);

                $r = ($rgb >> 16) & 255;
                $g = ($rgb >> 8) & 255;
                $b = $rgb & 255;

                $pixels[$y][$x] = (int)(($r + $g + $b) / 3);
            }
        }

        $hash = '';

        for ($y = 0; $y < 8; $y++) {
            for ($x = 0; $x < 8; $x++) {
                $hash .= ($pixels[$y][$x] > $pixels[$y][$x + 1]) ? '1' : '0';
            }
        }

        return $hash;
    }

    private static function getHammingDistance(string $hash1, string $hash2): int
    {
        $distance = 0;
        $length = strlen($hash1);

        for ($i = 0; $i < $length; $i++) {
            if ($hash1[$i] !== $hash2[$i]) {
                $distance++;
            }
        }

        return $distance;
    }

}
?>