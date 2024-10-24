<?php declare( strict_types = 1 );
namespace App\Http\Abstract;

use Zpheur\Actions\Http\DefaultAction;
use Zpheur\Schemes\Http\Message\HeaderTrait;
use Zpheur\Schemes\Http\Message\HeaderInterface;
use Zpheur\Schemes\Http\Message\Response;

use App\Service\Http\Message\Request;

abstract class BaseAction extends DefaultAction
{   
    use HeaderTrait;

    protected mixed $request, $response, $query, $input, $cookies, $attributes, $server;
    protected mixed $responseData = null;

    protected function __construct( Request $request, Response $response )
    {
        $this->set(HeaderInterface::SERVER, 'Zpheur '.zpheur_version());
        
        $this->request = $request;
        $this->response = $response;
        $this->query = $request->query;
        $this->input = $request->input;
        $this->cookies = $request->cookies;
        $this->attributes = $request->attributes;
        $this->server = $request->server;
    }
}