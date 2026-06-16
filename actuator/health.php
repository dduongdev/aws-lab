<?php
/**
 * Health check endpoint — returns HTTP 200 with status info.
 *
 * Compatible with AWS ALB target group health checks,
 * ECS / EKS liveness probes, and container orchestrators.
 *
 * Usage: GET /actuator/health.php  →  HTTP 200  {"status":"UP"}
 */

header('Content-Type: application/json; charset=utf-8');
http_response_code(200);

$response = [
    'status'  => 'UP',
    'timestamp' => date('c'),
];

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
