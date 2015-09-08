<?php

namespace Handler;

use Serializable;

/**
 * Class FileStorageHandler Takes Event data and writes it into defined storage path
 * @package Handler
 */
class FileStorageEventHandler implements EventHandler
{
    /**
     * @var string $storageFilePath Path to the file on system to store into
     */
    private $storageFilePath;

    /**
     * @param string $storageFilePath
     */
    function __construct($storageFilePath)
    {
        $this->storageFilePath = $storageFilePath;

        if (!$this->checkStorageFile()) {
            //notify system/user that the path specified is not a valid writable file
        }
    }

    /**
     * Checks if the $storageFilePath points to a valid writable file
     * If the file path does not exist, and it points to a writable directory, it is considered valid since it will be automatically created
     *
     * @return bool
     */
    private function checkStorageFile() {
        if ((!is_dir($this->storageFilePath) && file_exists($this->storageFilePath) && is_writeable($this->storageFilePath)) ||
            (!file_exists($this->storageFilePath) && is_writeable(dirname($this->storageFilePath)))) {
            return true;
        }
        return false;
    }

    /**
     * Writes $event to the end of the file defined by $storageFilePath
     * $event object is serialized before being written into file
     *
     * @param Serializable $event
     *
     * @return void
     */
    public function writeRecord(Serializable $event)
    {
        //file_put_contents() used only for demonstration purposes
        //this might not be the best way to ensure thread safe storing into file
        //instead, we could use PHP's error_log function which handles concurrency issues much better
        if (!file_put_contents($this->storageFilePath, $event->serialize() . "\n", FILE_APPEND | LOCK_EX)) {
            //do something to notify system/user if write to file has failed
            //throw some Exception - eg. WriteRecordException($storageFilePath, $data)
        }
    }
}
