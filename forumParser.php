<?php
/**
 * Created by PhpStorm.
 * User: Saymon
 * Date: 14.09.2019
 * Time: 19:20
 */

define('__ROOT_DIR__', __DIR__);
/** Добавил приглушение нотайсов, что б не мусорить в консоль. Приложение простое, не виду смысла добавлять кучу валидаций */
error_reporting(E_ERROR);

require_once __ROOT_DIR__ . '/vendor/autoload.php';

use src\Core\Parser\Parser;

echo 'Parse process has been started' . PHP_EOL;

$parser = new Parser();
$parser->parse();

echo 'Parsing successfully completed' . PHP_EOL;