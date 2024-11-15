<?php declare( strict_types = 1 );
namespace App\Console\Abstract;

use Zpheur\Actions\Console\DefaultAction;
use App\Service\Console\Input\InputArgument;
use Zpheur\Dependencies\ServiceLocator\Container;

class BaseAction extends DefaultAction
{
    public function __construct( InputArgument &$input, Container &$container )
    {
        parent::__construct();

        $input->shiftArgument();

        $container->set('argc', $input->count, true);
        $container->set('command', $input->getValue(0) ?? '', true);
        $container->set('flags', array_filter(
            $input->value, fn( $key ) => $key, ARRAY_FILTER_USE_KEY
        ), true);
    }

    protected function info( string $text ): void
    {
        echo "\e[44m\e[1m\e[37m  INFO  \e[0m \e[1m$text\e[0m\n";
    }

    protected function line( string $text, bool $breakline = true ): void
    {
        echo $text.($breakline ? PHP_EOL : '');
    }
    
    protected function newline( int $repeat = 1 ): void
    {
        echo str_repeat(PHP_EOL, $repeat);
    }

    protected function list( string $text ): void
    {
        echo "  • $text\n";
    }
}