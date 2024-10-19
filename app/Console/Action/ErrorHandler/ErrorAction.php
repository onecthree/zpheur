<?php declare( strict_types = 1 );
namespace App\Console\Action\ErrorHandler;

use App\Console\Abstract\BaseAction;
use App\Console\Middleware\CommandNotFound;
use App\Console\Middleware\Session;
use App\Service\Console\Input\InputArgument;

use Zpheur\Dependencies\ServiceLocator\Container;

use App\Console\Extension\Fork;


class ErrorAction extends BaseAction
{
    public function __construct( InputArgument &$input, Container &$container )
    {
        parent::__construct($input, $container);
    }
    
    public function __invoke( string $command, int $argc ): int
    {   
        echo "command: not found\n";
        return $this->exitCode(127);
    }
}