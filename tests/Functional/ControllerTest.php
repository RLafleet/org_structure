<?php
declare(strict_types=1);

namespace Functional;

use App\DbTable\BranchTable;
use App\Loader\TwigLoader;
use App\DbTable\WorkerTable;
use App\DbTable\BranchWorkersHandler;
use App\Util\PostParameterHandler;

class ArticleControllerTest extends AbstractFunctionalTestCase
{
    public function testCreateAndEditArticle()
    {
        // Шаг 1. Arrange
        $firstAuthorId = 10;

        // Шаг 2. Act
        $articleId = $this->doCreateArticle(
            userId: $firstAuthorId,
            title: '(Черновик) B+ деревья',
            tags: ['MySQL', 'PostgreSQL']
        );

        // Шаг 3. Assert
        $articleData = $this->doGetArticle($articleId);
        $this->assertEquals('(Черновик) B+ деревья', $articleData['title']);
        $this->assertEquals('', $articleData['content']);
        $this->assertEquals(['MySQL', 'PostgreSQL'], $articleData['tags']);
        $this->assertEquals($firstAuthorId, $articleData['created_by']);
        $this->assertEquals(null, $articleData['updated_by']);

        // Шаг 1. Arrange
        $secondAuthorId = 17;
        $content = <<<TEXT
                    B+-деревья — это основа физической структуры реляционных баз данных.
                    
                    Именно они ответственны за сочетание двух характеристик реляционных СУБД:
                    
                    - Высокая скорость работы как для небольших запросов, так и для больших 
                    - Устойчивость данных к перезагрузке при условии сохранности внешнего диска
                    TEXT;

        // Шаг 2. Act
        $this->doEditArticle(
            articleId: $articleId,
            userId: $secondAuthorId,
            title: 'B+ деревья',
            content: $content,
            tags: ['MySQL', 'B+-деревья', 'Индексы'],
        );

        // Шаг 3. Assert
        $articleData = $this->doGetArticle($articleId);
        $this->assertEquals('B+ деревья', $articleData['title']);
        $this->assertEquals($content, $articleData['content']);
        $this->assertEquals(['MySQL', 'B+-деревья', 'Индексы'], $articleData['tags']);
        $this->assertEquals($firstAuthorId, $articleData['created_by']);
        $this->assertEquals($secondAuthorId, $articleData['updated_by']);
    }

    private function doGetArticle(int $articleId): array
    {
        $response = $this->sendGetRequest(
            '/article',
            ['id' => $articleId]
        );

        // Проверяем HTTP Status Code ответа
        $this->assertStatusCode(200, $response);

        return $this->parseResponseBodyAsJson($response);
    }

    private function doCreateArticle(int $userId, string $title, array $tags): int
    {
        $response = $this->sendPostRequest(
            '/article',
            [
                'user_id' => $userId,
                'title' => $title,
                'tags' => $tags,
            ]
        );

        // Проверяем HTTP Status Code ответа
        $this->assertStatusCode(200, $response);

        $responseData = $this->parseResponseBodyAsJson($response);

        // Проверяем, что поле "id" в ответе имеет тип integer
        $this->assertEquals('integer', gettype($responseData['id'] ?? null));

        return (int)$responseData['id'];
    }

    private function doEditArticle(
        int $articleId,
        int $userId,
        string $title,
        string $content,
        array $tags
    ): void
    {
        $response = $this->sendPostRequest(
            '/article/edit',
            [
                'id' => $articleId,
                'user_id' => $userId,
                'title' => $title,
                'content' => $content,
                'tags' => $tags,
            ]
        );

        // Проверяем HTTP Status Code ответа
        $this->assertStatusCode(200, $response);
    }

    private function assertStatusCode(int $statusCode, ResponseInterface $response): void
    {
        $this->assertEquals($statusCode, $response->getStatusCode(), "status code must be $statusCode");
    }

    private function parseResponseBodyAsJson(ResponseInterface $response): array
    {
        $response->getBody()->seek(0);
        $responseBytes = $response->getBody()->getContents();
        try
        {
            return json_decode($responseBytes, associative: true, flags: JSON_THROW_ON_ERROR);
        }
        catch (\JsonException $e)
        {
            throw new \RuntimeException("Invalid response body: {$e->getMessage()}", 0, $e);
        }
    }
}