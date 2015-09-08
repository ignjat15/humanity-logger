<?php

namespace Model;

use Serializable;
/**
 * Class Event Contains information about an event or action that occurred
 * Implements SerializableData interface in order to be able to serialize itself
 * Serializable data is suitable for writing into storage (eg. file storage)
 * @package Model
 */
class Event implements Serializable
{
    /**
     * @var string $eventName Name of the event
     */
    private $eventName;

    /**
     * @var string $performer Contains information of who/what produced this event
     */
    private $performer;

    /**
     * @var string $subject Subject of the event
     */
    private $subject;

    /**
     * @var string $timestamp Formatted string representation of date() function
     */
    private $timestamp;

    /**
     * @var Object $metaInfo Some meta information
     */
    private $metaInfo;

    /**
     * @param string $eventName
     * @param string $performer
     * @param string $subject
     * @param Object $metaInfo
     */
    function __construct($eventName, $performer, $subject, $metaInfo)
    {
        $this->eventName = $eventName;
        $this->performer = $performer;
        $this->subject = $subject;
        $this->timestamp = date(DATE_RFC2822);
        $this->metaInfo = $metaInfo;
    }

    /**
     * Returns string representation of Event object
     *
     * @return string
     */
    public function serialize()
    {
        return $this->timestamp . "  " . $this->eventName . " | " . $this->subject . " | " . $this->performer . " | " . $this->metaInfo;
    }

    /**
     * Returns Object from serialized data
     *
     * @param string $serialized
     * @return mixed
     */
    public function unserialize($serialized)
    {
        return unserialize($serialized);
    }
}
