<?php declare( strict_types = 1 );

use Zpheur\DataTransforms\Dotenv\Dotenv;

$cache = APP_BASEPATH.'/system/var/cache/env/source.php';
$dotenv = (new Dotenv(APP_BASEPATH.'/.env'))
    ->unserialize(
    data: !is_readable($cache) ?: require $cache,
    callback:
        fn( string $name, string $value )    
            => putenv("$name=$value")
    );