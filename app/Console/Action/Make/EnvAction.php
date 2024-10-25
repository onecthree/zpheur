<?php declare( strict_types = 1 );
namespace App\Console\Action\Make;

use App\Service\Console\Input\InputArgument;
use Zpheur\Dependencies\ServiceLocator\Container;
use App\Console\Abstract\BaseAction;
use Zpheur\DataTransforms\Dotenv\Dotenv;


class EnvAction extends BaseAction
{
    public function __construct( InputArgument &$input, Container &$container )
	{
        parent::__construct($input, $container);
	}

    public function __invoke(): int
    {
        $cache = APP_BASEPATH.'/system/var/cache/env/source.php';
        $dotenv = (new Dotenv(APP_BASEPATH.'/.env'))
            ->parse(true, true)
            ->serialize($cache);

        echo 'OK.'.PHP_EOL;
        return $this->exitCode(0);
    }
}