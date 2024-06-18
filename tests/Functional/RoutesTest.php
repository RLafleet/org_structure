<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\Common\AbstractFunctionalTestCase;

class RoutesTest extends AbstractFunctionalTestCase
{
    protected function setupTestRoutes(): void
    {
    }

    /*

    public function testCreateAndEditEmployee(): void
    {
        $branchId = $this->doCreateBranch(
            city: 'Калининград',
            address: 'Улица Пушкина',
        );

        $employeeId = $this->doCreateEmployee(
            name: 'Джон',
            position: 'Разработчик',
            branchId: 1
        );

        $employeeData = $this->doGetEmployee($employeeId);
        $this->assertEquals('Джон', $employeeData['name']);
        $this->assertEquals('Разработчик', $employeeData['position']);
        $this->assertEquals(1, $employeeData['branch_id']);

        $this->doEditEmployee(
            employeeId: $employeeId,
            name: 'Jane Doe',
            position: 'Senior Developer',
            branchId: 2
        );

        $employeeData = $this->doGetEmployee($employeeId);
        $this->assertEquals('Jane Doe', $employeeData['name']);
        $this->assertEquals('Senior Developer', $employeeData['position']);
        $this->assertEquals(2, $employeeData['branch_id']);

        $this->doDeleteEmployee($employeeId);

        $this->expectException(\RuntimeException::class);
        $this->doGetEmployee($employeeId);
    }
    */
    private function doCreateBranch(string $city, string $address): int
    {
        $response = $this->sendPostRequest(
            '/index',
            [
                'name' => $city,
                'position' => $address,
            ]
        );

        $this->assertStatusCode(200, $response);
        $responseData = $this->parseResponseBodyAsJson($response);

        $this->assertEquals('integer', gettype($responseData['id'] ?? null));
        return (int)$responseData['id'];
    }
    private function doCreateEmployee(string $name, string $position, int $branchId): int
    {
        $response = $this->sendPostRequest(
            'http://127.0.0.1:8000/branch.php',
            [
                'name' => $name,
                'position' => $position,
                'branch_id' => $branchId,
            ]
        );

        $this->assertStatusCode(200, $response);
        $responseData = $this->parseResponseBodyAsJson($response);

        $this->assertEquals('integer', gettype($responseData['id'] ?? null));
        return (int)$responseData['id'];
    }

    private function doEditEmployee(int $employeeId, string $name, string $position, int $branchId): void
    {
        $response = $this->sendPostRequest(
            'http://127.0.0.1:8000/worker.php',
            [
                'id' => $employeeId,
                'name' => $name,
                'position' => $position,
                'branch_id' => $branchId,
            ]
        );

        $this->assertStatusCode(200, $response);
    }

    private function doGetEmployee(int $employeeId): array
    {
        $response = $this->sendGetRequest('/http://127.0.0.1:8000/branch.php');
        $this->assertStatusCode(200, $response);

        $employees = $this->parseResponseBodyAsJson($response);

        foreach ($employees as $employee) {
            if ($employee['id'] == $employeeId) {
                return $employee;
            }
        }

        throw new \RuntimeException("Employee with ID $employeeId not found");
    }

    private function doDeleteEmployee(int $employeeId): void
    {
        $response = $this->sendDeleteRequest('//http://127.0.0.1:8000/deleteWorker.php', ['id' => $employeeId]);
        $this->assertStatusCode(200, $response);
    }
}
