<?php

namespace Escape\Argon\Test\Cases;

use Escape\Argon\Authentication\Middleware\AssertRole;
use Escape\Argon\Authentication\User;
use Illuminate\Auth\Guard;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssertRoleMiddlewareTest extends TestCase
{
    use DatabaseMigrations;

    public function testAssertRole()
    {

        /** @var Guard $guard */
        $guard = $this->app->make(Guard::class);
        $roleMiddleware = new AssertRole($guard);

        /** @var Request $request */
        $request = $this->app->make(Request::class);

        $closure = function () {
            return true;
        };

        /** @var RedirectResponse $response */
        $response = $roleMiddleware->handle($request, $closure, 'Root');

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('http://localhost/admin/login', $response->headers->get('Location'));

        // Test Ajax Request
        $request->headers->set('X-Requested-With', 'XMLHttpRequest');
        /** @var Response $response */
        $response = $roleMiddleware->handle($request, $closure, 'Root');

        $this->assertEquals(401, $response->getStatusCode());

        // Logged in tests.
        $user = User::find(1);
        $request->setUserResolver(function () use ($user) {
            // no logged in user.
            return $user;
        });

        $guard->setUser($user);

        /** @var bool $response */
        $response = $roleMiddleware->handle($request, $closure, 'Admin');
        $this->assertTrue($response);

        /** @var Response $response */
        $response = $roleMiddleware->handle($request, $closure, 'Fake');
        $this->assertEquals(401, $response->getStatusCode());
    }
}
