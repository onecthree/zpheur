<?php declare( strict_types = 1 );
namespace Core\Database\Phase;

use Zpheur\Databases\Phase\Model as Phase;
use function Zpheur\DataTransforms\Dotenv\env;

class Model extends Phase
{
    public function __construct()
    {
        parent::__construct(
            name:       env('MYSQL_NAME'),
            host:       env('MYSQL_HOST'),
            username:   env('MYSQL_USERNAME'),
            password:   env('MYSQL_PASSWORD'),
        );
    }
}