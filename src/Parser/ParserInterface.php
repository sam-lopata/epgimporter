<?php // @codeCoverageIgnoreStart

namespace EPGImporter\Parser;

use EPGImporter\Generator\EntityGeneratorInterface;

/**
 * Interface ParserInterface
 *
 * @package EPGImporter\Parser
 */
interface ParserInterface
{
    /**
     * @return mixed
     */
    public function run();

    /**
     * @param string $source
     *
     * @return mixed
     */
    public function setSource(string $source);

    /**
     * @param callable $callback
     *
     * @return mixed
     */
    public function setChannelCallback(callable $callback);

    /**
     * @param callable $callback
     *
     * @return mixed
     */
    public function setShowTypeCallback(callable $callback);

    /**
     * @param callable $callback
     *
     * @return mixed
     */
    public function setPersistCallback(callable $callback);

    /**
     * @param EntityGeneratorInterface $entityGenerator
     *
     * @return mixed
     */
    public function setEntityGenerator(EntityGeneratorInterface $entityGenerator);
}
