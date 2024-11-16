<?php declare( strict_types = 1 );

/**
 * ----------------------------------------------------------------
 * This file is part of Zpheur Framework.
 * (c) 2023 Zpheur Limited
 * 
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 * ----------------------------------------------------------------
 * 
 */


$path = APP_BASEPATH.'/system/var/cache/middleware/http.php';

$middleware = new Zpheur\Actions\Middleware(
    require file_exists($path) || touch($path) ? $path : 0
);

// You can set the global middleware without specific route or destination
/**
$middleware->setGlobalLists([
    [ App\Http\Middleware\WebMiddleware::class, [
        'user'  => 123,
        'foo'   => 456,
    ]],
]);
**/