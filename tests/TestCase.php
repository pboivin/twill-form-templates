<?php

namespace Tests;

use A17\Twill\Models\User;
use A17\Twill\TwillServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Pboivin\TwillFormTemplates\TwillFormTemplatesServiceProvider;

class TestCase extends BaseTestCase
{
    public $superAdmin;

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        // this seems to be required to support capsule tests
        $app->instance('autoloader', require __DIR__ . '/../vendor/autoload.php');

        return [
            TwillServiceProvider::class,
            TwillFormTemplatesServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cleanDirectories();

        // $this->artisan('twill:update');

        $this->beforeMigrate();

        $this->artisan('migrate');

        $this->afterSetup();
    }

    protected function beforeMigrate()
    {
    }

    protected function afterSetup()
    {
    }

    protected function cleanDirectories()
    {
        File::cleanDirectory(base_path('app'));
        File::cleanDirectory(base_path('routes'));
        File::cleanDirectory(resource_path('views'));
        File::delete(config_path('twill.php'));
        File::delete(config_path('twill-navigation.php'));
    }

    protected function copyStubs($filesMap)
    {
        foreach ($filesMap as $source => $destination) {
            $sourcePath = __DIR__ . '/Stubs/' . $source;

            File::ensureDirectoryExists(dirname($destination));

            if (File::isDirectory($sourcePath)) {
                File::copyDirectory($sourcePath, $destination);
            } else {
                File::copy($sourcePath, $destination);
            }
        }
    }

    protected function copyRoutes()
    {
        if (TwillServiceProvider::VERSION >= '3.0.0') {
            $this->copyStubs(['routes.php' => base_path('routes/twill.php')]);
        } else {
            $this->copyStubs(['routes.php' => base_path('routes/admin.php')]);
        }
    }

    protected function getAdminNamespace()
    {
        if (TwillServiceProvider::VERSION >= '3.0.0') {
            return 'Twill';
        } else {
            return 'Admin';
        }
    }

    protected function getViewNamespace()
    {
        if (TwillServiceProvider::VERSION >= '3.0.0') {
            return 'twill';
        } else {
            return 'admin';
        }
    }

    protected function createSuperAdmin()
    {
        $user = User::make([
            'name' => 'Admin',
            'email' => 'admin@test.test',
            'role' => 'SUPERADMIN',
            'published' => true,
        ]);

        $user->password = Hash::make('password');

        $user->save();

        return $user;
    }

    protected function loginSuperAdmin()
    {
        if (!$this->superAdmin) {
            $this->superAdmin = $this->createSuperAdmin();
        }

        $this->post('/admin/login', [
            'email' => 'admin@test.test',
            'password' => 'password',
        ]);
    }
}
