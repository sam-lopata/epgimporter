<?php // @codeCoverageIgnoreStart

namespace EPGImporter\DataManager;

/**
 * Interface DataManagerInterface
 *
 * @package EPGImporter\DataManager
 */
interface DataManagerInterface
{
    /**
     * @return callable Callback which is used to save data
     */
    public function getPersistCallback() : callable;

    /**
     * @return callable Callback which is used to search for channel object
     */
    public function getChannelCallback() : callable ;

    /**
     * @return callable Callback which is used to search for showType object
     */
    public function getShowTypeCallback() : callable ;

    /**
     * @return int Return amount of processed entities
     */
    public function getCounter(): int;
}
