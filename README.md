# Project Argon (Name TBD)

## Installation

Create a folder and inside, create a basic Laravel (**5.1.0**) project:

```
composer create-project laravel/laravel . "~5.1.0" --prefer-dist
```

Add a repositories section to the **composer.json**:

```
"repositories": [
{
    "type": "vcs",
    "url": "git@bitbucket.org:theescape/project-argon.git"
}]
```

If the composer.json does not already have a minimum stability and prefer stable set, add the following as well:

```
"minimum-stability": "dev",
"prefer-stable": true
```

Run the following to install the base CMS:

```
composer require escape/argon
```
### Files


Replace **app/Http/Controllers/Controller.php** content with:
```
<?php

namespace App\Http\Controllers;

use Escape\Argon\Frontend\Controllers\CmsController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends CmsController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

```
Create **app/Http/Controllers/ContentController.php** and add:
```
<?php

namespace App\Http\Controllers;

use App\Helpers\ThemeHelper;
use Escape\Argon\Core\Http\Request;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\Frontend\Page;

class ContentController extends Controller
{
    public function page(Request $request, EntityRepository $entityRepository)
    {
        $cache = entityCache()->findForPath();

        $viewName = $this->getViewNameForType($cache->entity_type_id);

        return view($viewName, compact('cache'));
    }
}
```
Replace content in **routes/web.php** with:
```
<?php

Route::get('404', function() {
    abort(404);
});

// This should be the last route defined.
Route::any('{catchall}', 'ContentController@page')->where('catchall', '(.*)');
```

Replace content in **app/Http/Kernel.php** with:
```
<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}


```

### Configuration

Edit **config/auth.php** and change the model property as follows

```
...

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => Escape\Argon\Authentication\User::class,
    ],
],

...
```

Add the ArgonServiceProvider to the providers array in **config/app.php** (Make sure ArgonServiceProvider is called before RouteServiceProvider)

```
'providers' => [

    /*
     * Laravel Framework Service Providers...
     */
    ...

    /*
     * Application Service Providers...
     */
    ...

    Escape\Argon\Core\ArgonServiceProvider::class,
],
```
If you want to utilize Slack Error handler then
change the line in **app/Exceptions/Handler.php**
```

// use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Escape\Argon\Core\Exceptions\SlackHandler as ExceptionHandler;
```
Or if you want to utilize an Email Error handler then change the line above to
```
use Escape\Argon\Core\Exceptions\EmailHandler as ExceptionHandler;
```

Change the Request class in **public/index.php** to Escape\Argon\Core\Http\Request
```
$response = $kernel->handle(
    $request = \Escape\Argon\Core\Http\Request::capture()
);

```

Set your database settings in the **.env** file.

### Database

Publish the migrations for Argon.

```
php artisan vendor:publish --tag=migrations --force
php artisan migrate
```


### Assets

Use artisan to publish the admin assets, config files and event listeners.

```
php artisan vendor:publish --tag=public --force
php artisan vendor:publish --tag=config --force
```


### Event Listeners

```
php artisan vendor:publish --tag=listeners --force
```

Add mapping to your EventServiceProvider.php

```
protected $listen = [
        'Escape\Argon\Events\AdminAccess' =>[
            'App\Listeners\OnAdminAccess',
        ],
        'Escape\Argon\Events\BeforePageSaved' =>[
            'App\Listeners\OnBeforePageSave',
        ],
        'Escape\Argon\Events\PageSaved' =>[
            'App\Listeners\OnPageSave',
        ],
        'Escape\Argon\Events\RenderField' =>[
            'App\Listeners\OnRenderField',
        ],
        'Escape\Argon\Events\BeforeUserDelete' => [
            'App\Listeners\OnBeforeUserDelete',
        ],
        'Escape\Argon\Events\UserDelete' => [
            'App\Listeners\OnUserDelete',
        ],
    ];

```


### Tidy Up

Delete the **app/Http/Middleware/Authenticate.php** file (as Argon has it's own).

Delete the **app/User.php** file (ditto).

## Enabling Image Optimization

### System requirements

```bash
sudo apt-get install jpegoptim
sudo apt-get install libjpeg-progs
sudo apt-get install optipng
sudo apt-get install pngquant
sudo npm install -g svgo
sudo apt-get install gifsicle
```

### Config changes

Include this in the config/argon.php

```php
...
'medialibrary' => [
    'perpage' => 20,
    'optimize' => [
        'enable' => env('IMAGE_OPTIM_ENABLE', true),
    ],
    'fix_thumbs' => false, // set to true on existing projects to automatically update the thumb file name
]
...
```

### Bulk actions (for existing projects)

Publish artisan commands using ``` php artisan vendor:publish --tag commands``` if you haven't done it yet.

include the MediaLibrary commands in you app/Console/Kernel.php
```php
protected $commands = [
    ...
    Commands\MediaLibraryOptimizeAll::class,
    Commands\MediaLibraryFixThumbnails::class,
    ...
];
```

Optimize all images with ```php artisan medialib:optimize``` command.

Fix old thumbnail names with ```php artisan medialib:fixthumbs``` command.

## Development

### Dependencies

These steps are only required if developing Argon itself, and not if using it to build a site.

```
mv vendor/escape/argon workbench
cd workbench
```

PHP dependencies are installed with composer:

```
composer install
```

Frontend dependencies are installed with Bower and specified in the **bower.json**. If you don't have bower installed
already install it with:

```
npm install -g bower
```

Then install the dependencies with:

```
bower install
```

The Sass is compiled with Gulp and Laravel Elixir. Install Gulp if not already installed globally with:

```
npm install -g gulp
```

Then install the local dependencies, including Elixir with:

```
npm install
```

For now, the process when making changes to the frontend resource (Sass/JS) is to run gulp to compile/copy into the
library public folder, and then commit the changes and run `php artisan vendor:publish --tag=public --force` to
republish them to the application public folder.

### Testing

Unit tests can be run with PHPUnit after installing the PHP dependencies (including dev dependencies).

```
vendor/bin/phpunit
```

Unit tests are located in the `Tests/Cases` folder.



## Imporant Git changes notice:
Branch medialib has been merged to master and should not be used from now on.
The last commit on medialib was 3eef6e1.

Branch oldmedialib has been created as a reference to the legacy media library but it should be maintained only to certain degree.
