<?php

require __DIR__ . '/../vendor/autoload.php';

$sourceHost = getenv('SOURCE_DB_HOST') ?: '127.0.0.1';
$sourcePort = getenv('SOURCE_DB_PORT') ?: '3308';
$sourceName = getenv('SOURCE_DB_DATABASE') ?: 'mafportal';
$sourceUser = getenv('SOURCE_DB_USERNAME') ?: 'root';
$sourcePassword = getenv('SOURCE_DB_PASSWORD') ?: 'root';
$targetPath = __DIR__ . '/../database/database.sqlite';

$mysql = new PDO(
    "mysql:host={$sourceHost};port={$sourcePort};dbname={$sourceName};charset=utf8mb4",
    $sourceUser,
    $sourcePassword,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);
$sqlite = new PDO('sqlite:' . $targetPath, null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$sourceTables = [];
foreach ($mysql->query('SHOW TABLES') as $row) {
    $sourceTables[] = reset($row);
}

$targetTables = [];
foreach ($sqlite->query("SELECT name FROM sqlite_master WHERE type = 'table' AND name NOT LIKE 'sqlite_%'") as $row) {
    $targetTables[] = $row['name'];
}

$quote = function ($name) {
    return '`' . str_replace('`', '``', $name) . '`';
};

$sqlite->exec('PRAGMA foreign_keys = OFF');
$summary = [];

foreach ($targetTables as $table) {
    if (!in_array($table, $sourceTables, true)) {
        $summary[] = "SKIP {$table}: missing from source";
        continue;
    }

    $sourceColumns = [];
    foreach ($mysql->query('SHOW COLUMNS FROM ' . $quote($table)) as $column) {
        $sourceColumns[] = $column['Field'];
    }

    $targetColumns = [];
    $targetDefinitions = [];
    foreach ($sqlite->query('PRAGMA table_info(' . $quote($table) . ')') as $column) {
        $targetColumns[] = $column['name'];
        $targetDefinitions[$column['name']] = $column;
    }

    $columns = array_values(array_intersect($targetColumns, $sourceColumns));
    if (!$columns) {
        $summary[] = "SKIP {$table}: no shared columns";
        continue;
    }

    $columnList = implode(', ', array_map($quote, $columns));
    $placeholders = implode(', ', array_fill(0, count($columns), '?'));
    $insert = $sqlite->prepare(
        'INSERT INTO ' . $quote($table) . ' (' . $columnList . ') VALUES (' . $placeholders . ')'
    );

    $sqlite->exec('DELETE FROM ' . $quote($table));
    $count = 0;
    $sqlite->beginTransaction();
    try {
        $select = $mysql->query('SELECT ' . $columnList . ' FROM ' . $quote($table));
        foreach ($select as $row) {
            $values = [];
            foreach ($columns as $column) {
                $value = $row[$column];
                if ($value === null && (int) $targetDefinitions[$column]['notnull'] === 1) {
                    $value = stripos($targetDefinitions[$column]['type'], 'INT') !== false ? 0 : '';
                }
                $values[] = $value;
            }
            $insert->execute($values);
            $count++;
        }
        $sqlite->commit();
    } catch (Throwable $exception) {
        $sqlite->rollBack();
        throw $exception;
    }

    $summary[] = "OK {$table}: {$count} rows";
}

$sqlite->exec("UPDATE slides SET image = '/uploads/admin/slider/f254041f5054cd6bb5e6728029fa13bf.jpg' WHERE image = '/uploads/admin/slider/cbac5643dd3acdba4d74664778392ca8.jpg'");

$sqlite->exec('PRAGMA foreign_keys = ON');

echo implode(PHP_EOL, $summary) . PHP_EOL;
