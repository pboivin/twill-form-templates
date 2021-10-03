@php
    $tft_edit_after_create = $tft_edit_after_create ?? false;
    $tft_hide_after_create = $tft_hide_after_create ?? false;

    if (!isset($tft_model)) {
        $tft_model_name = Str::studly(Str::singular($moduleName));
        $tft_model = Config::get('twill.namespace', 'App') . '\\Models\\' . $tft_model_name;
    }

    $tft_instance = App::make($tft_model);
    $tft_should_edit = !isset($item) || $tft_edit_after_create;
@endphp

@if (!$tft_should_edit)
    @if (!$tft_hide_after_create)
        @formField('input', [
            'name' => 'current_template_label',
            'label' => $tft_instance->template_field_label,
            'disabled' => true,
        ])
    @endif
@else
    @formField('select', [
        'name' => $tft_instance->template_field_name,
        'label' => $tft_instance->template_field_label,
        'default' => $tft_instance->default_form_template,
        'options' => $tft_instance->available_form_templates,
    ])
@endif
