<?php

namespace Tests\Unit;

use App\Models\Item;
use Tests\TestCase;

class HasFormTemplatesTest extends TestCase
{
    public $item;

    public $formTemplates;

    protected function afterSetup()
    {
        $this->copyStubs([
            'items/Item.php' => app_path('Models/Item.php'),
        ]);

        $this->item = new Item;

        $this->formTemplates = [
            'options' => [
                [
                    'name' => 'one',
                    'label' => 'One',
                    'block_selection' => ['lorem'],
                ],
                [
                    'name' => 'two',
                    'label' => 'Two',
                    'block_selection' => ['lorem', 'ipsum'],
                ],
                [
                    'name' => 'three',
                    'label' => 'Three',
                    'block_selection' => ['lorem', 'ipsum', 'dolor'],
                ],
            ],
        ];
    }

    public function test_has_default_template_field()
    {
        $this->item->template = 'asdf';

        $this->assertEquals('template', $this->item->template_field_name);
        $this->assertEquals('Template', $this->item->template_field_label);
        $this->assertEquals('asdf', $this->item->current_template_value);
    }

    public function test_can_use_custom_template_field()
    {
        $this->item->custom_template = 'asdf';

        $this->item->templateField = [
            'name' => 'custom_template',
            'label' => 'Custom Template',
        ];

        $this->assertEquals('custom_template', $this->item->template_field_name);
        $this->assertEquals('Custom Template', $this->item->template_field_label);
        $this->assertEquals('asdf', $this->item->current_template_value);
    }

    public function test_can_get_template_options()
    {
        $this->item->formTemplates = $this->formTemplates;

        $this->assertEquals($this->formTemplates['options'], $this->item->available_form_templates);
    }

    public function test_default_to_first_template_if_not_set()
    {
        $this->item->formTemplates = $this->formTemplates;

        $this->assertEquals('one', $this->item->default_form_template);
    }

    public function test_can_set_default_template()
    {
        $this->formTemplates['default'] = 'three';

        $this->item->formTemplates = $this->formTemplates;

        $this->assertEquals('three', $this->item->default_form_template);
    }

    public function test_can_get_current_template_information()
    {
        $this->item->formTemplates = $this->formTemplates;

        $this->item->template = 'three';

        $this->assertEquals('three', $this->item->current_template_value);
        $this->assertEquals('Three', $this->item->current_template_label);
        $this->assertEquals(['lorem', 'ipsum', 'dolor'], $this->item->current_template_block_selection);
    }
}
