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
}],
"minimum-stability": "dev"
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

Set your database settings in the .env file.

### Database

Publish the migrations for Argon.

```
php artisan vendor:publish --tag=migrations
```

php artisan migrate


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