<?php declare( strict_types = 1 );
namespace App\Console\Exception;

use System\Core\Exception\ErrorException;
use App\Service\Http\Message\{ Request, Response };

class CommandNotFoundException extends ErrorException
{
    public function __construct( string $message, int $hint )
    {
        parent::__construct($message);
        $this->hint = $hint;
    }
}