<?php // @codeCoverageIgnoreStart

namespace EPGImporter\Parser;

use EPGImporter\Generator\EntityGeneratorInterface;
use EPGImporter\Loader\LoaderInterface;

/**
 * Class JSONParser
 *
 * @package EPGImporter\Parser
 */
abstract class BaseParser implements ParserInterface
{

    /**
     * @var LoaderInterface
     */
    protected $loader;

    /**
     * @var string Where from to load data
     */
    protected $source;

    /**
     * @var \SplFixedArray
     */
    protected $latestEntities;

    /**
     * @var EntityGeneratorInterface
     */
    protected $entityGenerator;

    /**
     * @var callable Save data call
     */
    protected $persistCallback;

    /**
     * @var callable Get channel
     */
    protected $channelCallback;

    /**
     * @var callable Get showType
     */
    protected $showTypeCallback;

    /**
     * BaseParser constructor.
     *
     * @param LoaderInterface       $loader
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @return mixed|void
     */
    public function run(){}

    /**
     * @param EntityGeneratorInterface $entityGenerator
     *
     * @return BaseParser
     */
    public function setEntityGenerator(EntityGeneratorInterface $entityGenerator) : self
    {
        $this->entityGenerator = $entityGenerator;

        return $this;
    }

    /**
     * @param string $source
     *
     * @return BaseParser
     */
    public function setSource(string $source) : self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @param callable $callback
     *
     * @return BaseParser
     */
    public function setPersistCallback(callable $callback) : self
    {
        $this->persistCallback = $callback;

        return $this;
    }

    /**
     * @param callable $callback
     *
     * @return BaseParser
     */
    public function setChannelCallback(callable $callback): self
    {
        $this->channelCallback = $callback;

        return $this;
    }

    /**
     * @param callable $callback
     *
     * @return BaseParser
     */
    public function setShowTypeCallback(callable $callback): self
    {
        $this->showTypeCallback = $callback;

        return $this;
    }
}
