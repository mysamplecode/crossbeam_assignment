<?php

require_once 'curl.class.php';
require_once 'crossbeam.class.php';

try {
    $crossBeamEngineering = new crossBeamEngineering();
    $crossBeamEngineering->run();
} catch (Exception $ex) {
    die($ex->getMessage());
}

