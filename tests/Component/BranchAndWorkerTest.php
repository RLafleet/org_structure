<?php
declare(strict_types=1);

namespace App\Tests\Component;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\DbTable\BranchTable;
use App\DbTable\BranchWorkersHandler;
use App\DbTable\WorkerTable;
use App\Tests\Common\AbstractDatabaseTestCase;

//todo вспомогательные функции
class BranchAndWorkerTest extends AbstractDatabaseTestCase
{
    private function assertBranch(array $actualBranch, string $expectedCity, int $expectedWorkersCount, string $expectedAddress): void
    {
        $this->assertEquals($expectedCity, $actualBranch['city']);
        $this->assertEquals($expectedWorkersCount, $actualBranch['workers_count']);
        $this->assertEquals($expectedAddress, $actualBranch['address']);
    }

    private function assertWorker(array $actualWorker, array $expectedData): void
    {
        foreach ($expectedData as $key => $value) {
            $this->assertEquals($value, $actualWorker[$key]);
        }
    }

    /**
     * @throws \Exception
     */
    public function testCreateEditAndDeleteBranch(): void
    {
        $city = "TestCity";
        $workersCount = 0;
        $address = "Test Address";

        BranchTable::insertBranch($city, $address);
        $branches = BranchTable::listBranches();
        //todo убрать end и смотреть по индексу
        $createdBranch = $branches[0];

        $this->assertNotEmpty($createdBranch);
        $this->assertBranch($createdBranch, $city, $workersCount, $address);

        $newCity = "UpdatedCity";
        $newWorkersCount = 0;
        $newAddress = "Updated Address";
        BranchTable::updateBranch((int)$createdBranch['id'], $newCity, $newAddress);
        $updatedBranch = BranchTable::getBranch((int)$createdBranch['id'])[0];

        $this->assertBranch($updatedBranch, $newCity, $newWorkersCount, $newAddress);

        BranchTable::deleteBranch((int)$createdBranch['id']);

        $deletedBranch = BranchTable::getBranch((int)$createdBranch['id']);
        $this->assertNull($deletedBranch);
    }

    /**
     * @throws \Exception
     */
    public function testAddEditAndDeleteWorker(): void
    {
        $city = "WorkerCity";
        $address = "Worker Address";
        BranchTable::insertBranch($city, $address);
        $branches = BranchTable::listBranches();
        $createdBranch = $branches[0];

        $branchId = (int)$createdBranch['id'];
        $name = "John";
        $lastName = "Doe";
        $middleName = "M.";
        $position = "Developer";

        WorkerTable::insertWorker($branchId, $name, $lastName, $middleName, $position);
        $workers = BranchWorkersHandler::getBranchWorkers($branchId);
        $createdWorker = $workers[0];

        $this->assertNotEmpty($createdWorker);
        $this->assertWorker($createdWorker, [
            'first_name' => $name,
            'last_name' => $lastName,
            'middle_name' => $middleName,
            'position' => $position
        ]);

        $newData = [
            'first_name' => "Jane",
            'last_name' => "Smith",
            'middle_name' => "A.",
            'email' => "jane.smith@example.com",
            'sex' => "female",
            'birth_date' => "1990-01-01",
            'hiring_date' => "2020-01-01",
            'position' => "Manager",
            'comment' => "Updated comment",
            'phone_number' => "1234567890"
        ];

        WorkerTable::updateWorker(
            (int)$createdWorker['id'],
            $branchId,
            $newData['first_name'],
            $newData['last_name'],
            $newData['middle_name'],
            $newData['email'],
            $newData['sex'],
            $newData['birth_date'],
            $newData['hiring_date'],
            $newData['position'],
            $newData['comment'],
            $newData['phone_number']
        );

        $updatedWorker = WorkerTable::findWorker((int)$createdWorker['id'])[0];
        $this->assertWorker($updatedWorker, $newData);

        WorkerTable::deleteWorker((int)$createdWorker['id']);

        $deletedWorker = WorkerTable::findWorker((int)$createdWorker['id']);
        $this->assertNull($deletedWorker);

        BranchTable::deleteBranch($branchId);

        $deletedBranch = BranchTable::getBranch((int)$createdBranch['id']);
        $this->assertNull($deletedBranch);
    }
}
