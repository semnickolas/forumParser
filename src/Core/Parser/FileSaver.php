<?php

namespace src\Core\Parser;

/**
 * Class FileSaver
 * @package src\Core\Parser
 */
class FileSaver
{
    private const DATA_PATH = __ROOT_DIR__ . '/parsedData/';
    private const FILE_DATA_KEYS = ['postTitle', 'author', 'date', 'text'];

    /**
     * @param array $postData
     */
    public function save(array $postData): void
    {
        $file = fopen(self::DATA_PATH . $postData['fileName'], 'wb');

        foreach (self::FILE_DATA_KEYS as $key) {
            fputcsv($file, [$postData[$key]]);
        }

        fclose($file);
    }
}