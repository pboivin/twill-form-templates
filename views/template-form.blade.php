{{-- 
    @param ?string $templateFormViewPrefix  The full view prefix used to locate template partials.
--}}

@php
    $templateFormViewPrefix = $templateFormViewPrefix ?? "admin";
@endphp

@includeFirst([
    "{$templateFormViewPrefix}.{$moduleName}._{$item->current_template_value}",
    "{$templateFormViewPrefix}.{$moduleName}._default",
    "twill-form-templates::_template-not-found",
])
