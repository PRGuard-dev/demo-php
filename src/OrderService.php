<?php

declare(strict_types=1);

require_once __DIR__ . '/Db.php';

/**
 * Order lookup service — PRGuard demo (PHP).
 *
 * A minimal slice of a shop backend. All data access goes through the
 * shared helpers in src/Db.php: Db::query() for parameter-bound SQL and
 * Db::money() for currency formatting — business code never rolls its own.
 */
final class OrderService
{
    /** Fetch a single order by primary key. */
    public function getOrder(int $orderId): ?array
    {
        $rows = Db::query(
            'SELECT id, total_cents, status FROM orders WHERE id = ?',
            [$orderId]
        );

        return $rows[0] ?? null;
    }

    /** Return the formatted total for an order, or null if it is missing. */
    public function orderTotal(int $orderId): ?string
    {
        $order = $this->getOrder($orderId);

        return $order === null ? null : Db::money((int) $order['total_cents']);
    }
}
