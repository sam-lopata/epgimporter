<?php

namespace EPGImporter\ParserManager;

use EPGImporter\DataManager\DataManagerInterface;
use EPGImporter\Generator\EntityGeneratorInterface;
use EPGImporter\Parser\ParserInterface;

/**
 * Class ParserManager
 *
 * @package EPGImporter
 */
class ParserManager implements ParserManagerInterface
{
    /** @var ParserInterface */
    private $parser;

    /** @var DataManagerInterface */
    private $dm;

    /**
     * @var string
     */
    private $source;

    /**
     * @var EntityGeneratorInterface
     */
    private $eg;

    /**
     * @inheritDoc
     */
    public function __construct(ParserInterface $parser, DataManagerInterface $dm, EntityGeneratorInterface $eg, string $source)
    {
        $this->parser = $parser;
        $this->dm = $dm;
        $this->source = $source;
        $this->eg = $eg;
    }

    /**
     * Run import
     */
    public function process()
    {
        $persistCallback = $this->dm->getPersistCallback();
        $channelCallback = $this->dm->getChannelCallback();
        $showTypeCallback = $this->dm->getShowTypeCallback();

        $this->parser->setSource($this->source)
            ->setChannelCallback($channelCallback)
            ->setshowTypeCallback($showTypeCallback)
            ->setEntityGenerator($this->eg)
            ->setPersistCallback($persistCallback)
            ->run();
    }
}
