<?php

namespace Tests\Feature;

use Tests\TestCase;

class FormFieldTest extends TestCase
{
    protected function beforeMigrate()
    {
        $this->copyStubs([
            'pages/Page.php' => app_path('Models/Page.php'),
            'pages/views/create.blade.php' => resource_path('views/'.$this->getViewNamespace().'/pages/create.blade.php'),
        ]);
    }

    public function test_can_render_template_field_in_create()
    {
        $result = view($this->getViewNamespace().'.pages.create', [
            'moduleName' => 'pages',
            'titleFormKey' => '',
            'form_fields' => [],
        ])->render();

        $result = str_replace("\n", "", $result);
        $result = preg_replace("/ +/", " ", $result);

        $this->assertMatchesRegularExpression(
            '/\<a17-vselect.+label="Template".+\>.+\<\/a17-vselect\>/',
            $result
        );
        $this->assertMatchesRegularExpression(
            '/\<a17-vselect.+name="template".+\>.+\<\/a17-vselect\>/',
            $result
        );
        $this->assertMatchesRegularExpression(
            '/\<a17-vselect.+:options=\'\[.....+\]\'.+\>.+\<\/a17-vselect\>/',
            $result
        );
    }
}
