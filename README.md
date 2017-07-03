# Project Argon (Name TBD)

## Installation

Create a basic Laravel (5.1) project:

```
composer create-project laravel/laravel --prefer-dist
```

Add a repositories section to the composer.json:

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

### Configuration

Edit `config/auth.php` and change the model property as follows

```
...

'model' => Escape\Argon\Authentication\User::class,

...
```

Add the ArgonServiceProvider to the providers array in `config/app.php`

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

Change the Request class in index.php to Escape\Argon\Core\Http\Request
```
$response = $kernel->handle(
    $request = \Escape\Argon\Core\Http\Request::capture()
);

```

Set your database settings in the .env file.

### Configuration

Create /app/config/argon.php and add:
```
<?php

return [
    'admin_route_prefix' => '/admin',
    'client_logo_dark' => '/cms/logo.png',
    'client_logo_light' => '/cms/logo-light.png',
    'highlight_color' => '#eb2d2e',
    'highlight_color_darker' => '#bd2029',
    'neutral_color' => '#46555f',
    'logo-admin-login' => 'width: auto;margin-bottom: auto;',
    'navbar' => 'padding-left: 0;padding-top: 0;padding-bottom: 0;height: 51px;',
    'navbar-nav' => 'height:51px;',
    'nav-item' => 'height:51px;',
    'nav-link' => 'line-height:51px; padding-top:0; padding-bottom:0;',
    'navbar-brand' => 'padding:0;margin:0;',
    'logo-admin' => 'height:39px; padding:0; margin:6px;',
    'sitemap_view' => 'argon::pages.sitemap',

    'client_name' => 'Client Name',

    'views' => [
        1 => 'pages.homepage',        
        7 => 'pages.generic',
        ],
];
```

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
```

### Tidy Up

Delete the `app/Http/Middleware/Authenticate.php` file (as Argon has it's own).

Delete the `app/User.php` file (ditto).

Remove the 'auth' route Middleware from `app/Http/Kernel.php` file (again, Argon has it's own).


## Development

### Dependencies

These steps are only required if developing Argon itself, and not if using it to build a site.

PHP dependencies are installed with composer:

```
composer install
```

Frontend dependencies are installed with Bower and specified in the `bower.json`. If you don't have bower installed
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