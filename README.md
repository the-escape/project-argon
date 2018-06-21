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
        $node = $entityRepository->findForPath($request);

        if (!$node) {
            abort(404);
        }

        $page = new Page($node, $request);

        if ($redirect = $page->getRedirect()) {
            return redirect($redirect, 301);
        }

        $viewName = $this->getViewNameForType($node->entity_type_id);

        return view($viewName, [
            'page' => $page,
        ]);
    }
}
```
Replace content in **/app/Http/routes.php** with:
```
<?php

Route::get('404', function() {
    abort(404);
});

// This should be the last route defined.
Route::any('{catchall}', 'ContentController@page')->where('catchall', '(.*)');
```

### Configuration

Edit **config/auth.php** and change the model property as follows

```
...

'model' => Escape\Argon\Authentication\User::class,

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

Use artisan to publish the admin assets.

```
php artisan vendor:publish --tag=public
php artisan vendor:publish --tag=config --force
```

### Tidy Up

Delete the **app/Http/Middleware/Authenticate.php** file (as Argon has it's own).

Delete the **app/User.php** file (ditto).

Remove the 'auth' route Middleware from **app/Http/Kernel.php** file (again, Argon has it's own).


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