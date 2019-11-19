<?php

namespace EPGImporter\Tests;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use EPGImporter\DataManager\DoctrineDataManager;
use PHPUnit\Framework\TestCase;

class DoctrineDataManagerTest extends TestCase
{
    private $em;

    public function setUp()
    {
        $this->em =  $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([])
            ->setMethods([
                'persist',
                'flush',
                'clear'
            ])
            ->getMock();

        $this->em->method('persist')->willReturn(NULL);
        $this->em->method('flush')->willReturn(NULL);
        $this->em->method('clear')->willReturn(NULL);
    }

    public function testGetPersistCallbackOneElement()
    {
        $this->em->expects($this->once())->method('persist');
        $this->em->expects($this->once())->method('flush');
        $this->em->expects($this->once())->method('clear');

        $dm = new DoctrineDataManager($this->em);
        ($dm->getPersistCallback())([new \stdClass()]);
    }

    public function testGetPersistCallbackTenElements()
    {
        $this->em->expects($this->exactly(10))->method('persist');
        $this->em->expects($this->once())->method('flush');
        $this->em->expects($this->once())->method('clear');

        $dm = new DoctrineDataManager($this->em);
        ($dm->getPersistCallback())(array_fill(0, 10, new \stdClass()));
    }

    private function getRepositoryMock()
    {
        return $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([])
            ->setMethods(['findOneBySourceId', 'findOneByType'])
            ->getMock();
    }

    public function testGetChannelCallback()
    {
        $getRepositoryMock = $this->getRepositoryMock();
        $getRepositoryMock->expects($this->once())->method('findOneBySourceId');

        $em = $this->createMock(EntityManager::class);
        $em->method('getRepository')->willReturn($getRepositoryMock);

        $em->expects($this->once())->method('getRepository');

        $dm = new DoctrineDataManager($em);
        ($dm->getChannelCallback())(10);
    }

    public function testGetShowTypeCallback()
    {
        $getRepositoryMock = $this->getRepositoryMock();
        $getRepositoryMock->expects($this->once())->method('findOneByType');

        $em = $this->createMock(EntityManager::class);
        $em->method('getRepository')->willReturn($getRepositoryMock);

        $em->expects($this->once())->method('getRepository');

        $dm = new DoctrineDataManager($em);
        ($dm->getShowTypeCallback())(10);
    }
}
