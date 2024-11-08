<?php declare( strict_types = 1 );
namespace App\Console\Action\Make;

use function Zpheur\Globals\filetoclass;

use Zpheur\Schemes\Http\Routing\Route;
use App\Service\Console\Input\InputArgument;
use Zpheur\Dependencies\ServiceLocator\Container;
use App\Console\Abstract\BaseAction;


class RouteAction extends BaseAction
{
	public function __construct( InputArgument &$input, Container &$container )
	{
        parent::__construct($input, $container);
	}

	private function findActionFiles( string $directoryBegin, array &$actionFiles = [] ): array
	{
		foreach( scandir($directoryBegin) as $currentFile )	
		{
			if(! str_starts_with($currentFile, '.') )
			{
				$pathOfFile = $directoryBegin.DIRECTORY_SEPARATOR.$currentFile;

				if( !is_dir($pathOfFile) )
				{
					if( preg_match('/Action\.php$/', $pathOfFile) )
					{
						$actionFiles []= $pathOfFile;
					}
					
					continue;
				}

				$this->findActionFiles($pathOfFile, $actionFiles);
			}
		}

		return $actionFiles;
	}

	private function printRouteVerb( string $verb ): string
	{
		return match( $verb )
		{
			'GET' 		=> "\e[1m\e[31m GET \e[0m.....",
			'POST' 		=> "\e[1m\e[32m POST \e[0m....",
			'PUT' 		=> "\e[1m\e[33m PUT \e[0m.....",
			'PATCH' 	=> "\e[1m\e[34m PATCH \e[0m...",
			'DELETE' 	=> "\e[1m\e[35m DELETE \e[0m..",
			'OPTIONS' 	=> "\e[1m\e[36m OPTIONS \e[0m.",
			default  	=> "\e[1m\e[37m UKNOWN \e[0m..",
		};
	}

	public function __invoke( int $argc, string $command, array $flags ): int
	{
		$actionFilesSaved = [];
		$actionRoutesSaved = 0;

		$route = (new Route)->setCacheFilepath(
			route: APP_BASEPATH.'/system/var/cache/route/source.php',
			middleware: APP_BASEPATH.'/system/var/cache/middleware/http.php',
		);
			
		foreach( $this->findActionFiles(APP_BASEPATH.'/app/Http/Action') as $markAtActionFilename => $file )
		{
			$className = filetoclass($file) ?? '';
			$classReflection = new \ReflectionClass($className);
			$globalMiddleware = [];

			// Iterate all attributes given in class action
			foreach( $classReflection->getAttributes() as $attributeReflection )
			{
				$attributeName = $attributeReflection->getName();
				switch( true )
				{
					case preg_match('/Middleware$/', $attributeName):
						$arguments = $attributeReflection->getArguments();
						$globalMiddleware []= [
							'dest'	=> $arguments['dest'],
							'param' => array_filter(
								$arguments,
								fn( string $key ) => !in_array($key, ['dest']),
								ARRAY_FILTER_USE_KEY
							),
						];
					break;
				}
			}
			
			// Iterate all attributes given in class action method's
			foreach( $classReflection->getMethods() as $methodReflection )
			{
				$methodName = $methodReflection->getName();
				$attributes = $methodReflection->getAttributes();
				$middleware = $globalMiddleware;

				if(! $attributes )
					continue;

				foreach( $attributes as $attributeReflection )
				{ 
					$attributeName = $attributeReflection->getName();
					$arguments = $attributeReflection->getArguments();
					$routeVerbStringable = null;
					$routeVerb = null;

					switch( true )
					{
						case preg_match("/(\\\\Route|^Route)\\\\(GET|POST|PUT|PATCH|DELETE|OPTIONS)$/",
						$attributeName, $matches):
							$routeVerbStringable = $matches[2] ?? null;
							$routeVerb = Route::tryVerbFromString($routeVerbStringable);
						break;
						case preg_match('/Middleware$/', $attributeName):
							$middleware []= [
								'dest'	=> $arguments['dest'],
								'param' => array_filter(
									$arguments,
									fn( string $key ) => !in_array($key, ['dest']),
									ARRAY_FILTER_USE_KEY
								),
							];
						break;
					}

					if( $routeVerb )
					{
						$route->add($routeVerb, $arguments['dest'],
							action:	[
								$classReflection->getName(),
								$methodReflection->getName(),
							]
						);

						$actionFilesSaved[$markAtActionFilename] = 1;
						$actionRoutesSaved += 1;
						
						printf("{$this->printRouteVerb($routeVerbStringable)} {$className}::{$methodName}\n");
					}
				}

				if( $middleware )
					$route->middleware($middleware);
			}
		}
		$route->save();

		echo 'OK.'.PHP_EOL;
		return $this->exitCode(0);
	}
}