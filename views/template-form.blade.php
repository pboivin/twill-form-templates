@php
    $prefix = $prefix ?? "admin";
@endphp

@include("{$prefix}.{$moduleName}._{$item->current_template_value}")
