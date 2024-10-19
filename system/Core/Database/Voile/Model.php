<?php declare( strict_types = 1 );
namespace Core\Database\Voile;

use Zpheur\Databases\Voile\Model as Voile;

class Model extends Voile
{
    public function __construct()
    {
        parent::__construct(
            dbUri: getenv('MONGODB_URI'),
            dbName: getenv('MONGODB_NAME'),
        );
    }
}