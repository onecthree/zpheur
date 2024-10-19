<?php declare( strict_types = 1 );
namespace App\Http\Exception\Http;

use \System\Core\Exception\ErrorException as BaseErrorException;


class HttpRedirectException extends BaseErrorException
{
    public string $uri;

    public function __construct( string $uri, int $hint )
    {
        parent::__construct(EMPTY_STRING);

        $this->uri = $uri;
        $this->hint = $hint;
    }
}