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

use function Zpheur\Globals\clfile;

use Zpheur\Schemes\Http\Routing\Dispatcher;
use Zpheur\Schemes\Http\Foundation\Kernel;
use Zpheur\Actions\Reflection\ActionResolver;
use Zpheur\Actions\Reflection\ArgumentResolver;

use App\Http\Action\ErrorHandler\RequestNotFoundAction;
use App\Http\Action\ErrorHandler\ExceptionThrownAction;
use System\Core\Exception\ErrorException;


define('APP_MICROTIME', microtime(true));

spl_autoload_register( static function( string $className ) : void
{
    $classFileTarget = APP_BASEPATH.DIRECTORY_SEPARATOR.clfile(class_name: $className). '.php';
    if( !class_exists($className) && file_exists($classFileTarget) )
        require $classFileTarget;
});

require APP_BASEPATH.'/system/Core/Dotenv/Dotenv.php';
require APP_BASEPATH.'/system/Core/Constant/Constant.php';
require APP_BASEPATH.'/system/Core/Datetime/Datetime.php';
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
catch( ErrorException $error )
{   
    $container->set(ErrorException::class, $error);
    echo $kernel->terminate($error, ExceptionThrownAction::class, '__invoke');
}