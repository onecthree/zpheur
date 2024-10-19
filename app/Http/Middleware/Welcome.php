<?php declare( strict_types = 1 );
namespace App\Http\Middleware;

use App\Service\Http\Message\Response;
use Zpheur\Schemes\Http\Middleware;

class Welcome
{
    public string $view = 'welcome';

    public function __invoke( Response $response, Middleware\Next $next )
    {
        $response->viewName = $this->view;
        return $next();
    }
}