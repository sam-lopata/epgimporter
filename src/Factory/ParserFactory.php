<?php

namespace EPGImporter\Factory;

use EPGImporter\Parser\ParserInterface;

/**
 * Class ParserFactory
 *
 * @package EPGImporter\Factory
 */
class ParserFactory
{
    /**
     * @param string $parser
     * @param string $loader
     *
     * @return ParserInterface
     */
    public function __invoke($parser, $loader) : ParserInterface
    {
        return new $parser(new $loader());
    }
}
