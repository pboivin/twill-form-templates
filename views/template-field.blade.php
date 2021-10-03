@php
    $tft_editAfterCreate = $tft_editAfterCreate ?? false;
    $tft_hideAfterCreate = $tft_hideAfterCreate ?? false;

    if (!isset($tft_model)) {
        $tft_modelName = Str::studly(Str::singular($moduleName));
        $tft_model = Config::get('twill.namespace', 'App') . '\\Models\\' . $tft_modelName;
    }

    $tft_instance = App::make($tft_model);
    $shouldEdit = !isset($item) || $tft_editAfterCreate;
@endphp

@if (!$shouldEdit)
    @if (!$tft_hideAfterCreate)
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
