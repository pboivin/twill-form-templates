<?php

namespace PBoivin\TwillFormTemplates;

use A17\Twill\Repositories\BlockRepository;

trait HasBlockTemplates
{
    public function getTemplateFieldNameAttribute()
    {
        return $this->templateField['name'] ?? 'template';
    }

    public function getTemplateFieldLabelAttribute()
    {
        return $this->templateField['label'] ?? 'Template';
    }

    public function getAvailableBlockTemplatesAttribute()
    {
        return $this->blockTemplates['options'] ?? [];
    }

    public function getDefaultBlockTemplateAttribute()
    {
        return $this->blockTemplates['default'] ?? null;
    }

    public function getCurrentTemplateValueAttribute()
    {
        $fieldName = $this->template_field_name;

        return $this->{$fieldName};
    }

    public function getCurrentTemplateLabelAttribute()
    {
        $template = collect($this->available_block_templates)
            ->firstWhere('value', $this->current_template_value);

        return $template['label'] ?? '';
    }

    public function getCurrentTemplateBlockSelectionAttribute()
    {
        $template = collect($this->available_block_templates)
            ->firstWhere('value', $this->current_template_value);

        return $template['block_selection'] ?? [];
    }

    public function prefillBlockSelection()
    {
        $i = 1;

        foreach ($this->current_template_block_selection as $blockType) {
            app(BlockRepository::class)->create([
                'blockable_id' => $this->id,
                'blockable_type' => static::class,
                'position' => $i++,
                'content' => '{}',
                'type' => $blockType,
            ]);
        }
    }
}
