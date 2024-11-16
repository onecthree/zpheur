<?php declare( strict_types = 1 );
namespace App\Console\Action\ErrorHandler;

use App\Service\Console\Input\InputArgument;
use Zpheur\Dependencies\ServiceLocator\Container;
use System\Core\Exception\ErrorException;
use App\Console\Abstract\BaseAction;


class ExceptionThrownAction extends BaseAction
{
    public function __construct( InputArgument &$input, Container &$container )
    {
        parent::__construct($input, $container);
    }

    public function __invoke( ErrorException $error ): int
    {
        switch( $error->hint )
        {
            case 127:
                echo "command: not found\n";
                return $this->exitCode($error->hint);
            break;
        }
    }
}