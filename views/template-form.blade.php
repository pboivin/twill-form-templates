{{--
    @param ?string $templateFormViewPrefix  The full view prefix used to locate template partials.
--}}

@php
    $templateFormViewPrefix = $templateFormViewPrefix ?? "admin.{$moduleName}";

    $_tft_capsule_name = Str::studly($moduleName);
@endphp

@includeFirst([
    "{$templateFormViewPrefix}._{$item->current_template_value}",
    "{$templateFormViewPrefix}._default",
    "{$_tft_capsule_name}.resources.views.admin._{$item->current_template_value}",
    "{$_tft_capsule_name}.resources.views.admin._default",
    "twill-form-templates::_template-not-found",
])
