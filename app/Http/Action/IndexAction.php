<?php declare( strict_types = 1 );
namespace App\Http\Action;

use App\Http\Abstract\BaseAction;
use App\Service\Http\Message\{ Request, Response };
use App\Http\Exception;
use App\Model\BlogPosts;

class IndexAction extends BaseAction
{
    public function __construct( Request $request, Response $response )
    {
        parent::__construct($request, $response);
    }

    #[Route\GET(dest: '/')]
    public function getIndex( Response $response ): Response
    {   
        return $response->send('Hello World');
    }
}