<?php

namespace EPGImporter\Tests;

use EPGImporter\Loader\LoaderException;
use EPGImporter\Loader\XMLStreamFileLoader;
use PHPUnit\Framework\TestCase;

class XMLStreamFileLoaderTest extends TestCase
{
    private const SOURCE = "src/Tests/data/test_data.xml";
    private const BROKEN_SOURCE = "src/Tests/data/test_data_broken.xml";

    /** @var XMLStreamFileLoader */
    private $fl;

    public function setUp()
    {
        $this->fl = new XMLStreamFileLoader();
    }

    public function testInitFileNotExists()
    {
        $this->expectException(LoaderException::class);
        $this->fl->init('/some/file/here/which/not/exist');
    }

    public function testInitSuccess()
    {
        $this->fl->init(self::SOURCE);

        $reflector = new \ReflectionClass($this->fl);
        $loaderProperty = $reflector->getProperty('source');
        $loaderProperty->setAccessible(true);
        $this->assertEquals(self::SOURCE, $loaderProperty->getValue($this->fl));
        $this->assertEquals(\XMLReader::ELEMENT, $this->fl->nodeType);
    }

    public function testReadLine()
    {
        $this->fl->init(self::SOURCE);
        $this->fl->readLine();

        $reflector = new \ReflectionClass($this->fl);
        $lsp = $reflector->getProperty('lastStatus');
        $lsp->setAccessible(true);
        $lastStatus = $lsp->getValue($this->fl);
        $this->assertTrue($lastStatus);
    }

    public function testReadLineBroken()
    {
        $this->expectException(LoaderException::class);
        $this->fl->init(self::BROKEN_SOURCE);
    }

    public function testExpandNode()
    {
        $this->fl->init(self::SOURCE);

        /** @var \DOMNode $node */
        $node = $this->fl->readLine()->expandNode()->getLastOperationStatus();
        $this->assertInstanceOf(\DOMElement::class, $node);
        $this->assertEquals("network", $node->tagName);

        $node = $this->fl->readLine()->expandNode()->getLastOperationStatus();
        $this->assertInstanceOf(\DOMElement::class, $node);
        $this->assertEquals("service", $node->tagName);

        $node = $this->fl->readLine()->expandNode()->getLastOperationStatus();
        $this->assertInstanceOf(\DOMElement::class, $node);
        $this->assertEquals("event", $node->tagName);
    }
}
