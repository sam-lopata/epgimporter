<?php

namespace EPGImporter;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Gedmo\Timestampable\TimestampableListener;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class DoctrineEntityManagerFactory
{
    /** @var ContainerBagInterface */
    private $params;

    /**
     * @var bool
     */
    private $devMode;

    /**
     * DoctrineEntityManagerFactory constructor.
     *
     * @param ContainerBagInterface $params
     */
    public function __construct(ContainerBagInterface $params)
    {
        $this->params = $params->get('doctrine');
        $this->devMode = $params->get('dev_mode');
    }

    /**
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     *
     * @return EntityManager
     */
    public function createEntityManager() : EntityManager
    {
        $connection = $this->params['connection'] ?? null;
        if (null === $connection) {
            throw new InvalidConfigurationException('[connection] doctrine config section must present');
        }
        $metadata_dirs = $this->params['metadata_dirs'] ?? null;
        if (null === $metadata_dirs) {
            throw new InvalidConfigurationException('[metadata_dirs] doctrine config option must present');
        }
        $use_cache = $this->params['use_cache'] ?? null;
        $cache  = $this->params['cache'] ?? null;
        $cache_dir = $this->params['cache_dir'] ?? null;

        // doctrine metadata config
        $metadataConfig = Setup::createAnnotationMetadataConfiguration(
            $this->params['metadata_dirs'],
            $this->devMode
        );

        $annotationReader = new AnnotationReader();
        if ($use_cache ) {
            if (is_null($cache)) {
                throw new InvalidConfigurationException('Specify [cache] doctrine config option or disable [use_cache]');
            }
            if (is_null($cache_dir)) {
                throw new InvalidConfigurationException('Specify [cache_dir] doctrine config option or disable [use_cache]');
            }
            $metadataConfig->setMetadataCacheImpl(
                new $cache($cache_dir)
            );
            $metadataConfig->setQueryCacheImpl(
                new $cache($cache_dir)
            );
            $metadataConfig->setResultCacheImpl(
                new $cache($cache_dir)
            );
            $annotationReader = new CachedReader(
                $annotationReader,
                new $cache($cache_dir)
            );
        }

        // Add Gedmo extensions
        $driverChain = new MappingDriverChain();
        \Gedmo\DoctrineExtensions::registerAbstractMappingIntoDriverChainORM($driverChain, $annotationReader);

        // Set up driver to read annotations from entities
        $annotationDriver = new AnnotationDriver($annotationReader, $this->params['metadata_dirs']);
        $driverChain->addDriver($annotationDriver, "EPGImporter\Entity");
        $metadataConfig->setMetadataDriverImpl($driverChain);

        // create event manager and hook prefered extension listeners
        $evm = new EventManager();

        //timestampable extension
        $timestampableListener = new TimestampableListener();
        $timestampableListener->setAnnotationReader($annotationReader);
        $evm->addEventSubscriber($timestampableListener);

        return EntityManager::create($connection, $metadataConfig, $evm);
    }
}
