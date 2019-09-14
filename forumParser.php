<?php
/**
 * Created by PhpStorm.
 * User: Saymon
 * Date: 14.09.2019
 * Time: 19:20
 */

define('__ROOT_DIR__', __DIR__);

require_once './vendor/autoload.php';
require_once './src/Core/Authenticator.php';

use src\Core\Authenticator;

$authenticator = new Authenticator();

$authenticator->authenticate();