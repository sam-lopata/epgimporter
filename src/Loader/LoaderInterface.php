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
     * @param string $source Name of the file with XML located
     *
     * @return LoaderInterface
     */
    public function init(string $source);

}
