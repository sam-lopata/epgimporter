<?php

namespace EPGImporter\Tests;

use EPGImporter\DataManager\DataManagerInterface;
use EPGImporter\Generator\FromXMLEntityGenerator;
use EPGImporter\Parser\XMLParser;
use EPGImporter\ParserManager\ParserManager;
use PHPUnit\Framework\TestCase;

class ParserManagerTest extends TestCase
{
    private const SIMPLE_SOURCE = "src/Tests/data/simple_service.xml";
    private const XSD_SCHEMA = 'src/Tests/data/event_schema.xsd';

    public function testParserManagerCreation()
    {
        $parser = $this->getMockBuilder(XMLParser::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([])
            ->setMethods([
                'setSource',
                'setChannelCallback',
                'setShowTypeCallback',
                'setEntityGenerator',
                'setPersistCallback',
                'run'
            ])
            ->getMock();

        $parser->method('setSource')->will($this->returnSelf());
        $parser->method('setChannelCallback')->will($this->returnSelf());
        $parser->method('setShowTypeCallback')->will($this->returnSelf());
        $parser->method('setEntityGenerator')->will($this->returnSelf());
        $parser->method('setPersistCallback')->will($this->returnSelf());

        $parser->expects($this->once())->method('setSource');
        $parser->expects($this->once())->method('setChannelCallback');
        $parser->expects($this->once())->method('setShowTypeCallback');
        $parser->expects($this->once())->method('setEntityGenerator');
        $parser->expects($this->once())->method('setPersistCallback');
        $parser->expects($this->once())->method('run');

        $dm = $this->createMock(DataManagerInterface::class);
        $parserManager = new ParserManager(
            $parser,
            $dm,
            new FromXMLEntityGenerator(self::XSD_SCHEMA),
            self::SIMPLE_SOURCE
        );
        $parserManager->process();

    }
}
