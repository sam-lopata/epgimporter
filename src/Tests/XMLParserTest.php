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

    public function testXMLParserCreate()
    {
        $loader = new XMLStreamFileLoader();
        $parser = new XMLParser($loader);

        $reflector = new \ReflectionClass($parser);
        $loaderProperty = $reflector->getProperty('loader');
        $loaderProperty->setAccessible(true);
        $this->assertInstanceOf(XMLStreamFileLoader::class, $loaderProperty->getValue($parser));

        $eg = new FromXMLEntityGenerator(self::XSD_SCHEMA);
        $parser->setEntityGenerator($eg);
        $reflector = new \ReflectionClass($parser);
        $entityGenerator = $reflector->getProperty('entityGenerator');
        $entityGenerator->setAccessible(true);
        $this->assertInstanceOf(FromXMLEntityGenerator::class, $entityGenerator->getValue($parser));

        $parser->setSource(self::SOURCE);
        $reflector = new \ReflectionClass($parser);
        $source = $reflector->getProperty('source');
        $source->setAccessible(true);
        $this->assertEquals(self::SOURCE, $source->getValue($parser));

        $chkStr = "setPersistCallback mock";
        $parser->setPersistCallback(function() use ($chkStr) {
            return $chkStr;
        });
        $reflector = new \ReflectionClass($parser);
        $persistCallback = $reflector->getProperty('persistCallback');
        $persistCallback->setAccessible(true);
        $this->assertEquals($chkStr, $persistCallback->getValue($parser)());

        $chkStr = "setChannelCallback mock";
        $parser->setChannelCallback(function() use ($chkStr) {
            return $chkStr;
        });
        $reflector = new \ReflectionClass($parser);
        $channelCallback = $reflector->getProperty('channelCallback');
        $channelCallback->setAccessible(true);
        $this->assertEquals($chkStr, $channelCallback->getValue($parser)());

        $chkStr = "setShowTypeCallback mock";
        $parser->setShowTypeCallback(function() use ($chkStr) {
            return $chkStr;
        });
        $reflector = new \ReflectionClass($parser);
        $showTypeCallback = $reflector->getProperty('showTypeCallback');
        $showTypeCallback->setAccessible(true);
        $this->assertEquals($chkStr, $showTypeCallback->getValue($parser)());
    }

    public function testXMLParserRun()
    {
        $loader = new XMLStreamFileLoader();
        $parser = new XMLParser($loader);

        $entities = [];
        $parser->setSource(self::SIMPLE_SOURCE)
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
