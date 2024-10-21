<?php

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


use function Zpheur\Globals\is_appns;
use function Zpheur\Globals\clfile;

use Zpheur\Consoles\Runtime\Application;
use Zpheur\Actions\Reflection\ActionResolver;
use Zpheur\Actions\Reflection\ArgumentResolver;

use App\Service\Console\Input\InputArgument;
use App\Console\Action\ErrorHandler\ErrorAction;


define('APP_MICROTIME', microtime(true));

spl_autoload_register( function( string $className ) : void
{
    if( !class_exists($className) && is_appns($className) &&
    file_exists($clfile = APP_BASEPATH.DIRECTORY_SEPARATOR.clfile($className). '.php') )
    {
        require $clfile;
    }
});

require APP_BASEPATH.'/system/Core/Dotenv/Dotenv.php';
require APP_BASEPATH.'/system/Core/Constant/Constant.php';
require APP_BASEPATH.'/system/Core/Datetime/Datetime.php';
require APP_BASEPATH.'/system/Core/Database/Voile/Model.php';
require APP_BASEPATH.'/system/Core/ServiceLocator/Container.php';
require APP_BASEPATH.'/system/Core/Middleware/Console.php';

try
{
    $argumentResolver = new ArgumentResolver($container);
    $actionResolver = (new ActionResolver($middleware))
        ->withDefaultAction(ErrorAction::class, '__invoke')
        ->staticMiddlewareCall(true);

    $inputArgument = new InputArgument($argc, $argv);
    $container->set(InputArgument::class, $inputArgument);
    $application = (new Application($inputArgument, $actionResolver, $argumentResolver))
        ->withBaseNamespace('App\Console\Action');

    $application->run();
}
catch( \Exception )
{

}

defined('EXIT_CODE') or define('EXIT_CODE', 0);
exit(EXIT_CODE);