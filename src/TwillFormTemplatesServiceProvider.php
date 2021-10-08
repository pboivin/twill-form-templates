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
        $this->loadTranslations();

        $this->loadViews();

        $this->extendBlade();
    }

    private function loadTranslations()
    {
        $path = __DIR__ . '/../lang';

        $this->loadTranslationsFrom($path, 'twill-form-templates');

        $this->publishes(
            [$path => resource_path('lang/vendor/twill-form-templates')],
            'lang'
        );
    }

    private function loadViews()
    {
        $path = __DIR__ . '/../views';

        $this->loadViewsFrom($path, 'twill-form-templates');

        $this->publishes(
            [$path => resource_path('views/vendor/twill-form-templates')],
            'views'
        );
    }

    private function extendBlade()
    {
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
