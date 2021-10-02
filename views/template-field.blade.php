@php
    $editAfterCreate = $editAfterCreate ?? false;
    $hideAfterCreate = $hideAfterCreate ?? false;

    if (!isset($model)) {
        $modelName = Str::studly(Str::singular($moduleName));
        $model = Config::get('twill.namespace', 'App') . '\\Models\\' . $modelName;
    }

    $instance = App::make($model);
    $shouldEdit = !isset($item) || $editAfterCreate;
@endphp

@if (!$shouldEdit)
    @if (!$hideAfterCreate)
        @formField('input', [
            'name' => 'current_template_label',
            'label' => $instance->template_field_label,
            'disabled' => true,
        ])
    @endif
@else
    @formField('select', [
        'name' => $instance->template_field_name,
        'label' => $instance->template_field_label,
        'default' => $instance->default_block_template,
        'options' => $instance->available_block_templates,
    ])
@endif
