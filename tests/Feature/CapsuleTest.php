<?php

namespace Tests\Feature;

use App\Twill\Capsules\News\Repositories\NewsRepository;
use Tests\TestCase;

class CapsuleTest extends TestCase
{
    protected function beforeMigrate()
    {
        $this->copyStubs([
            'capsule/News' => app_path('Twill/Capsules/News'),
            'capsule/twill.php' => config_path('twill.php'),
            'capsule/twill-navigation.php' => config_path('twill-navigation.php'),
        ]);
    }

    protected function createNewsItem($title = 'Lorem ipsum', $format = '')
    {
        return app(NewsRepository::class)->create([
            'title' => ['en' => $title],
            'format' => $format,
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

    public function test_can_access_news()
    {
        $response = $this->get('/admin/news');

        $response->assertStatus(200);
    }

    public function test_can_locate_default_form_template()
    {
        $this->createNewsItem();

        $response = $this->get('/admin/news/1/edit');

        $response->assertSee('This is the default template for News');
    }

    public function test_can_locate_specific_form_template()
    {
        $this->createNewsItem('Test', 'standard');

        $response = $this->get('/admin/news/1/edit');

        $response->assertSee('This is the standard template for News');
    }

    public function test_can_render_template_field_in_create()
    {
        $result = view('News.resources.views.admin.create', [
            'moduleName' => 'news',
            'titleFormKey' => '',
            'form_fields' => [],
        ])->render();

        $result = str_replace("\n", "", $result);
        $result = preg_replace("/ +/", " ", $result);

        $this->assertMatchesRegularExpression(
            '/\<a17-vselect.+label="Format".+\>.+\<\/a17-vselect\>/',
            $result
        );
        $this->assertMatchesRegularExpression(
            '/\<a17-vselect.+name="format".+\>.+\<\/a17-vselect\>/',
            $result
        );
        $this->assertMatchesRegularExpression(
            '/\<a17-vselect.+:options=\'\[.....+\]\'.+\>.+\<\/a17-vselect\>/',
            $result
        );
    }
}
