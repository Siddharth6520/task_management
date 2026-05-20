<?php

namespace App\DB;

use MongoDB\Client;

use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;

use Doctrine\ODM\MongoDB\Mapping\Driver\AttributeDriver;

class DBConnection
{
    public function dbConnection(): DocumentManager
    {
        $client = new Client( env('MONGODB_URI'));
// config contains db,driver,proxy,hydrator
        $config = new Configuration();

        $config->setDefaultDB(env('MONGODB_DATABASE'));

        $config->setMetadataDriverImpl(new AttributeDriver([ app_path('Documents')
            ])
        );


        $config->setProxyDir(
            storage_path('doctrine/proxies')
        );

        $config->setProxyNamespace(
            'DoctrineProxies'
        );
        $config->setHydratorDir(
            storage_path('doctrine/hydrators')
        );

        $config->setHydratorNamespace(
            'DoctrineHydrators'
        );

        return DocumentManager::create(
            $client,
            $config
        );
    }
}