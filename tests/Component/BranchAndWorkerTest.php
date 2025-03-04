<?php
declare(strict_types=1);

namespace App\Tests\Component;

require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\DbTable\BranchTable;
use App\DbTable\BranchDepartmentHandler;
use App\DbTable\WorkerTable;
use App\Tests\Common\AbstractDatabaseTestCase;

// [+] todo вспомогательные функции
// [+] todo убрать end и смотреть по индексу
// [+] todo негативные тесты
// [+] todo поменять местами параметры и дефолтное значение
// [+] todo именованные параметры
// [+] todo проверять количество сотрудников
// [+] todo конкретные assert
// [+] todo описать негативный в тест-плане
// [+] todo негативный тест с injection
class BranchAndWorkerTest extends AbstractDatabaseTestCase
{
    /**
     * @throws \Exception
     */
    public function testCreateEditAndDeleteBranch(): void
    {
        BranchTable::insertBranch("Москва", "улица Пушкина, 102");
        $branches = BranchTable::listBranches();
        $this->assertCount(1, $branches);
        $createdBranch = $branches[0];

        $this->assertNotEmpty($createdBranch);
        $this->assertBranch($createdBranch, "Москва", "улица Пушкина, 102");

        BranchTable::updateBranch((int)$createdBranch['id'], "Москва", "улица Гоголя, 103");
        $updatedBranch = BranchTable::findBranch((int)$createdBranch['id'])[0];

        $this->assertBranch($updatedBranch, "Москва", "улица Гоголя, 103");

        BranchTable::deleteBranch((int)$createdBranch['id']);

        $deletedBranch = BranchTable::findBranch((int)$createdBranch['id']);
        $this->assertNull($deletedBranch);
    }

    private function assertBranch(array $actualBranch, string $expectedCity, string $expectedAddress, int $expectedWorkersCount = 0): void
    {
        $this->assertEquals($expectedCity, $actualBranch['city']);
        $this->assertEquals($expectedAddress, $actualBranch['address']);
        $this->assertEquals($expectedWorkersCount, $actualBranch['workers_count']);
    }

    /**
     * @throws \Exception
     */
    public function testAddEditAndDeleteWorker(): void
    {
        BranchTable::insertBranch("Калининград", "улица Волкова, 101");
        $branches = BranchTable::listBranches();
        $createdBranch = $branches[0];
        $branchId = (int)$createdBranch['id'];

        $this->assertBranch($createdBranch, "Калининград", "улица Волкова, 101");

        WorkerTable::insertWorker($branchId, "Коля", "Богатов", "Ж.", "Разработчик");

        $workers = BranchDepartmentHandler::getBranchWorkers($branchId);
        $createdWorker = $workers[0];

        $this->assertNotEmpty($createdWorker);
        $this->assertWorker($createdWorker, "Коля", "Богатов", "Ж.", "Разработчик", "Please, add email");

        $this->assertBranch(BranchTable::findBranch($branchId)[0], "Калининград", "улица Волкова, 101", 1);

        WorkerTable::updateWorker(
            (int)$createdWorker['id'],
            $branchId,
            "Николай",
            "Богатовый",
            "Е.",
            "kolya.bogatoviy@mail.ru",
            "male",
            "2000-01-01",
            "2023-01-01",
            "Senior Developer",
            "Updated comment",
            "123-456-7890"
        );

        $updatedWorker = WorkerTable::findWorker((int)$createdWorker['id'])[0];
        $this->assertWorker($updatedWorker,
            "Николай",
            "Богатовый",
            "Е.",
            "Senior Developer",
            "kolya.bogatoviy@mail.ru",
            "male",
            "2000-01-01",
            "2023-01-01",
            "Updated comment",
            "123-456-7890"
        );

        WorkerTable::deleteWorker((int)$createdWorker['id']);

        $deletedWorker = WorkerTable::findWorker((int)$createdWorker['id']);
        $this->assertNull($deletedWorker);

        $this->assertBranch(BranchTable::findBranch($branchId)[0], "Калининград", "улица Волкова, 101");

        BranchTable::deleteBranch((int)$createdBranch['id']);

        $deletedBranch = BranchTable::findBranch((int)$createdBranch['id']);
        $this->assertNull($deletedBranch);
    }

    private function assertWorker(array $actualWorker, string $firstName, string $lastName, string $middleName, string $position, string $email = "", string $sex = "male", string $birthDate = "1985-09-20", string $hiringDate = "1985-09-20", string $comment = "Please, add comment", string $phoneNumber = "Please, add phone number"): void
    {
        $this->assertEquals($firstName, $actualWorker['first_name']);
        $this->assertEquals($lastName, $actualWorker['last_name']);
        $this->assertEquals($middleName, $actualWorker['middle_name']);
        $this->assertEquals($position, $actualWorker['position']);
        $this->assertEquals($email, $actualWorker['email']);
        $this->assertEquals($sex, $actualWorker['sex']);
        $this->assertEquals($birthDate, $actualWorker['birth_date']);
        $this->assertEquals($hiringDate, $actualWorker['hiring_date']);
        $this->assertEquals($comment, $actualWorker['comment']);
        $this->assertEquals($phoneNumber, $actualWorker['phone_number']);
    }

    /**
     * @throws \Exception
     */
    public function testSqlInjectionAndAddWorkerWithInvalidData(): void
    {
        BranchTable::insertBranch("'; DROP TABLE company_branch; -- Калининград ; DROP TABLE company_branch; --", "; DROP TABLE user; --");
        $branches = BranchTable::listBranches();
        $this->assertCount(1, $branches);
        $createdBranch = $branches[0];

        $this->assertNotEmpty($createdBranch);
        $this->assertBranch($createdBranch, "'; DROP TABLE company_branch; -- Калининград ; DROP TABLE company_branch; --", "; DROP TABLE user; --");
        $branchId = (int)$createdBranch['id'];

        try {
            WorkerTable::insertWorker($branchId, '', 'Богатов ; DROP TABLE user; --', 'Ж.', 'Разработчик');
            $this->fail('Inserted worker with empty name');
        } catch (\Exception $e) {
            $this->assertEquals('Invalid input data', $e->getMessage());
        }

        $workers = BranchDepartmentHandler::getBranchWorkers($branchId);
        $this->assertCount(0, $workers);

        //Cleanup
        BranchTable::deleteBranch((int)$createdBranch['id']);
    }
}