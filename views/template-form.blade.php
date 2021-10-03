@php
    $tft_view_prefix = $tft_view_prefix ?? "admin";
@endphp

@includeFirst([
    "{$tft_view_prefix}.{$moduleName}._{$item->current_template_value}",
    "{$tft_view_prefix}.{$moduleName}._default",
    "twill-form-templates::_template-not-found",
])
