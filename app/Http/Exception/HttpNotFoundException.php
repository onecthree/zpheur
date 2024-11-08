<?php declare( strict_types = 1 );
namespace App\Http\Exception;

use System\Core\Exception\ErrorException;
use App\Service\Http\Message\{ Request, Response };

class HttpNotFoundException extends ErrorException
{
    public function __construct( string $message, int $hint )
    {
        parent::__construct($message);
        $this->hint = $hint;
    }
}