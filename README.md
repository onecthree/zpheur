# Zpheur Skeleton Application
> ⚠️ Used only for non-production (untested and non-stable release)
 
Zpheur skeleton application for a new project.

## Installation
> Remember, you must install the [czpheur](https://github.com/onecthree/czpheur) extension before using this template.

To create new project via Composer:
```bash
$ composer create-project onecthree/zpheur new-project
```
## Basic Usage
As a personal project, the framework itself doesn't have many features yet. But for the first try, you can see the sample code on the controller ```app/Http/Action/IndexAction.php```:
```php
class IndexAction extends BaseAction
{
    public function __construct( Request $request, Response $response )
    {
        parent::__construct($request, $response);
    }

    #[Route\GET(dest: '/')]
    public function getIndex( Response $response ): Response
    {   
        return $response->send('Hello World');
    }
}
```
### Class autoloader
Zpheur using ```spl_autoloader``` for the class/function autoloader in the framework, for the example how namespacing model work, see bottom example:
```php
// In your project, all application things are located under "app" directory.
// Namespacing in path always begin with lower alphabet, like "app" and "system"
// but namespacing in PHP code always begin with upper alphabet, see "app/Http/Action/IndexAction.php":

<?php declare( strict_types = 1 );
namespace App\Http\Action;

class IndexAction ... {
}
// App\Http\Action will translate to directory path: "app/Http/Action"
// and the name of class controller will be the target class file: "IndexAction.php".
// So, it will require/call script name from "app/Http/Action/IndexAction.php".
```

### Router
For routing stuff, as above example code; Zpheur use attribute per-method in the class controller for route declaration. It support many HTTP verb, as next example:
```php
class ...
{
    #[Route\GET(dest: '/')]
    public function getIndex( Response $response ): Response
    {   
        return $response->send('Hello World');
    }

    #[Route\POST(dest: '/')]
    public function postIndex( Response $response ): Response
    {   
        return $response->send('Hello World');
    }

    // #[Route\PUT(dest: '/')]
    // #[Route\PATCH(dest: '/')]
    // #[Route\DELETE(dest: '/')]
    // #[Route\OPTIONS(dest: '/')]
}
```
### Compile controllers route
Zpheur router currently only supports precompiled routers, it's actually a cached array in ```system/var/cache/route/source.php``` file. After you create a new controller with route or new route in controllers, run the command under the root project directory to compile the routers:
```bash
$ php bin/console make:route
```

### Dotenv loader
By default, a first installation with Composer will include ```.env.example``` file; you must rename or copy the file to ".env". The Dotenv loader will check if file exists and will do a parsing ```.env``` and load the values use ```putenv()```. But before actually use the value from ```getenv()```, you must cache the ```.env``` file first:
```bash
$ php bin/console make:env
```