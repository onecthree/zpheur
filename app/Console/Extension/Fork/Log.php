<?php declare( strict_types = 1 );
namespace App\Console\Extension\Fork;

class Log
{
    public function __construct(
        protected string $logPath,
    )
    {
        //
    }

    public function __invoke( string $message)
    {
        file_put_contents($this->logPath, $message);
    }

    public function exit(): void
    {
        unlink($this->logPath);
    }
}