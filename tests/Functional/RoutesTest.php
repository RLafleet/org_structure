<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\Common\AbstractFunctionalTestCase;

class RoutesTest extends AbstractFunctionalTestCase
{
    protected function setupTestRoutes(): void
    {
        $this->app->get('/test', function ($request, $response, $args) {
            $response->getBody()->write("Hello, world!");
            return $response;
        });

        $this->app->post('/test', function ($request, $response, $args) {
            $data = $request->getParsedBody();
            $response->getBody()->write("Hello, {$data['name']}!");
            return $response;
        });
    }

    public function testGetRequest(): void
    {
        $response = $this->sendGetRequest('/test');
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('Hello, world!', (string)$response->getBody());
    }

    public function testPostRequest(): void
    {
        $response = $this->sendPostRequest('/test', ['name' => 'John']);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('Hello, John!', (string)$response->getBody());
    }
}
