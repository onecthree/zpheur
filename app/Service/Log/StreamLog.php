<?php declare( strict_types = 1 );
namespace App\Service\Log;

use Zpheur\Logs\StreamLog as ZpheurStreamLog;
use Zpheur\Logs\StreamLog\Level;
use Zpheur\Logs\StreamLog\StreamHandler;

class StreamLog extends ZpheurStreamLog
{
    public function __construct()
    {
        parent::__construct('Zpheur');

        $infoHandler = (new StreamHandler(APP_BASEPATH.'/var/log/info.log', Level::INFO))
            ->datetimeObject((new \DateTime)->setTimeZone(new \DateTimeZone('Asia/Jakarta')))
            ->datetimeFormat('D, d M Y H:i:s T')
            ->setDelimiter(StreamHandler::DEFAULT_DELIMITER)
            ->setLogFormat('[%d] [%l] - %m');

        $warningHandler = (new StreamHandler(APP_BASEPATH.'/var/log/info.log', Level::WARNING))
            ->datetimeObject((new \DateTime)->setTimeZone(new \DateTimeZone('Asia/Jakarta')))
            ->datetimeFormat('D, d M Y H:i:s T')
            ->setDelimiter(StreamHandler::DEFAULT_DELIMITER)
            ->setLogFormat('[%d] [%l] - %m');

        $this->pushHandler($infoHandler);
        $this->pushHandler($warningHandler);
    }

    public function servicePin(): self
    {
        return $this;
    }
}