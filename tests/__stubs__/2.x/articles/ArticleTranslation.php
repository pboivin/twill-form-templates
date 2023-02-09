<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;
use App\Models\Article;

class ArticleTranslation extends Model
{
    protected $baseModuleModel = Article::class;
}
