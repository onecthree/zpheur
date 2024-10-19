<?php declare( strict_types = 1 );

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

use Zpheur\Databases\Voile;

$voileDbState = new Voile(
[
    Voile::DB_URI   => env('MONGODB_URI'),
    Voile::DB_NAME  => env('MONGODB_NAME'),
]);