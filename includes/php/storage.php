<?php

declare(strict_types=1);

function jr_state_keys(): array
{
    return [
        'jr_products',
        'jr_customers',
        'jr_suppliers',
        'jr_payments',
        'jr_purchases',
        'jr_expenses',
        'jr_expense_categories',
        'jr_sale_returns',
        'jr_purchase_returns',
        'jr_drafts',
        'jr_quotations',
        'jr_credit_sales',
        'jr_suspended',
        'jr_invoice_counter',
        'jr_units',
        'jr_categories',
        'jr_brands',
    ];
}

function jr_default_state_value(string $key): string
{
    return in_array($key, ['jr_invoice_counter'], true) ? '739' : '[]';
}

function jr_load_state(PDO $pdo, int $shopId): array
{
    $stmt = $pdo->prepare('SELECT state_key, state_value FROM app_state WHERE shop_id = :shop_id');
    $stmt->execute(['shop_id' => $shopId]);

    $state = [];
    foreach ($stmt->fetchAll() as $row) {
        $state[$row['state_key']] = (string) $row['state_value'];
    }

    return $state;
}

function jr_upsert_state(PDO $pdo, int $shopId, string $key, string $value): void
{
    $stmt = $pdo->prepare(
        'INSERT INTO app_state (shop_id, state_key, state_value)
         VALUES (:shop_id, :state_key, :state_value)
         ON DUPLICATE KEY UPDATE state_value = VALUES(state_value), updated_at = CURRENT_TIMESTAMP'
    );

    $stmt->execute([
        'shop_id' => $shopId,
        'state_key' => $key,
        'state_value' => $value,
    ]);
}

function jr_delete_state(PDO $pdo, int $shopId, string $key): void
{
    $stmt = $pdo->prepare('DELETE FROM app_state WHERE shop_id = :shop_id AND state_key = :state_key');
    $stmt->execute([
        'shop_id' => $shopId,
        'state_key' => $key,
    ]);
}

function jr_clear_state(PDO $pdo, int $shopId): void
{
    $stmt = $pdo->prepare('DELETE FROM app_state WHERE shop_id = :shop_id');
    $stmt->execute(['shop_id' => $shopId]);
}
