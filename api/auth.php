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

$action = $_GET['action'] ?? '';

if ($action === 'me') {
    jr_json_response([
        'success' => true,
        'user' => $_SESSION['user'] ?? null,
        'shop' => $_SESSION['shop'] ?? null,
    ]);
}

if ($action === 'logout') {
    $_SESSION = [];
    if (session_id() !== '') {
        session_destroy();
    }
    jr_json_response(['success' => true]);
}

if ($action !== 'login') {
    jr_json_response(['success' => false, 'message' => 'Unsupported action.'], 400);
}

$input = jr_request_body();
$username = trim((string) ($input['username'] ?? ''));
$password = trim((string) ($input['password'] ?? ''));

if ($username === '' || $password === '') {
    jr_json_response(['success' => false, 'message' => 'Username and password are required.'], 422);
}

try {
    $pdo = jr_db();
    $stmt = $pdo->prepare('SELECT id, username, password_hash, full_name, role, is_active FROM users WHERE username = :username LIMIT 1');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if (!$user || !(int) $user['is_active'] || !password_verify($password, $user['password_hash'])) {
        jr_json_response(['success' => false, 'message' => 'Invalid username or password.'], 401);
    }

    $shopStmt = $pdo->prepare(
        'SELECT s.id, s.shop_code, s.name, s.shop_type, s.location
         FROM shops s
         INNER JOIN user_shops us ON us.shop_id = s.id
         WHERE us.user_id = :user_id AND s.is_active = 1
         ORDER BY us.is_default DESC, s.id ASC
         LIMIT 1'
    );
    $shopStmt->execute(['user_id' => $user['id']]);
    $shop = $shopStmt->fetch();

    if (!$shop) {
        jr_json_response(['success' => false, 'message' => 'No shop assigned to this user.'], 403);
    }

    $_SESSION['user'] = [
        'id' => (int) $user['id'],
        'username' => $user['username'],
        'name' => $user['full_name'],
        'role' => $user['role'],
    ];
    $_SESSION['shop'] = [
        'id' => (int) $shop['id'],
        'code' => $shop['shop_code'],
        'name' => $shop['name'],
        'type' => $shop['shop_type'],
        'location' => $shop['location'],
    ];
    $_SESSION['shop_id'] = (int) $shop['id'];

    jr_json_response([
        'success' => true,
        'user' => $_SESSION['user'],
        'shop' => $_SESSION['shop'],
    ]);
} catch (Throwable $throwable) {
    jr_json_response(['success' => false, 'message' => 'Unable to authenticate right now.'], 500);
}
