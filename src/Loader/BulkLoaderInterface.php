<?php // @codeCoverageIgnoreStart

namespace EPGImporter\Loader;

/**
 * Interface BulkStreamLoaderInterface
 *
 * @package EPGImporter\Loader
 */
interface BulkLoaderInterface extends LoaderInterface
{
    /** Load source data */
    public function load();
}
