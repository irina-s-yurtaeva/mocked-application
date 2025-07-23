<?php
return [
    'name' => 'BitrixApp Migrations',
    'migrations_namespace' => 'MockedApplication\\Migrations',
    'table_name' => 'migration_versions',
    'column_name' => 'version',
    'executed_at_column_name' => 'executed_at',
    'migrations_directory' => __DIR__.'/migrations',
    'all_or_nothing' => true,
    'check_database_platform' => true,
];
