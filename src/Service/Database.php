<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 16.03.16
 * Time: 12:52
 */

namespace App\Service;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;

class Database
{
    public $em;

    public function __construct(Config $config)
    {
        $this->em = EntityManager::create(
            [
                'dbname' => $config->get('db.name'),
                'user' => $config->get('db.user'),
                'password' => $config->get('db.pass'),
                'host' => $config->get('db.host'),
                'driver' => 'pdo_mysql',
            ],
            Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../Entity'], false, __DIR__ . '/../../cache/doctrine')
        );
    }

    public function getLoader($entity)
    {
        try {
            return $this->em->getUnitOfWork()->getEntityPersister($entity);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function createSchema()
    {
        if (!$this->em->getConnection()->getSchemaManager()->listTables()) {
            $tool = new SchemaTool($this->em);
            $tool->createSchema(
                [
                    $this->em->getClassMetadata('App\Entity\Content'),
                    $this->em->getClassMetadata('App\Entity\ContentData'),
                    $this->em->getClassMetadata('App\Entity\ContentCategory')
                ]
            );
        }
    }

    public function dropSchema()
    {
        $tool = new SchemaTool($this->em);
        $tool->dropSchema(
            [
                $this->em->getClassMetadata('App\Entity\Content'),
                $this->em->getClassMetadata('App\Entity\ContentData'),
                $this->em->getClassMetadata('App\Entity\ContentCategory')
            ]
        );
    }
} 