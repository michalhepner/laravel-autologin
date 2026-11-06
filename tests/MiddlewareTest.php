<?php

namespace MichalHepner\LaravelAutologin\Tests;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use MichalHepner\LaravelAutologin\Middleware;
use MichalHepner\LaravelAutologin\ServiceProvider;
use Orchestra\Testbench\TestCase;

class MiddlewareTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('app.key', 'base64:' . base64_encode(str_repeat('a', 32)));
        $app['config']->set('database.default', 'testing');
        $app['config']->set('auth.providers.users.model', User::class);
    }

    protected function defineDatabaseMigrations()
    {
        Schema::create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        User::forceCreate(['name' => 'Test', 'email' => 'test@example.com', 'password' => 'secret']);
    }

    protected function defineRoutes($router)
    {
        Route::middleware(['web', Middleware::class])->get('/whoami', function () {
            return response()->json(['id' => Auth::id()]);
        });
    }

    public function testLogsInConfiguredUser()
    {
        config(['autologin.handlers.default.config.id' => 1]);

        $this->get('/whoami')->assertOk()->assertJson(['id' => 1]);
        $this->assertAuthenticated();
    }

    public function testRedirectsAfterLoginWhenConfigured()
    {
        config(['autologin.handlers.default.config.id' => 1, 'autologin.redirect' => '/home']);

        $this->get('/whoami')->assertRedirect('/home');
        $this->assertAuthenticated();
    }

    public function testDoesNothingWithoutUserId()
    {
        $this->get('/whoami')->assertOk()->assertJson(['id' => null]);
        $this->assertGuest();
    }

    public function testDoesNothingForUnknownUser()
    {
        config(['autologin.handlers.default.config.id' => 999]);

        $this->get('/whoami')->assertOk()->assertJson(['id' => null]);
        $this->assertGuest();
    }

    public function testNullHandlerNeverLogsIn()
    {
        config(['autologin.handler' => 'null', 'autologin.handlers.default.config.id' => 1]);

        $this->get('/whoami')->assertOk()->assertJson(['id' => null]);
        $this->assertGuest();
    }

    public function testDefaultConfigIsAvailableWithoutPublishing()
    {
        $this->assertSame('default', config('autologin.handler'));
    }
}
