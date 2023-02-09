<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasTranslation;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use Pboivin\TwillFormTemplates\HasFormTemplates;

class Page extends Model implements Sortable
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
        'template',
    ];

    public $translatedAttributes = ['title', 'description', 'active'];

    public $slugAttributes = ['title'];

    public $mediasParams = [];

    public $formTemplates = [
        'options' => [
            [
                'value' => 'home',
                'label' => 'Home',
            ],
            [
                'value' => 'about',
                'label' => 'About',
            ],
            [
                'value' => 'contact',
                'label' => 'Contact',
            ],
        ],
        'default' => 'home',
    ];
}
