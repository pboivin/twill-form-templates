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

class Article extends Model implements Sortable
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
                'value' => 'full_article',
                'label' => 'Full Article',
                'block_selection' => ['article-header', 'article-paragraph', 'article-references'],
            ],
            [
                'value' => 'linked_article',
                'label' => 'Linked Article',
                'block_selection' => ['article-header', 'linked-article'],
            ],
            [
                'value' => 'empty',
                'label' => 'Empty',
                'block_selection' => [],
            ],
        ],
        'default' => 'full_article',
    ];

    public $availableBlocks = [
        'article-header',
        'article-paragraph',
        'article-references',
        'linked-article',
    ];

    public static $TEST_USE_NAMED_BLOCK_SELECTION = false;

    public function setNamedBlockSelection()
    {
        $this->formTemplates = [
            'options' => [
                [
                    'value' => 'full_article',
                    'label' => 'Full Article',
                    'block_selection' => [
                        'default' => ['article-header', 'article-paragraph'],
                        'footer' => ['article-references'],
                    ],
                ],
                [
                    'value' => 'linked_article',
                    'label' => 'Linked Article',
                    'block_selection' => ['article-header', 'linked-article'],
                ],
                [
                    'value' => 'empty',
                    'label' => 'Empty',
                    'block_selection' => [],
                ],
            ],
            'default' => 'full_article',
        ];
    }
}
