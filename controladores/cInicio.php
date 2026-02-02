<?php

    class CInicio {
        
        public $vista;
        
        public function __construct() {
            $this->vista = '';
        }
        
        public function index() {
            $this->vista = 'inicio';
            return [];
        }
    }
?>
