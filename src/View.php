<?php

namespace lab2;

class View {

    private $services;

    private $output;
    
    function __construct() {}

    public function addServices($services) {
        $this->services = $services;
    }
        
    public function setOutput($output) {
        $this->output = $output;
    }

    public function getOutput() {
        return $this->output;
    }

}
