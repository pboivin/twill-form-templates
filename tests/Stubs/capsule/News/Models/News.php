<?php

namespace App\Twill\Capsules\News\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasTranslation;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use PBoivin\TwillFormTemplates\HasFormTemplates;

class News extends Model implements Sortable
{
    use HasBlocks,
        HasTranslation,
        HasSlug,
        HasMedias,
        HasFiles,
        HasRevisions,
        HasPosition,
        HasFormTemplates;

    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
        'format',
    ];

    public $translatedAttributes = ['title', 'description', 'active'];

    public $slugAttributes = ['title'];

    public $mediasParams = [
        'cover' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
            ],
            'flexible' => [
                [
                    'name' => 'free',
                    'ratio' => 0,
                ],
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
                [
                    'name' => 'portrait',
                    'ratio' => 3 / 5,
                ],
            ],
        ],
    ];

    public $templateField = [
        'name' => 'format',
        'label' => 'Format',
    ];

    public $formTemplates = [
        'options' => [
            [
                'value' => 'standard',
                'label' => 'Standard',
            ],
            [
                'value' => 'custom',
                'label' => 'Custom',
            ],
        ],
        'default' => 'standard',
    ];
}
