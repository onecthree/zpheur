<?php declare( strict_types = 1 );
namespace App\Service\Console\Input;

use Zpheur\Consoles\Input\InputArgument as BaseInputArgument;

class InputArgument extends BaseInputArgument
{
    public function __construct( int $argc, array $argv )
    {
        parent::__construct($argc, $argv);
    }

    public function servicePin(): self
    {
        return $this;
    }
}