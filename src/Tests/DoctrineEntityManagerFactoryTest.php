<?php

namespace EPGImporter\Tests;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use EPGImporter\DoctrineEntityManagerFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBag;
use TypeError;

class DoctrineEntityManagerFactoryTest extends TestCase
{
    /** @var Container */
    private $container;

    /** @var ContainerBag */
    private $cb;

    public function getConstructParamsFixtures()
    {
        return [
            [
                [],
                ParameterNotFoundException::class,
                "You have requested a non-existent parameter \"doctrine\"."
            ],
            [
                ['dev_mode' => 'dev_mode param'],
                ParameterNotFoundException::class,
                "You have requested a non-existent parameter \"doctrine\"."

            ],
            [
                ['doctrine' => 'doctrine param'],
                ParameterNotFoundException::class,
                "You have requested a non-existent parameter \"dev_mode\"."
            ],
            [
                [
                    'doctrine' => 'doctrine param',
                    'dev_mode' => 'dev_mode param'
                ],
                null,
                null
            ]
        ];
    }

    public function getCreateEntitiesFixtures()
    {
        return [
            [
                [
                    'doctrine' => 'doctrine param',
                    'dev_mode' => 'dev_mode param'
                ],
                InvalidConfigurationException::class,
                '[connection] doctrine config section must present'
            ],
            [
                [
                    'doctrine' => [
                        'connection' => []
                    ],
                    'dev_mode' => 'dev_mode param'
                ],
                InvalidConfigurationException::class,
                '[metadata_dirs] doctrine config option must present'
            ],
            [
                [
                    'doctrine' => [
                        'connection' => [],
                        'metadata_dirs' => ''
                    ],
                    'dev_mode' => 'dev_mode param'
                ],
                TypeError::class,
                'Argument 1 passed to Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration() must be of the type array'
            ],
            [
                [
                    'doctrine' => [
                        'connection' => [],
                        'metadata_dirs' => []
                    ],
                    'dev_mode' => 'dev_mode param'
                ],
                DBALException::class,
                'The options \'driver\' or \'driverClass\' are mandatory if no PDO instance is given to DriverManager::getConnection().'
            ],
            [
                [
                    'doctrine' => [
                        'connection' => [
                            'driver' => 'pdo_mysql'
                        ],
                        'metadata_dirs' => []
                    ],
                    'dev_mode' => 'dev_mode param'
                ],
                null,
                null
            ],
            [
                [
                    'doctrine' => [
                        'use_cache' => true,
                        'connection' => [
                            'driver' => 'pdo_mysql'
                        ],
                        'metadata_dirs' => []
                    ],
                    'dev_mode' => 'dev_mode param'
                ],
                InvalidConfigurationException::class,
                'Specify [cache] doctrine config option or disable [use_cache]'
            ],
            [
                [
                    'doctrine' => [
                        'use_cache' => true,
                        'cache' => ArrayCache::class,
                        'connection' => [
                            'driver' => 'pdo_mysql'
                        ],
                        'metadata_dirs' => []
                    ],
                    'dev_mode' => 'dev_mode param'
                ],
                InvalidConfigurationException::class,
                'Specify [cache_dir] doctrine config option or disable [use_cache]'
            ],
            [
                [
                    'doctrine' => [
                        'use_cache' => true,
                        'cache' => ArrayCache::class,
                        'cache_dir' => 'var/cache',
                        'connection' => [
                            'driver' => 'pdo_mysql'
                        ],
                        'metadata_dirs' => []
                    ],
                    'dev_mode' => 'dev_mode param'
                ],
                null,
                null
            ],
        ];
    }

    public function setUp()
    {
        $this->container = new Container();
        $this->cb = new ContainerBag($this->container);
    }

    /**
     * @dataProvider getConstructParamsFixtures
     */
    public function testConstructParams($params, $exceptionClass = null, $exceptionMessage = null)
    {
        foreach ($params as $k=>$v) {
            $this->container->setParameter($k, $v);
        }

        if (null !== $exceptionClass) {
            $this->expectException($exceptionClass);
            $this->expectExceptionMessage($exceptionMessage);
            (new DoctrineEntityManagerFactory($this->cb))();
        }
        else {
            $this->assertInstanceOf(DoctrineEntityManagerFactory::class, new DoctrineEntityManagerFactory($this->cb));
        }
    }

    /**
     * @dataProvider getCreateEntitiesFixtures
     */
    public function testCreateEntityManagerParams($params, $exceptionClass = null, $exceptionMessage = null)
    {
        foreach ($params as $k=>$v) {
            $this->container->setParameter($k, $v);
        }

        $emf = new DoctrineEntityManagerFactory($this->cb);
        $this->assertInstanceOf(DoctrineEntityManagerFactory::class, $emf);

        if (null !== $exceptionClass) {
            $this->expectException($exceptionClass);
            $this->expectExceptionMessage($exceptionMessage);
            $emf->createEntityManager();
        }
        else {
            $this->assertInstanceOf(EntityManager::class, $emf->createEntityManager());
        }

    }
}
