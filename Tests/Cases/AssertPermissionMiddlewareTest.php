<?php

namespace Escape\Argon\Test\Cases;

use Escape\Argon\Authentication\Middleware\AssertPermission;
use Escape\Argon\Authentication\User;
use Illuminate\Auth\Guard;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssertPermissionMiddlewareTest extends TestCase
{
    use DatabaseMigrations;

    public function testAssertPermission()
    {

        /** @var Guard $guard */
        $guard = $this->app->make(Guard::class);
        $permissionMiddleware = new AssertPermission($guard);

        /** @var Request $request */
        $request = $this->app->make(Request::class);

        $closure = function () {
            return true;
        };

        /** @var RedirectResponse $response */
        $response = $permissionMiddleware->handle($request, $closure, 'cms:login');

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('http://localhost/admin/login', $response->headers->get('Location'));

        // Test Ajax Request
        $request->headers->set('X-Requested-With', 'XMLHttpRequest');
        /** @var Response $response */
        $response = $permissionMiddleware->handle($request, $closure, 'cms:login');

        $this->assertEquals(401, $response->getStatusCode());

        // Logged in tests.
        $user = User::find(1);
        $request->setUserResolver(function () use ($user) {
            // no logged in user.
            return $user;
        });

        $guard->setUser($user);

        /** @var bool $response */
        $response = $permissionMiddleware->handle($request, $closure, 'cms:login');
        $this->assertTrue($response);

        /** @var Response $response */
        $response = $permissionMiddleware->handle($request, $closure, 'cms:fake');
        $this->assertEquals(401, $response->getStatusCode());
    }
}
