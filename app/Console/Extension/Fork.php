<?php declare( strict_types = 1 );
namespace App\Console\Extension;

use App\Console\Extension\Fork\Log;

class Fork
{
    public static function run( \Closure $call, \Closure $parent, ?int &$pid )
    {
        $pid = pcntl_fork();
        $logPath = APP_BASEPATH.'/system/var/log/'.APP_MICROTIME.'.log';
        $exPath = APP_BASEPATH.'/system/var/log/ex_'.APP_MICROTIME;

        register_shutdown_function( function() use( $logPath, $exPath )
        {
            if( error_get_last() )
            {
                if( file_exists($logPath) )
                    unlink($logPath);
                else
                    file_put_contents($exPath, 0);
            }
        });

        switch( $pid )
        {
            case -1:
                return true;
            break;
            case 0: // child
                $call(new Log($logPath));   
                unlink($logPath);
            break;  
            default: // parent
                $parent($logPath);
                pcntl_wait($status); 
            break;
        }
            
        return false;
    }
}