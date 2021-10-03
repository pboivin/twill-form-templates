<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Repositories\PageRepository;
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
            'pages/views/form.blade.php' => resource_path('views/admin/pages/form.blade.php'),
            'admin.php' => base_path('routes/admin.php'),
        ]);
    }

    protected function afterSetup()
    {
        $this->loginSuperAdmin();
    }

    protected function createPage($title = 'Lorem ipsum', $template = 'home')
    {
        return app(PageRepository::class)->create([
            'title' => ['en' => $title],
            'template' => $template,
        ]);
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

    public function test_show_hint_if_form_template_is_not_found()
    {
        $this->createPage();

        $this->assertEquals(1, Page::count());

        $response = $this->get('/admin/pages/1/edit');

        $response->assertStatus(200);

        $this->assertMatchesRegularExpression(
            '/Form template not found for .*home.*/',
            $response->content()
        );
    }

    public function test_use_default_form_template_as_fallback()
    {
        $this->copyStubs([
            'pages/views/_default.blade.php' => resource_path('views/admin/pages/_default.blade.php'),
        ]);

        $this->createPage();

        $response = $this->get('/admin/pages/1/edit');

        $response->assertSee('This is the default template');
    }

    public function test_use_specific_form_template()
    {
        $this->copyStubs([
            'pages/views/_default.blade.php' => resource_path('views/admin/pages/_default.blade.php'),
            'pages/views/_home.blade.php' => resource_path('views/admin/pages/_home.blade.php'),
        ]);

        $this->createPage();

        $response = $this->get('/admin/pages/1/edit');

        $response->assertSee('This is the home template');
    }
}
