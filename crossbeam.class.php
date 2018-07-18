<?php

class crossBeamEngineering {

    private $args = array();
    private $baseUrl = "https://s3.amazonaws.com/challenge.getcrossbeam.com/public/";
    private $response = array();
    private $cookie = "crossbeam";
    private $curl;

    function __construct() {
        try {
            $this->curl = new Curl($this->baseUrl, $this->cookie);
            $this->args = $this->getArguments();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function run() {
        try {
            $crossbeam = array();
            foreach ($this->args as $arg) {
                $url = $this->baseUrl . $arg . ".json";
                $curlResponse = $this->curl->sendCurl($url);
                if ($this->isJson($curlResponse)) {
                    $crossbeam[] = json_decode($curlResponse);
                } else {
                    die("No valid response got from: " . $this->baseUrl . $arg . ".json");
                }
            }
            $this->processCrossbeamResponse($crossbeam);
            $this->generateOutput();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    private function processCrossbeamResponse($crossbeamResponse) {
        try {
            $firstParamResponse = array();
            foreach ($crossbeamResponse as $crossbeamObject) {
                $temp = array();
                if (isset($crossbeamObject->companies)) {
                    foreach ($crossbeamObject->companies as $company) {
                        $companyInfo = strtolower($company->name);
                        $temp[] = $companyInfo;
                    }
                    $uniqueElements = array_unique($temp);
                    $this->response[] = sizeof($uniqueElements);
                    if (sizeof($firstParamResponse)) {
                        $similarElements = array_intersect($firstParamResponse, $uniqueElements);
                        $this->response[] = sizeof($similarElements);
                    } else {
                        $firstParamResponse = $uniqueElements;
                    }
                } else {
                    die("No companies found");
                }
            }
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    private function getArguments() {
        try {
            global $argv;
            $argumentsRequired = 2;
            $args = array();
            if (is_array($argv)) {
                foreach ($argv as $arg) {
                    if (!strpos($arg, ".php")) {
                        $args[] = $arg;
                    }
                }
                if (sizeof($args) > $argumentsRequired) {
                    die("Only two arguments should be passed");
                } else if (sizeof($args) < $argumentsRequired) {
                    die("Atleast two arguments needs to be passed");
                }
            }
            return $args;
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    private function generateOutput() {
        foreach ($this->response as $output) {
            echo $output . " ";
        }
    }

    private function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}

