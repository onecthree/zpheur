<?php declare( strict_types = 1 );
namespace App\Console\Action\ErrorHandler;

use App\Console\Abstract\BaseAction;
use App\Console\Exception\CommandNotFoundException;
use App\Service\Console\Input\InputArgument;
use Zpheur\Dependencies\ServiceLocator\Container;


class CommandNotFoundAction extends BaseAction
{
    public function __construct( InputArgument &$input, Container &$container )
    {
        parent::__construct($input, $container);
    }

    public function __invoke( string $command, int $argc )
    {
        throw new CommandNotFoundException(
            message: 'Command not found',
            hint: 127,
        );
    }
}