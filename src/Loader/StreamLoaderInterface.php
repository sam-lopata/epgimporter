<?php // @codeCoverageIgnoreStart

namespace EPGImporter\Loader;

/**
 * Interface StreamLoaderInterface
 *
 * @package EPGImporter\Loader
 */
interface StreamLoaderInterface extends LoaderInterface
{
    /**
     * Read one line from source
     *
     * @return mixed
     */
    public function readLine();
}
