<?php
use classes\connection\OrgStructureConnection;
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/connection/OrgStructureConnection.class.php';

class BranchWorkersRequestTable
{
    /**
     * @return array
     */
    public static function GetInfoAboutBranchesWorkers(): array
    {
        $config = include $_SERVER['DOCUMENT_ROOT'] . '/classes/config/DbConfig.class.php';

        $conn = OrgStructureConnection::GetDbConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM user";
        $rows = [];
        if ($result = $conn->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $result->free();
        } else {
            echo "Ошибка: " . $conn->error;
        }
        $conn->close();
        return $rows;
    }
}