<?php

namespace Pboivin\TwillFormTemplates;

use A17\Twill\Repositories\BlockRepository;

/**
 * @property-read string       $template_field_name
 * @property-read string       $template_field_label
 * @property-read array        $available_form_templates
 * @property-read string|null  $default_form_template
 * @property-read string       $current_template_value
 * @property-read string       $current_template_label
 * @property-read array        $current_template_block_selection
 */
trait HasFormTemplates
{
    /**
     * @return string
     */
    public function getTemplateFieldNameAttribute()
    {
        return $this->templateField['name'] ?? 'template';
    }

    /**
     * @return string
     */
    public function getTemplateFieldLabelAttribute()
    {
        return $this->templateField['label'] ?? twillTrans('twill-form-templates::lang.template');
    }

    /**
     * @return array
     */
    public function getAvailableFormTemplatesAttribute()
    {
        return $this->formTemplates['options'] ?? [];
    }

    /**
     * @return string|null
     */
    public function getDefaultFormTemplateAttribute()
    {
        if ($this->formTemplates['default'] ?? false) {
            return $this->formTemplates['default'];
        }

        if ($this->available_form_templates[0] ?? false) {
            return $this->available_form_templates[0]['value'] ?? null;
        }

        return null;
    }

    /**
     * @return string
     */
    public function getCurrentTemplateValueAttribute()
    {
        $fieldName = $this->template_field_name;

        return $this->{$fieldName};
    }

    /**
     * @return string
     */
    public function getCurrentTemplateLabelAttribute()
    {
        $options = $this->getCurrentTemplateOptions();

        return $options['label'] ?? '';
    }

    /**
     * @return array
     */
    public function getCurrentTemplateBlockSelectionAttribute()
    {
        $options = $this->getCurrentTemplateOptions();

        return $options['block_selection'] ?? [];
    }

    /**
     * @return array|null
     */
    public function getCurrentTemplateOptions()
    {
        return collect($this->available_form_templates)->firstWhere(
            'value',
            $this->current_template_value
        );
    }

    /**
     * Create all blocks defined in the current template options.
     *
     * @return void
     */
    public function prefillBlockSelection()
    {
        $blockSelection = $this->current_template_block_selection ?: [];

        if (empty($blockSelection)) {
            return;
        }

        $firstItem = reset($blockSelection);
        $blockEditors = [];

        if (is_array($firstItem)) {
            $blockEditors = $blockSelection;
        } else {
            $blockEditors['default'] = $blockSelection;
        }

        foreach ($blockEditors as $editorName => $editorBlocks) {
            $i = 1;

            foreach ($editorBlocks as $blockType) {
                app(BlockRepository::class)->create([
                    'blockable_id' => $this->id,
                    'blockable_type' => static::class,
                    'position' => $i++,
                    'content' => '{}',
                    'type' => $blockType,
                    'editor_name' => $editorName,
                ]);
            }
        }
    }
}
