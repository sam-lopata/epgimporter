<?php

namespace EPGImporter\Tests;

use EPGImporter\Entity\ServiceLivetvChannel;
use EPGImporter\Entity\ServiceLivetvProgram;
use EPGImporter\Entity\ServiceLivetvSchedule;
use EPGImporter\Entity\ServiceLivetvShowType;
use EPGImporter\Generator\FromXMLEntityGenerator;
use PHPUnit\Framework\TestCase;

class FromXMLEntityGeneratorTest extends TestCase
{

    private const EVENT_NODE = <<<EOF
<event id="3915" start_time="16/06/02 07:00:00" duration="00:55:00" free_CA="0" running_status="4">
	<content dvb="0x10" user="0x00"/>
	<component stream_content="0x01" type="0x04" tag="0" language="eng" text_encoding="default" text=""/>
	<component stream_content="0x02" type="0x03" tag="74" language="eng" text_encoding="default" text=""/>
	<component stream_content="0x02" type="0x03" tag="76" language="dut" text_encoding="default" text=""/>
	<component stream_content="0x0F" type="0xFF" tag="255" language="fin" text_encoding="default" text=""/>
	<component stream_content="0x03" type="0x11" tag="255" language="fin" text_encoding="default" text=""/>
	<component stream_content="0x03" type="0x11" tag="255" language="swe" text_encoding="default" text=""/>
	<language code="fin">
	 	<short_event language="fin" name_encoding="ISO8859-9" name="Naapureita ja ystäviä (7)" text_encoding="ISO8859-9" text="Kausi 1, 5/6. Sankari vai ei? Mitä Arthur oikein salakähmäilee? Onko Frank todellakin sotasankari? Ja kuka on Jeanin uusi ihailija? (U)"/>
	</language>
	<language code="swe">
		<short_event language="swe" name_encoding="ISO8859-9" name="Grannar och vänner (7)" text_encoding="ISO8859-9" text="Säsong 1, 5/6. Hjälte eller bluff? Vad smusslar Arthur med? Är Frank verkligen en krigshjälte? Och vem är Jeans nya beundrare? (R)"/>
	</language>
	<parental_rating>
		<country country="FIN" rating="0"/>
	</parental_rating>
</event>
EOF;

    /**
     * @var FromXMLEntityGenerator
     */
    private $eg;

    public function setUp()
    {
        $this->eg = new FromXMLEntityGenerator('src/Resources/event_schema.xsd');
    }

    public function testCreationNullSchemaPath()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You must provide valid path to entity validation schema file');
        $this->eg = new FromXMLEntityGenerator(null);
    }

    public function testCreationSchemaIsNotAFile()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('XSD schema file defined in \'xsd_schema\' parameter does not exist');
        $this->eg = new FromXMLEntityGenerator(file_get_contents('src/Tests/data/event_schema.xsd'));
    }

    public function testCreationSchemaIsEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You should provide valid validation schema');
        $this->eg = new FromXMLEntityGenerator('src/Tests/data/empty_schema.xsd');
    }

    public function exceptionsTestsProvider()
    {
        return [
            [
                '<event1></event1>',
                \RuntimeException::class,
                'Element \'event1\': No matching global declaration available for the validation root.'
            ],
            [
                '<event><language><short_event></short_event></language></event>',
                \RuntimeException::class,
                'Element \'short_event\': The attribute \'name\' is required but missing.'
            ],
            [
                '<event id="1"><language><short_event1 id="2"></short_event1></language></event>',
                \RuntimeException::class,
                'Element \'short_event1\': This element is not expected. Expected is ( short_event ).'
            ],
            [
                '<event id="1"><language><short_event id="2"></short_event></language></event>',
                \RuntimeException::class,
                "Element 'short_event': The attribute 'name' is required but missing."
            ],
            [
                '<event id="1"><language><short_event id="2" name="Test name"></short_event></language></event>',
                \RuntimeException::class,
                "Element 'event': The attribute 'duration' is required but missing."
            ],
            [
            '<event id="1" start_time=""><language><short_event id="2" name="Test name"></short_event></language></event>',
                \RuntimeException::class,
                "Element 'event': The attribute 'duration' is required but missing."
            ],
            [
            '<event id="1" duration=""><language><short_event id="2" name="Test name"></short_event></language></event>',
                \RuntimeException::class,
                "Element 'event': The attribute 'start_time' is required but missing."
            ],
            [
            '<event id="1" start_time="" duration=""><language><short_event id="2" name="Test name"></short_event></language></event>',
                \RuntimeException::class,
                "Element 'event', attribute 'duration': [facet 'pattern'] The value '' is not accepted"
            ],
            [
                '<event id="1" start_time="" duration="sadasd"><language><short_event id="2" name="Test name"></short_event></language></event>',
                \RuntimeException::class,
                'is not accepted by the pattern'
            ],
            [
                '<event id="1" start_time="" duration="33:33:33"><language><short_event id="2" name="Test name"></short_event></language></event>',
                \RuntimeException::class,
                'is not accepted by the pattern'
            ],
            [
                '<event id="1" start_time="" duration="23:33:33"><language><short_event id="2" name="Test name"></short_event></language></event>',
                \RuntimeException::class,
                'XML parse error. Wrong "start_time" format'
            ],
            [
            '<event id="1" start_time="135/06/02 07:00:00" duration="22:33:33"><language><short_event id="2" name="Test name"></short_event></language></event>',
                \RuntimeException::class,
                'XML parse error. Wrong "start_time" format'
            ],
            [
                '<event id="1" start_time="16/06/02 0700:010:00" duration="22:33:33"><language><short_event id="2" name="Test name"></short_event></language></event>',
                \RuntimeException::class,
                'XML parse error. Wrong "start_time" format'
            ]

        ];
    }

    public function testCreateEntitiesWrongEventNodeType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Parameter $eventNode should be instance of \'\SimpleXMLElement\', \'stdClass\' given.');
        $this->eg->createEntities(new \StdClass(), new ServiceLivetvChannel(), new ServiceLivetvShowType());
    }

    /**
     * @dataProvider exceptionsTestsProvider
     */
    public function testCreateEntitiesExceptions($input, $class, $message)
    {
        $channel = new ServiceLivetvChannel();
        $showType = new ServiceLivetvShowType();

        $this->expectException($class);
        $this->expectExceptionMessage($message);
        $node = new \SimpleXMLElement($input);
        $this->eg->createEntities($node, $channel, $showType);
    }

    public function testEntityStructure()
    {
        $channel = (new ServiceLivetvChannel())->setSourceId("17")->setShortName("Test channel");
        $showType = (new ServiceLivetvShowType())->setType('movie');
        $node = new \SimpleXMLElement(self::EVENT_NODE);
        /** @var ServiceLivetvSchedule $entity */
        $entity = $this->eg->createEntities($node, $channel, $showType);
        $this->assertInstanceOf(ServiceLivetvSchedule::class, $entity);
        $this->assertInstanceOf(ServiceLivetvProgram::class,  $entity->getProgram());
        $this->assertInstanceOf(ServiceLivetvShowType::class,  $entity->getProgram()->getShowType());
        $this->assertInstanceOf(ServiceLivetvChannel::class,  $entity->getChannel());
        $this->assertEquals('1024210800', $entity->getStartTime()); //1024200000
        $this->assertEquals('1024214100', $entity->getEndTime());
        $this->assertEquals('Naapureita ja ystäviä (7)', $entity->getProgram()->getLongTitle());
        $this->assertEquals('movie', $entity->getProgram()->getShowType()->getType());
        $this->assertEquals('17', $entity->getChannel()->getSourceId());
        $this->assertEquals('Test channel', $entity->getChannel()->getShortName());
    }
}
