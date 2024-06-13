<?php
declare(strict_types=1);

namespace Common;

use App\Common\Database\Connection;
use App\Common\Database\ConnectionProvider;
use PHPUnit\Framework\TestCase;

abstract class AbstractDatabaseTestCase extends TestCase
{
    private Connection $connection;

    // Вызывается перед каждым тестирующим методом
    protected function setUp(): void
    {
        parent::setUp();
        // Всегда начинаем транзакцию, чтобы не применять изменений к базе данных.
        $this->connection = ConnectionProvider::getConnection();
        $this->connection->beginTransaction();
    }

    // Вызывается после каждого тестирующего метода
    protected function tearDown(): void
    {
        // Всегда откатываем транзакцию, чтобы не применять изменений к базе данных.
        $this->connection->rollback();
        parent::tearDown();
    }

    final protected function getConnection(): Connection
    {
        return $this->connection;
    }
}