<?php
declare(strict_types=1);

namespace Component;

use App\DbTable\BranchTable;
use App\Loader\TwigLoader;
use App\DbTable\WorkerTable;
use App\DbTable\BranchWorkersHandler;
use App\Util\PostParameterHandler;

class ArticleServiceTest extends AbstractDatabaseTestCase
{
    public function testCreateEditAndDeleteArticle(): void
    {
        // Шаг 1. Arrange
        // В данном случае мы только создаём сервис
        $service = $this->createArticleService();
        $firstAuthorId = 10;

        // Шаг 2. Act
        $articleId = $service->createArticle(new CreateArticleParams(
            userId: $firstAuthorId,
            title: '(Черновик) B+ деревья',
            tags: ['MySQL', 'PostgreSQL'],
        ));

        // Шаг 3. Assert
        $article = $service->getArticle($articleId);
        $this->assertEquals('(Черновик) B+ деревья', $article->getTitle());
        $this->assertArticleTags(['MySQL', 'PostgreSQL'], $article);
        $this->assertEquals($firstAuthorId, $article->getCreatedBy());

        // Шаг 1. Arrange
        $secondAuthorId = 17;

        // Шаг 2. Act
        $service->editArticle(new EditArticleParams(
            id: $articleId,
            userId: $secondAuthorId,
            title: 'B+ деревья',
            content: <<<TEXT
                    B+-деревья — это основа физической структуры реляционных баз данных.
                    
                    Именно они ответственны за сочетание двух характеристик реляционных СУБД:
                    
                    - Высокая скорость работы как для небольших запросов, так и для больших 
                    - Устойчивость данных к перезагрузке при условии сохранности внешнего диска
                    TEXT,
            tags: ['MySQL', 'B+-деревья', 'Индексы'],
        ));

        // Шаг 3. Assert
        $article = $service->getArticle($articleId);
        $this->assertEquals('B+ деревья', $article->getTitle());
        $this->assertArticleTags(['MySQL', 'B+-деревья', 'Индексы'], $article);
        $this->assertEquals($firstAuthorId, $article->getCreatedBy());
        $this->assertEquals($secondAuthorId, $article->getUpdatedBy());

        // Шаг 2. Act
        $service->deleteArticle($articleId);

        // Шаг 3. Assert
        $this->expectException(ArticleNotFoundException::class);
        $service->getArticle($articleId);
    }

    public function testBatchDeleteArticles(): void
    {
        // Шаг 1. Arrange
        // В данном случае мы только создаём сервис
        $service = $this->createArticleService();
        $authorId = 10;

        // Шаг 2. Act
        $firstArticleId = $service->createArticle(new CreateArticleParams(
            userId: $authorId,
            title: 'B+ деревья',
            tags: ['MySQL', 'PostgreSQL'],
        ));
        $secondArticleId = $service->createArticle(new CreateArticleParams(
            userId: $authorId,
            title: 'Индексы',
            tags: ['MySQL', 'PostgreSQL', 'SQL'],
        ));
        $thirdArticleId = $service->createArticle(new CreateArticleParams(
            userId: $authorId,
            title: 'План выполнения запроса',
            tags: ['MySQL', 'EXPLAIN', 'SQL'],
        ));
        $service->batchDeleteArticles([$firstArticleId, $secondArticleId]);

        // Шаг 3. Assert
        $article = $service->getArticle($thirdArticleId);
        $this->assertEquals('План выполнения запроса', $article->getTitle());
        $this->assertArticleTags(['MySQL', 'EXPLAIN', 'SQL'], $article);

        $this->assertThrows(
            static fn() => $service->getArticle($firstArticleId),
            ArticleNotFoundException::class
        );
        $this->assertThrows(
            static fn() => $service->getArticle($secondArticleId),
            ArticleNotFoundException::class
        );
    }

    private function assertThrows(\Closure $closure, string $exceptionClass): void
    {
        $actualExceptionClass = null;
        try
        {
            $closure();
        }
        catch (\Throwable $e)
        {
            $actualExceptionClass = $e::class;
        }
        $this->assertEquals($exceptionClass, $actualExceptionClass, "$exceptionClass exception should be thrown");
    }

    private function assertArticleTags(array $expected, Article $article): void
    {
        $actual = $article->getTags();
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual, 'article tags');
    }

    private function createArticleService(): ArticleService
    {
        $connection = $this->getConnection();
        return new ArticleService(
            new TransactionalExecutor($connection),
            new ArticleRepository($connection),
            new TagRepository($connection)
        );
    }
}