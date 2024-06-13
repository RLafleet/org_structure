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

    /**
     * @param string $urlPath
     * @param array $queryParams
     * @return ResponseInterface
     */
    protected function sendGetRequest(string $urlPath, array $queryParams = []): ResponseInterface
    {
        $urlString = $urlPath . '?' . http_build_query($queryParams);
        return $this->sendRequest('GET', $urlString);
    }

    /**
     * @param string $urlPath
     * @param array $requestParams
     * @return ResponseInterface
     */
    protected function sendPostRequest(string $urlPath, array $requestParams = []): ResponseInterface
    {
        return $this->sendRequest('POST', $urlPath, $requestParams);
    }

    /**
     * @param string $urlPath
     * @param array $queryParams
     * @return ResponseInterface
     */
    protected function sendDeleteRequest(string $urlPath, array $queryParams = []): ResponseInterface
    {
        $urlString = $urlPath . '?' . http_build_query($queryParams);
        return $this->sendRequest('DELETE', $urlString);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $body
     * @return ResponseInterface
     */
    private function sendRequest(string $method, string $url, array $body = []): ResponseInterface
    {
        $uri = $this->uriFactory->createUri($url);
        $request = $this->requestFactory->createServerRequest($method, $uri);

        if (!empty($body)) {
            $request = $request->withParsedBody($body);
        }

        return $this->app->handle($request);
    }
}
