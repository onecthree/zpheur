<?php declare( strict_types = 1 );
namespace App\Http\Action\ErrorHandler;

use App\Service\Http\Message\{ Request, Response };
use System\Core\Exception\ErrorException;
use App\Http\Abstract\BaseAction;


class ExceptionThrownAction extends BaseAction
{
    public function __construct( Request $request, Response $response )
    {
        parent::__construct($request, $response);
    }

    public function __invoke( ErrorException $error, Response $response ): Response
    {
        switch( $error->hint )
        {
            case Response::HTTP_MOVED_PERMANENTLY:
                return $response
                    ->redirect($error->uri);
            break;
            case Response::HTTP_NOT_FOUND:
            case Response::HTTP_INTERNAL_SERVER_ERROR:
                return $response
                    ->statusCode($error->hint)
                    ->view('error_page/http_response', [
                        'httpResponseCode'  => $error->hint,
                        'uri'               => $this->server->get('REQUEST_URI'),
                    ]);
            break;   
        }
    }
}