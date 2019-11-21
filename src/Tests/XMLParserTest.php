<?php

namespace EPGImporter\Tests;

use EPGImporter\Entity\ServiceLivetvChannel;
use EPGImporter\Entity\ServiceLivetvSchedule;
use EPGImporter\Entity\ServiceLivetvShowType;
use EPGImporter\Generator\FromXMLEntityGenerator;
use EPGImporter\Loader\XMLStreamFileLoader;
use EPGImporter\Parser\XMLParser;
use PHPUnit\Framework\TestCase;

class XMLParserTest extends TestCase
{
    private const SOURCE = "src/Tests/data/test_data.xml";
    private const SIMPLE_SOURCE = "src/Tests/data/simple_service.xml";
    private const XSD_SCHEMA = 'src/Tests/data/event_schema.xsd';

    public function setUp()
    {
        $this->loader = new XMLStreamFileLoader();
        $this->parser = new XMLParser($this->loader);
    }

    public function testLoaderSet()
    {
        $reflector = new \ReflectionClass($this->parser);
        $loaderProperty = $reflector->getProperty('loader');
        $loaderProperty->setAccessible(true);
        $this->assertInstanceOf(XMLStreamFileLoader::class, $loaderProperty->getValue($this->parser));
    }

    public function testEtityGeneratorSet()
    {
        $eg = new FromXMLEntityGenerator(self::XSD_SCHEMA);
        $this->parser->setEntityGenerator($eg);
        $reflector = new \ReflectionClass($this->parser);
        $entityGenerator = $reflector->getProperty('entityGenerator');
        $entityGenerator->setAccessible(true);
        $this->assertInstanceOf(FromXMLEntityGenerator::class, $entityGenerator->getValue($this->parser));
    }

    public function testSourceSet()
    {
        $this->parser->setSource(self::SOURCE);
        $reflector = new \ReflectionClass($this->parser);
        $source = $reflector->getProperty('source');
        $source->setAccessible(true);
        $this->assertEquals(self::SOURCE, $source->getValue($this->parser));
    }

    public function testPersistCallbackSet()
    {
        $chkStr = "setPersistCallback mock";
        $this->parser->setPersistCallback(function() use ($chkStr) {
            return $chkStr;
        });
        $reflector = new \ReflectionClass($this->parser);
        $persistCallback = $reflector->getProperty('persistCallback');
        $persistCallback->setAccessible(true);
        $this->assertEquals($chkStr, $persistCallback->getValue($this->parser)());
    }

    public function testChannelCallbackSet()
    {
        $chkStr = "setChannelCallback mock";
        $this->parser->setChannelCallback(function() use ($chkStr) {
            return $chkStr;
        });
        $reflector = new \ReflectionClass($this->parser);
        $channelCallback = $reflector->getProperty('channelCallback');
        $channelCallback->setAccessible(true);
        $this->assertEquals($chkStr, $channelCallback->getValue($this->parser)());
    }

    public function testShowTypeCallback()
    {
        $chkStr = "setShowTypeCallback mock";
        $this->parser->setShowTypeCallback(function() use ($chkStr) {
            return $chkStr;
        });
        $reflector = new \ReflectionClass($this->parser);
        $showTypeCallback = $reflector->getProperty('showTypeCallback');
        $showTypeCallback->setAccessible(true);
        $this->assertEquals($chkStr, $showTypeCallback->getValue($this->parser)());
    }

    public function testXMLParserRun()
    {
        $entities = [];
        $this->parser->setSource(self::SIMPLE_SOURCE)
            ->setPersistCallback(function($input) use (&$entities) {
                $entities[] = $input;
            })
            ->setChannelCallback(function() {
                return new ServiceLivetvChannel();
            })
            ->setShowTypeCallback(function() {
                return new ServiceLivetvShowType();
            })
            ->setEntityGenerator(
                new FromXMLEntityGenerator(self::XSD_SCHEMA)
            )
            ->run();

        $this->assertInstanceOf(\SplFixedArray::class, $entities[0]);
        $this->assertInstanceOf(ServiceLivetvSchedule::class, $entities[0][0]);
    }

}
