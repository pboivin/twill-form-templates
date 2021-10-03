<?php

namespace Tests\Feature;

use Tests\TestCase;

class FormTemplateTest extends TestCase
{
    protected function beforeMigrate()
    {
        $this->copyStubs([
            'pages/2021_10_02_193855_create_pages_tables.php' => database_path('migrations/2021_10_02_193855_create_pages_tables.php'),
            'pages/Page.php' => app_path('Models/Page.php'),
            'pages/PageController.php' => app_path('Http/Controllers/Admin/PageController.php'),
            'pages/PageRepository.php' => app_path('Repositories/PageRepository.php'),
            'pages/PageRevision.php' => app_path('Models/Revisions/PageRevision.php'),
            'pages/PageSlug.php' => app_path('Models/Slugs/PageSlug.php'),
            'pages/PageTranslation.php' => app_path('Models/Translations/PageTranslation.php'),
            'admin.php' => base_path('routes/admin.php'),
        ]);
    }

    protected function afterSetup()
    {
        $this->loginSuperAdmin();
    }

    public function test_can_access_admin()
    {
        $response = $this->get('/admin');

        $response->assertStatus(200);
    }

    public function test_can_access_pages()
    {
        $response = $this->get('/admin/pages');

        $response->assertStatus(200);
    }
}

/*
./pages/views
./pages/views/create.blade.php
./pages/views/_default.blade.php
./pages/views/form.blade.php
./twill-navigation.php
./twill.php
*/
