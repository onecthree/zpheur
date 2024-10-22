<?php declare( strict_types = 1 );
namespace App\Http\Action\ErrorHandler;

use App\Http\Abstract\BaseAction;
use App\Service\Http\Message\Response;
use App\Http\Exception\HttpNotFoundException;


class RequestNotFoundAction extends BaseAction
{
    public function __invoke( Response $response )
    {
        throw new HttpNotFoundException(
            message: 'Not found route request income',
            hint: Response::HTTP_NOT_FOUND,
        );
    }
}