#!/usr/bin/env php
<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\DBAL\DriverManager;

require __DIR__ . '/../vendor/autoload.php';

$config = new ConfigurationArray([
    'name' => 'BitrixApp Migrations',
    'migrations_namespace' => 'MockedApplication\\Migrations',
    'table_storage' => [
        'table_name' => 'migration_versions',
        'version_column_name' => 'version',
        'executed_at_column_name' => 'executed_at',
    ],
    'migrations_paths' => [
        'MockedApplication\\Migrations' => __DIR__.'/../migrations',
    ],
    'all_or_nothing' => true,
    'check_database_platform' => true,
]);

$connectionParams = [
    'driver' => 'pdo_mysql',
    'host' => getenv('DB_HOST') ?: 'localhost',
    'dbname' => getenv('DB_NAME'),
    'user' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'charset' => 'utf8mb4',
];

$connection = DriverManager::getConnection($connectionParams);
$em = new EntityManager($connection, ORMSetup::createAttributeMetadataConfiguration([__DIR__.'/../src/Domain/Entity'], true));

$dependencyFactory = DependencyFactory::fromEntityManager($config, new ExistingEntityManager($em));

$dependencyFactory->getMigrator()->migrate();
