<?php

namespace Handler;

use Serializable;

/**
 * Interface EventHandler
 * @package Handler
 */
interface EventHandler
{
    /**
     * @param Serializable $data
     * @return mixed
     */
    public function writeRecord(Serializable $data);
}
