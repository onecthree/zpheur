<?php declare( strict_types = 1 );
namespace App\Console\Action;

use App\Console\Abstract\BaseAction;
use Zpheur\Schemes\Http\Routing\Route;


class CacheAction extends BaseAction
{
	public function csrf()
	{
        $path = APP_BASEPATH.getenv('CSRF_TOKEN_FILECACHE_PATH');
        foreach( glob($path.'*') as $cache )
            unlink($cache);
	}

    public function log(): void
    {
        $path = APP_BASEPATH.getenv('LOG_FILECACHE_PATH');
        foreach( glob($path.'*') as $cache )
            unlink($cache);
    }

    public function static(): void
    {
        $path = APP_BASEPATH.getenv('STATIC_FILECACHE_PATH');
        foreach( glob($path.'*') as $cache )
            unlink($cache);
    }
}