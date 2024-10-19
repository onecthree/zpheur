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

$middleware = new Zpheur\Schemes\Http\Middleware(require APP_BASEPATH.'/system/var/cache/middleware/console.php');
// $middleware->setGlobalLists([
//     [ App\Console\Middleware\Web::class, [
//         'user'  => 123,
//         'foo'   => 456,
//     ]],
// ]);