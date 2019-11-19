<?php // @codeCoverageIgnoreStart

namespace EPGImporter\Loader;

/**
 * Interface LoaderInterface
 *
 * @package EPGImporter\Loader
 */
interface LoaderInterface
{
    /**
     * Load source data
     *
     * @param string $source Source to load
     *
     * @return LoaderInterface
     */
    public function init(string $source);

}
