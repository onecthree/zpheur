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

    protected $request;
    protected $response;
    protected $query;
    protected $input;
    protected $cookies;
    protected $attributes;
    protected $server;

    protected $prefixView = 'extern';

    protected mixed $responseData = null;

    protected function __construct( Request $request, Response $response )
    {
        $zpheurVersion = 'v1.0';
        $this->set(HeaderInterface::SERVER, "Zpheur $zpheurVersion");
        
        $this->request = $request;
        $this->response = $response;
        $this->query = $request->query;
        $this->input = $request->input;
        $this->cookies = $request->cookies;
        $this->attributes = $request->attributes;
        $this->server = $request->server;

        $response->setViewParameter('auth', 'ini auth dari base');
    }

    protected function prefixViewTo( string $dest ): string
    {
        return "{$this->prefixView}/$dest";
    }
}