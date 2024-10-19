<?php declare( strict_types = 1 );
namespace App\Service\Http\Message;

use Zpheur\Schemes\Http\Foundation\Request as BaseRequest;
use Zpheur\Schemes\Http\Foundation\ParameterBag;
use Zpheur\Dependencies\ServiceLocator\Container;

class Request extends BaseRequest
{
    public function __construct()
    {
        global $container;
        
        parent::__construct($_POST, $_GET, $_COOKIE, [], $_FILES, $_SERVER);

        $this->setPayload();

        $container->set('postData', $this->input->all(), true);
    }

    protected function setPayload()
    {
        $contentType = $this->headers->get('CONTENT_TYPE');
        if(! preg_match('/application\/x-www-form-urlencoded|multipart\/form-data/i', $contentType ?? '') )
        {
            if( preg_match('/application\/json/i', $contentType ?? '') )
            {
                $payload = file_get_contents('php://input');
                $deserialized = json_decode($payload, true);

                if( json_last_error() === JSON_ERROR_NONE )
                {
                    $this->input = new ParameterBag($deserialized);
                }
            }
        }
    }

    public function servicePin(): self
    {
        return $this;
    }
}