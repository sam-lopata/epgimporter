<?php

namespace EPGImporter\Tests;

use EPGImporter\Factory\ParserFactory;
use EPGImporter\Loader\XMLStreamFileLoader;
use EPGImporter\Parser\JSONParser;
use PHPUnit\Framework\TestCase;

class ParserFactoryTest extends TestCase
{
    public function testParserCreation()
    {
        $parserFactory = new ParserFactory();
        $this->assertIsCallable($parserFactory);

        $parser = $parserFactory(JSONParser::class, XMLStreamFileLoader::class);
        $this->assertInstanceOf(JSONParser::class, $parser);

        $reflector = new \ReflectionClass($parser);
        $loaderProperty = $reflector->getProperty('loader');
        $loaderProperty->setAccessible(true);
        $this->assertInstanceOf(XMLStreamFileLoader::class, $loaderProperty->getValue($parser));
    }
}
