<?php

namespace App\Controllers;

use App\Core\Database;
use Throwable;

class HealthController
{
    public function index(): void
    {
        header('Content-Type: application/json');

        try {
            Database::getConnection();

            echo json_encode([
                'status' => 'ok',
                'database' => 'connected',
                'service' => 'training-center-crm-lab05',
            ]);
        } catch (Throwable $e) {
            http_response_code(500);

            echo json_encode([
                'status' => 'error',
                'database' => 'disconnected',
                'service' => 'training-center-crm-lab05',
            ]);
        }
    }
}