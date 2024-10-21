<?php

/**
 * ----------------------------------------------------------------
 * This file is part of Zpheur Framework.
 * ----------------------------------------------------------------
 * 
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 * 
 * ----------------------------------------------------------------
 * (c) 2023 Zpheur Limited
 * ----------------------------------------------------------------
 * 
 */

use function Zpheur\Globals\is_appns;
use function Zpheur\Globals\clfile;

use App\Http\Exception\PageView\ForbiddenException;

use Zpheur\Schemes\Http\Routing\Dispatcher;
use Zpheur\Schemes\Http\Foundation\ParameterBag;
use Zpheur\Schemes\Http\Foundation\Kernel;
use Zpheur\Schemes\Http\Foundation\RouteKernel;
use Zpheur\Actions\Reflection\ActionResolver;
use Zpheur\Actions\Reflection\ArgumentResolver;
use Zpheur\Schemes\Http\Routing\Route;

use App\Http\Action\ErrorHandler\RequestNotFoundAction;
use App\Http\Action\ErrorHandler\ExceptionThrownAction;
use App\Service\Http\Message\Request;


define('APP_MICROTIME', microtime(true));

spl_autoload_register( function( string $className ) : void
{
    $clfile = APP_BASEPATH.DIRECTORY_SEPARATOR.clfile(class_name: $className). '.php';
    if( !class_exists($className) && file_exists($clfile) )
        require $clfile;
});

require APP_BASEPATH.'/system/Core/Dotenv/Dotenv.php';
require APP_BASEPATH.'/system/Core/Constant/Constant.php';
require APP_BASEPATH.'/system/Core/Datetime/Datetime.php';
require APP_BASEPATH.'/system/Core/Database/Voile/Model.php';
require APP_BASEPATH.'/system/Core/ServiceLocator/Container.php';
require APP_BASEPATH.'/system/Core/Middleware/Http.php';

try
{
    $dispatcher = new Dispatcher(require APP_BASEPATH.'/system/var/cache/route/source.php');
    $argumentResolver = new ArgumentResolver($container);
    $actionResolver = (new ActionResolver($middleware))
        ->withDefaultAction(RequestNotFoundAction::class, '__invoke');

    $kernel = new Kernel($dispatcher, $actionResolver, $argumentResolver);
    echo $kernel->handle($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
}
catch( \System\Core\Exception\ErrorException $error )
{   
    $container->set(\System\Core\Exception\ErrorException::class, $error);
    echo $kernel->terminate($error, ExceptionThrownAction::class, '__invoke');
}