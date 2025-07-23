#!/usr/bin/env php
<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingConnection;

require __DIR__ . '/../vendor/autoload.php';

$config = new PhpFile(__DIR__ . '/../migrations.php');
$connection = DriverManager::getConnection(['url' => getenv('DATABASE_URL')]);
$dependencyFactory = DependencyFactory::fromConnection($config, new ExistingConnection($connection));

$dependencyFactory->getMigrator()->migrate();
