<?php declare( strict_types = 1 );
namespace App\Service\Http\Message;

use Zpheur\Schemes\Http\Message\Response as BaseResponse;
use Zpheur\Schemes\Http\Message\HeaderInterface;
use Zpheur\Files\Mime;

use App\Model\InternUsers;


class Response extends BaseResponse
{
    public int                  $responseCode = Response::HTTP_OK;
    public array                $viewParameters = [];
    public ?InternUsers         $internUser = null;

    public function servicePin(): self
    {
        return $this;
    }

    public function setViewParameter( string $name, mixed $value ): void
    {
        $this->viewParameters[$name] = $value;
    }

    public function auth( bool $check ): bool | InternUsers
    {
        if( $check )
            return $this->internUser ? true : false;

        return $this->internUser;
    }

    public function view( string $fileview, array $parameters = [] ): self
    {
        $this->viewParameters =
            array_merge($this->viewParameters, $parameters);

        $view = APP_BASEPATH."/app/Views/$fileview.phtml";  

        foreach( $this->viewParameters as $name => $value )
            ${$name} = $value;

        ob_clean();
        ob_start();
        require $view;
        $this->output_buffer = ob_get_clean();
        
        return $this;
    }

    public function json( array $data ): self
    {
        return $this
            ->set(HeaderInterface::CONTENT_TYPE, Mime::JSON)
            ->send(json_encode($data));
    }
}