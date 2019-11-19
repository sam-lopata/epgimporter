<?php

namespace EPGImporter\Parser;

/**
 * Class XMLParser
 *
 * @package EPGImporter\Parser
 */
class XMLParser extends BaseParser
{
    private const ROOT_NODE = 'epg';
    private const SERVICE_NODE = 'service';

    /**
     * Execute parsing
     */
    public function run()
    {
        $this->parse();
    }

    /**
     * Parse source as a stream, extract <service> nodes and pass to SimpleXML parser
     */
    private function parse() : void
    {
        $this->loader->init($this->source);
        $stopParsing = false;
        do
        {
            switch ($this->loader->nodeType)
            {
                case \XMLReader::ELEMENT:
                    if (static::SERVICE_NODE === $this->loader->name) {
                        $serviceNode = $this->loader->expandNode()->getLastOperationStatus();
                        $this->parseServiceNode($serviceNode);
                        if (count($this->latestEntities)) {
                            ($this->persistCallback)($this->latestEntities);
                            $this->latestEntities = null;
                        }
                    }
                    break;
                case \XMLReader::END_ELEMENT:
                    if (static::ROOT_NODE === $this->loader->name) {
                        $stopParsing = true;
                    }
                    break;
            }
        }
        while (!$stopParsing && $this->loader->readLine());
    }

    /**
     * Convert DOMNode object into SimpleXMLElement
     *
     * @param \DOMNode $node
     *
     * @return \SimpleXMLElement
     */
    private function createServiceNode(\DOMNode $node) : \SimpleXMLElement
    {
        $dom = new \DomDocument();
        $n = $dom->importNode($node, true);

        return simplexml_import_dom($n);
    }

    /**
     * Extracts <event> nodes from provided DOMNode, converts them into entitiy objects ans saves
     *
     * @param \DOMNode $node
     *
     * @throws \Exception
     */
    private function parseServiceNode(\DOMNode $node) : void
    {
        /** @var \SimpleXMLElement $serviceNode */
        $serviceNode = $this->createServiceNode($node);
        $channel = ($this->channelCallback)((int)$serviceNode['id']);
        // As I am not sure where to get show_type for now use 'movie' as default one
        $showType = ($this->showTypeCallback)('movie');
        if (null !== $channel) {
            $this->latestEntities = new \SplFixedArray($serviceNode->count());
            $i = 0;
            foreach ($serviceNode as $eventNode) {
                try {
                    $entities = $this->entityGenerator->createEntities(
                        $eventNode,
                        $channel,
                        $showType
                    );
                }
                catch (\InvalidArgumentException $e) {
                    // logging or error processing goes here
                    continue;
                }
                catch (\RuntimeException $e) {
                    // logging or error processing goes here
                    continue;
                }
                $this->latestEntities[$i] = $entities;
                $i++;
            }
        }
    }
}
