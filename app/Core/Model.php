<?php

namespace App\Core;

use PDO;
use PDOStatement;

abstract class Model
{
    protected static string $table;

    protected static function db(): PDO
    {
        return Database::connection();
    }

    protected static function query(string $sql, array $bindings = []): PDOStatement
    {
        $statement = static::db()->prepare($sql);
        $statement->execute($bindings);

        return $statement;
    }

    public static function find(int $id): ?array
    {
        $statement = static::query('SELECT * FROM ' . static::$table . ' WHERE id = ? LIMIT 1', [$id]);

        return $statement->fetch() ?: null;
    }

    public static function findBy(string $column, mixed $value): ?array
    {
        $statement = static::query('SELECT * FROM ' . static::$table . " WHERE $column = ? LIMIT 1", [$value]);

        return $statement->fetch() ?: null;
    }

    public static function all(string $orderBy = 'id DESC'): array
    {
        return static::query('SELECT * FROM ' . static::$table . ' ORDER BY ' . $orderBy)->fetchAll();
    }

    public static function insert(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            static::$table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        static::query($sql, array_values($data));

        return (int) static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $assignments = implode(', ', array_map(fn (string $column) => "$column = ?", array_keys($data)));
        $bindings = [...array_values($data), $id];

        $statement = static::query('UPDATE ' . static::$table . " SET $assignments WHERE id = ?", $bindings);

        return $statement->rowCount() > 0;
    }

    public static function delete(int $id): bool
    {
        $statement = static::query('DELETE FROM ' . static::$table . ' WHERE id = ?', [$id]);

        return $statement->rowCount() > 0;
    }

    public static function beginTransaction(): void
    {
        static::db()->beginTransaction();
    }

    public static function commit(): void
    {
        static::db()->commit();
    }

    public static function rollBack(): void
    {
        if (static::db()->inTransaction()) {
            static::db()->rollBack();
        }
    }

    public static function inTransaction(): bool
    {
        return static::db()->inTransaction();
    }
}
