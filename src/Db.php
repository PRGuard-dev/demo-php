<?php

declare(strict_types=1);

/**
 * Shared data helpers — the only sanctioned way to touch orders.
 *
 * Db::query() binds every value as a driver-level parameter, so SQL
 * injection is structurally impossible. Db::money() formats an integer
 * number of cents as currency without floating-point rounding. Business
 * code uses these helpers rather than rolling its own.
 */
final class Db
{
    private const DSN = 'sqlite:orders.db';

    /** Run $sql with $params bound by the driver; return all rows. */
    public static function query(string $sql, array $params = []): array
    {
        $pdo = new PDO(self::DSN, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Format an integer number of $cents as currency, e.g. 1299 → '$12.99'. */
    public static function money(int $cents): string
    {
        return sprintf('$%d.%02d', intdiv($cents, 100), $cents % 100);
    }
}
