<?php declare( strict_types = 1 );
namespace System\Core\Exception;

use Exception, Throwable;


class ErrorException extends Exception implements Throwable
{
    public int $hint = 200;

    public function __construct( string $message = 'asd', int $code = 0, ?Throwable $previous = null )
    {
        parent::__construct($message);
    }
}