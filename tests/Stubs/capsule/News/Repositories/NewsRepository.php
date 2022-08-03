<?php

namespace App\Twill\Capsules\News\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Twill\Capsules\News\Models\News;
use Pboivin\TwillFormTemplates\HandleFormTemplates;

class NewsRepository extends ModuleRepository
{
    use HandleBlocks,
        HandleTranslations,
        HandleSlugs,
        HandleMedias,
        HandleFiles,
        HandleRevisions,
        HandleFormTemplates;

    public function __construct(News $model)
    {
        $this->model = $model;
    }
}
