<?php
// Quick DB connection test - DELETE after testing
require_once __DIR__ . '/config/database.php';

try {
    $pdo = jr_db();
    echo "✓ Database connection successful!\n\n";
    
    $stmt = $pdo->prepare('SELECT id, username, is_active FROM users LIMIT 5');
    $stmt->execute();
    $users = $stmt->fetchAll();
    
    echo "Users in database:\n";
    if (empty($users)) {
        echo "  No users found!\n";
    } else {
        foreach ($users as $user) {
            echo "  - ID: {$user['id']}, Username: {$user['username']}, Active: {$user['is_active']}\n";
        }
    }
    
    echo "\n";
    $shopStmt = $pdo->prepare('SELECT id, shop_code, name FROM shops');
    $shopStmt->execute();
    $shops = $shopStmt->fetchAll();
    echo "Shops in database:\n";
    foreach ($shops as $shop) {
        echo "  - ID: {$shop['id']}, Code: {$shop['shop_code']}, Name: {$shop['name']}\n";
    }
    
} catch (Throwable $e) {
    echo "✗ Database connection failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
}
?>
