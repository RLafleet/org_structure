<?php

namespace App\DbTable;

require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;

class RoleRequestTable
{
    /**
     * @param int $user_id
     * @param int $requested_role
     * @return void
     * @throws \Exception
     */
    public static function createRequest(int $user_id, int $requested_role): void
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "INSERT INTO role_requests (user_id, requested_role) 
                VALUES (
                    " . $connectionProvider->Quote($user_id) . ",
                    " . $connectionProvider->Quote($requested_role) . "
                )";

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to create role request");
        }
    }

    /**
     * @return array
     */
    public static function getAllRequests(): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM role_requests WHERE status = 'pending'";
        return $connectionProvider->Fetch($sql);
    }

    /**
     * @param int $request_id ID запроса.
     * @return void
     * @throws \Exception
     */
    public static function approveRequest(int $request_id): void
    {
        $connectionProvider = new ConnectionProvider();

        $sql = "SELECT user_id, requested_role FROM role_requests WHERE id = " . $connectionProvider->Quote($request_id);
        $request = $connectionProvider->Fetch($sql);

        if (empty($request)) {
            throw new \Exception("Request not found");
        }

        $user_id = $request[0]['user_id'];
        $requested_role = $request[0]['requested_role'];

        $updateRoleSql = "INSERT INTO employee_role (employee_id, role_name, accessibility) 
                      VALUES (
                          " . $connectionProvider->Quote($user_id) . ",
                          'user',
                          " . $connectionProvider->Quote($requested_role) . "
                      )
                      ON DUPLICATE KEY UPDATE
                          role_name = 'user',
                          accessibility = " . $connectionProvider->Quote($requested_role);

        $result = $connectionProvider->RealQuery($updateRoleSql);

        if (!$result) {
            throw new \Exception("Failed to update user role");
        }

        $updateRequestSql = "UPDATE role_requests SET status = 'approved' WHERE id = " . $connectionProvider->Quote($request_id);
        $result = $connectionProvider->RealQuery($updateRequestSql);

        if (!$result) {
            throw new \Exception("Failed to approve role request");
        }
    }

    /**
     * @param int $request_id ID запроса.
     * @return void
     * @throws \Exception
     */
    public static function rejectRequest(int $request_id): void
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "UPDATE role_requests SET status = 'rejected' WHERE id = " . $connectionProvider->Quote($request_id);
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to reject role request");
        }
    }
}