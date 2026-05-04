<?php
// Test login API - DELETE after testing

require_once __DIR__ . '/config/database.php';

$username = 'admin';
$password = 'admin123';

echo "Testing login for: $username\n\n";

try {
    $pdo = jr_db();
    $stmt = $pdo->prepare('SELECT id, username, password_hash, full_name, role, is_active FROM users WHERE username = :username LIMIT 1');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "✗ User not found!\n";
        exit;
    }

    echo "✓ User found: {$user['full_name']} (ID: {$user['id']})\n";
    echo "  Active: " . ($user['is_active'] ? 'Yes' : 'No') . "\n";
    echo "  Password hash: {$user['password_hash']}\n\n";

    $pwMatch = password_verify($password, $user['password_hash']);
    echo "Password verification: " . ($pwMatch ? "✓ MATCH" : "✗ NO MATCH") . "\n";

    if (!$pwMatch) {
        echo "\nThe password hash is wrong. Generate a new one:\n";
        $newHash = password_hash('admin123', PASSWORD_BCRYPT);
        echo "  New hash: $newHash\n";
        echo "\nRun this SQL:\n";
        echo "  UPDATE users SET password_hash = '$newHash' WHERE username = 'admin';\n";
    } else {
        echo "\nPassword is correct. The problem is elsewhere (likely .htaccess rewriting /api/ calls).\n";
    }

} catch (Throwable $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
