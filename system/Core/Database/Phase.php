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

use Zpheur\Databases\Phase;

$phaseDbState = new Phase([
    Phase::DB_HOST      => getenv('SQLDB_HOST'),
    Phase::DB_PORT      => getenv('SQLDB_PORT'),
    Phase::DB_USERNAME  => getenv('SQLDB_USERNAME'),
    Phase::DB_PASSWORD  => getenv('SQLDB_PASSWORD'),
    Phase::DB_NAME      => getenv('SQLDB_NAME'),
    Phase::DB_DRIVER    => Phase::SQL_DRIVER_MYSQL,
]);