<?php
declare(strict_types=1);

namespace App\Tests\Common;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\Connection\ConnectionProvider;
use PHPUnit\Framework\TestCase;

abstract class AbstractDatabaseTestCase extends TestCase
{
    private \mysqli $connection;


    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->connection = ConnectionProvider::getConnection();
        $this->connection->begin_transaction();
    }

    protected function tearDown(): void
    {
        $this->connection->rollback();
        ConnectionProvider::closeConnection();
        parent::tearDown();
    }

    final protected function getConnection(): \mysqli
    {
        return $this->connection;
    }
}
