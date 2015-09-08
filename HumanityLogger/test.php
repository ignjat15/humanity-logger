<?php

include_once("autoload.php");

define("HUMANITY_LOG_FILE", __DIR__ . DIRECTORY_SEPARATOR . "humanity_log.txt");
define("IGNJAT_LOG_FILE", __DIR__ . DIRECTORY_SEPARATOR . "ignjat_log.txt");

$humanityLogger = new EventLogger();

//creating instance of FileStorageEventHandler for storing into one txt file humanity_log.txt
$humanityFileStorage = new \Handler\FileStorageEventHandler(HUMANITY_LOG_FILE);
//adding event handler to event logger
$humanityLogger->addEventHandler($humanityFileStorage);

//creating instance of another FileStorageEventHandler for storing into txt file ignjat_log.txt
$ignjatFileStorage = new \Handler\FileStorageEventHandler(IGNJAT_LOG_FILE);
//adding event handler to event logger
$humanityLogger->addEventHandler($ignjatFileStorage);

//for testing purposes we will iterate 20 times
//while the iteration is less then 5, event logger will use both event handlers for storing events
//after 5th iteration, only one event handler remains
//after 10th iteration, there are no more event handlers to store the events
$iterations = 20;
for($i = 0; $i < $iterations; $i++) {
    if ($i == 5) {
        $humanityLogger->removeEventHandler($ignjatFileStorage);
    }
    if ($i == 10) {
        $humanityLogger->removeAllEventHandlers();
    }
    $humanityLogger->log(new \Model\Event("TestEvent_" . $i, "Milos_" . $i, "This is a test event_" . $i, "Some meta information"));
}

