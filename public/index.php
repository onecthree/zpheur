<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/**
 * ----------------------------------------------------
 * This file is part of Zpheur Framework.
 * (c) 2023 Zpheur Limited
 * 
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 * ----------------------------------------------------
 * 
 */

if( !extension_loaded('zpheur') )
    die('zpheur extension is not installed.' .PHP_EOL);

define('APP_ERROR_HANDLER', PHP_ERROR_HANDLER);
define('APP_BASEPATH', dirname(__DIR__));

require APP_BASEPATH. '/system/Kernel/Http.php';