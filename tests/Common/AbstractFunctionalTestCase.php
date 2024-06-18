<?php
declare(strict_types=1);

namespace App\Tests\Common;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\UriFactory;

abstract class AbstractFunctionalTestCase extends AbstractDatabaseTestCase
{
    protected App $app;
    protected ServerRequestFactory $requestFactory;
    protected UriFactory $uriFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->app = AppFactory::create();

        $this->requestFactory = new ServerRequestFactory();
        $this->uriFactory = new UriFactory();

        $this->setupTestRoutes();
    }

    abstract protected function setupTestRoutes(): void;

    protected function sendGetRequest(string $urlPath, array $queryParams = []): ResponseInterface
    {
        $urlString = $urlPath . '?' . http_build_query($queryParams);
        return $this->sendRequest('GET', $urlString);
    }

    protected function sendPostRequest(string $urlPath, array $requestParams = []): ResponseInterface
    {
        return $this->sendRequest('POST', $urlPath, $requestParams);
    }

    protected function sendDeleteRequest(string $urlPath, array $queryParams = []): ResponseInterface
    {
        $urlString = $urlPath . '?' . http_build_query($queryParams);
        return $this->sendRequest('DELETE', $urlString);
    }

    private function sendRequest(string $method, string $url, array $body = []): ResponseInterface
    {
        $uri = $this->uriFactory->createUri($url);
        $request = $this->requestFactory->createServerRequest($method, $uri);

        if (!empty($body)) {
            $request = $request->withParsedBody($body);
        }

        return $this->app->handle($request);
    }

    protected function assertStatusCode(int $statusCode, ResponseInterface $response): void
    {
        $this->assertEquals($statusCode, $response->getStatusCode(), "status code must be $statusCode");
    }

    protected function parseResponseBodyAsJson(ResponseInterface $response): array
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
