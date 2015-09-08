<?php

use Handler\EventHandler;
use Model\Event;

/**
 * Class EventLogger Handles logging of events by storing them in various types of storage
 */
class EventLogger
{
    /**
     * @var SplObjectStorage $eventHandlers Used for storing list of various EventHandlers (eg. File, DB, etc)
     */
    private $eventHandlers;

    /**
     * Constructor of EventLogger class
     * Initializes private field storageHandlers
     */
    function __construct()
    {
        $this->eventHandlers = new SplObjectStorage();
    }

    /**
     * Adds one more event handler
     *
     * @param EventHandler $eventHandler
     *
     * @return void
     */
    public function addEventHandler(EventHandler $eventHandler)
    {
        $this->eventHandlers->attach($eventHandler);
    }

    /**
     * Removes specific event handler
     *
     * @param EventHandler $eventHandler
     *
     * @return void
     */
    public function removeEventHandler(EventHandler $eventHandler)
    {
        $this->eventHandlers->detach($eventHandler);
    }

    /**
     * Removes all event handlers
     *
     * @return void
     */
    public function removeAllEventHandlers()
    {
        $this->eventHandlers->removeAll($this->eventHandlers);
    }

    /**
     * Checks whether $eventHandler exists in the list of available event handlers
     *
     * @param EventHandler $eventHandler
     * @return bool
     */
    private function hasEventHandler(EventHandler $eventHandler)
    {
        return $this->eventHandlers->contains($eventHandler);
    }

    /**
     * Iterates over all available event handlers
     * and logs the event data using each one of them
     *
     * @param Event $event
     *
     * @return void
     */
    public function log(Event $event)
    {
        $this->eventHandlers->rewind();
        while ($this->eventHandlers->valid()) {
            $eventHandler = $this->eventHandlers->current();
            $eventHandler->writeRecord($event);
            $this->eventHandlers->next();
        }
    }
}
