<?php

namespace Escape\Argon\Test\Cases;

use Escape\Argon\Authentication\Middleware\Authenticate;
use Escape\Argon\Authentication\User;
use Illuminate\Auth\Guard;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticateMiddlewareTest extends TestCase
{
    use DatabaseMigrations;

    public function testAuthenticate()
    {

        /** @var Guard $guard */
        $guard = $this->app->make(Guard::class);
        $authenticate = new Authenticate($guard);

        /** @var Request $request */
        $request = $this->app->make(Request::class);

        $closure = function () {
            return true;
        };

        /** @var RedirectResponse $response */
        $response = $authenticate->handle($request, $closure);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $prefix = trim(config('argon.admin_route_prefix'), '/');
        $this->assertEquals("http://localhost/{$prefix}/login", $response->headers->get('Location'));

        // Test Ajax Request
        $request->headers->set('X-Requested-With', 'XMLHttpRequest');
        /** @var Response $response */
        $response = $authenticate->handle($request, $closure);

        $this->assertEquals(401, $response->getStatusCode());

        // Logged in tests.
        $user = User::find(1);
//        $request->setUserResolver(function () use ($user) {
//            // no logged in user.
//            return $user;
//        });

        $guard->setUser($user);

        /** @var bool $response */
        $response = $authenticate->handle($request, $closure);
        $this->assertTrue($response);
    }
}
