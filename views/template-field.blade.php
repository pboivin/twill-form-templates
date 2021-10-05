{{--
    @param ?bool $templateFieldEditAfterCreate  Enable editing the field after the record is created.
    @param ?bool $templateFieldHideAfterCreate  Hide the field after the record is created.
    @param ?string $templateFieldModel  The fully qualified model class for this field.
--}}

@php
    $templateFieldEditAfterCreate = $templateFieldEditAfterCreate ?? false;
    $templateFieldHideAfterCreate = $templateFieldHideAfterCreate ?? false;

    if (!isset($templateFieldModel)) {
        $_tft_namespace = Config::get('twill.namespace', 'App');
        $_tft_capsule_name = Str::studly($moduleName);
        $_tft_model_name = Str::studly(Str::singular($moduleName));
        $_tft_capsule_model_fqcn = "{$_tft_namespace}\\Twill\\Capsules\\{$_tft_capsule_name}\\Models\\{$_tft_model_name}";

        $templateFieldModel = "{$_tft_namespace}\\Models\\{$_tft_model_name}";

        if (class_exists($_tft_capsule_model_fqcn)) {
            $templateFieldModel = $_tft_capsule_model_fqcn;
        }
    }

    $_tft_instance = App::make($templateFieldModel);
    $_tft_should_edit = !isset($item) || $templateFieldEditAfterCreate;
@endphp

@if (!$_tft_should_edit)
    @if (!$templateFieldHideAfterCreate)
        @formField('input', [
            'name' => 'current_template_label',
            'label' => $_tft_instance->template_field_label,
            'disabled' => true,
        ])
    @endif
@else
    @formField('select', [
        'name' => $_tft_instance->template_field_name,
        'label' => $_tft_instance->template_field_label,
        'default' => $_tft_instance->default_form_template,
        'options' => $_tft_instance->available_form_templates,
    ])
@endif
