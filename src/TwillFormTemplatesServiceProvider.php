<?php

namespace PBoivin\TwillFormTemplates;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class TwillFormTemplatesServiceProvider extends BaseServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'twill-form-templates');

        Blade::include(
            'twill-form-templates::template-field',
            'twillFormTemplateField'
        );

        Blade::include(
            'twill-form-templates::template-form',
            'twillFormTemplate'
        );
    }
}
