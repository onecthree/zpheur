<?php declare( strict_types = 1 );
namespace App\Service\Cache\Adapter;

use Zpheur\Caches\Adapter\Filesystem as FileSystemAdapter;

class Filesystem extends FileSystemAdapter
{
    public function __construct()
    {
        parent::__construct('static', 0, APP_BASEPATH.'/var/cache');
        $this->datetimeObject(
            (new \DateTime)->setTimezone((new \DateTimeZone("Asia/Jakarta")))
        );
    }

    public function servicePin(): self
    {
        return $this;
    }
}