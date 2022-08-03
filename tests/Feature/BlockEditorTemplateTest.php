<?php

namespace Tests\Feature;

use A17\Twill\Models\Block;
use App\Repositories\ArticleRepository;
use App\Models\Article;
use Tests\TestCase;

class BlockEditorTemplateTest extends TestCase
{
    protected function beforeMigrate()
    {
        $this->copyStubs([
            'articles/2021_10_02_162328_create_articles_tables.php' => database_path('migrations/2021_10_02_162328_create_articles_tables.php'),
            'articles/Article.php' => app_path('Models/Article.php'),
            'articles/ArticleController.php' => app_path('Http/Controllers/Admin/ArticleController.php'),
            'articles/ArticleRepository.php' => app_path('Repositories/ArticleRepository.php'),
            'articles/ArticleRevision.php' => app_path('Models/Revisions/ArticleRevision.php'),
            'articles/ArticleSlug.php' => app_path('Models/Slugs/ArticleSlug.php'),
            'articles/ArticleTranslation.php' => app_path('Models/Translations/ArticleTranslation.php'),

            'blocks/article-header.blade.php' => resource_path('views/admin/blocks/article-header.blade.php'),
            'blocks/article-paragraph.blade.php' => resource_path('views/admin/blocks/article-paragraph.blade.php'),
            'blocks/article-references.blade.php' => resource_path('views/admin/blocks/article-references.blade.php'),
            'blocks/linked-article.blade.php' => resource_path('views/admin/blocks/linked-article.blade.php'),

            'admin.php' => base_path('routes/admin.php'),
        ]);
    }

    protected function createArticle($title = 'Lorem ipsum', $template = 'full_article')
    {
        return app(ArticleRepository::class)->create([
            'title' => ['en' => $title],
            'template' => $template,
        ]);
    }

    public function test_can_prefill_default_block_templates()
    {
        Article::$TEST_USE_NAMED_BLOCK_SELECTION = false;

        $this->assertEquals(0, Article::count());
        $this->assertEquals(0, Block::count());

        $this->createArticle();

        $this->assertEquals(1, Article::count());
        $this->assertEquals(3, Block::count());

        $article = Article::first();
        $this->assertEquals(3, $article->blocks->count());

        $this->assertEquals(
            ['article-header', 'article-paragraph', 'article-references'],
            $article->blocks()->editor('default')->get()->pluck('type')->toArray()
        );
    }

    public function test_can_prefill_named_editor_block_templates()
    {
        Article::$TEST_USE_NAMED_BLOCK_SELECTION = true;

        $this->assertEquals(0, Article::count());
        $this->assertEquals(0, Block::count());

        $this->createArticle();

        $this->assertEquals(1, Article::count());
        $this->assertEquals(3, Block::count());

        $article = Article::first();
        $this->assertEquals(3, $article->blocks->count());

        $this->assertEquals(
            ['article-header', 'article-paragraph'],
            $article->blocks()->editor('default')->get()->pluck('type')->toArray()
        );

        $this->assertEquals(
            ['article-references'],
            $article->blocks()->editor('footer')->get()->pluck('type')->toArray()
        );
    }
}
