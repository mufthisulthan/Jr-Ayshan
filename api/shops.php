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

if (!isset($_SESSION['user'])) {
    jr_json_response(['success' => false, 'message' => 'Unauthorized.'], 401);
}

try {
    $pdo = jr_db();
    $stmt = $pdo->prepare(
        'SELECT s.id, s.shop_code, s.name, s.shop_type, s.location, us.is_default
         FROM shops s
         INNER JOIN user_shops us ON us.shop_id = s.id
         WHERE us.user_id = :user_id AND s.is_active = 1
         ORDER BY us.is_default DESC, s.id ASC'
    );
    $stmt->execute(['user_id' => $_SESSION['user']['id']]);

    jr_json_response([
        'success' => true,
        'shops' => $stmt->fetchAll(),
        'currentShopId' => $_SESSION['shop_id'] ?? null,
    ]);
} catch (Throwable $throwable) {
    jr_json_response(['success' => false, 'message' => 'Unable to load shops.'], 500);
}
