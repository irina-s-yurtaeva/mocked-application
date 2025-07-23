#!/usr/bin/env php
<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;

require __DIR__ . '/../vendor/autoload.php';

$config = new PhpFile(__DIR__ . '/../migrations.php');
$em = EntityManager::create(
    ['url' => getenv('DATABASE_URL')],
    ORMSetup::createAttributeMetadataConfiguration([__DIR__.'/../src/Domain/Entity'], true)
);
$dependencyFactory = DependencyFactory::fromEntityManager($config, new ExistingEntityManager($em));

$dependencyFactory->getMigrator()->migrate();
