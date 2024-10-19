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

$container = new Zpheur\Dependencies\ServiceLocator\Container();

/**
 * Use global definer for before request catch-up
 *  
    $container->withDefaultScalarsValue([
        string  => '',
        int     => 0,
    ]);
*/