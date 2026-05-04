<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/php/runtime.php';

header('Content-Type: application/json; charset=utf-8');

function jr_json_response(array $payload, int $status = 200): never
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function jr_request_body(): array
{
    $body = file_get_contents('php://input');
    if ($body === false || $body === '') {
        return [];
    }

    $decoded = json_decode($body, true);
    return is_array($decoded) ? $decoded : [];
}

if (!isset($_SESSION['shop_id'])) {
    jr_json_response(['success' => false, 'message' => 'Unauthorized.'], 401);
}

$input = jr_request_body();
$action = (string) ($input['action'] ?? 'set');
$key = (string) ($input['key'] ?? '');
$value = (string) ($input['value'] ?? '');
$shopId = (int) $_SESSION['shop_id'];

if ($action === 'clear') {
    jr_clear_state(jr_db(), $shopId);
    jr_json_response(['success' => true]);
}

if ($key === '') {
    jr_json_response(['success' => false, 'message' => 'State key is required.'], 422);
}

if ($action === 'remove') {
    jr_delete_state(jr_db(), $shopId, $key);
    jr_json_response(['success' => true]);
}

jr_upsert_state(jr_db(), $shopId, $key, $value);
jr_json_response(['success' => true]);
