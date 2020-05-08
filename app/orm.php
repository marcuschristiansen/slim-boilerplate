<?php

declare(strict_types = 1);

use DI\ContainerBuilder;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
            EntityManagerInterface::class => function (ContainerInterface $c): EntityManager {
            $doctrineSettings = $c->get('settings')['doctrine'];

            $config = Setup::createAnnotationMetadataConfiguration(
                $doctrineSettings['metadata_dirs'],
                $doctrineSettings['dev_mode']
            );

            // $config->setMetadataDriverImpl(
            //     new AnnotationDriver(
            //         new AnnotationReader,
            //         $doctrineSettings['metadata_dirs']
            //     )
            // );

            $config->setMetadataDriverImpl(
                new MappingDriver()
            );

            $config->setMetadataCacheImpl(
                new FilesystemCache($doctrineSettings['cache_dir'])
            );

            return EntityManager::create($doctrineSettings['connection'], $config);
        }
    ]);
};
