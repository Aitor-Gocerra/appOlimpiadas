<?php

class CInicio {
    
    public $vista;
    
    public function __construct() {
        $this->vista = '';
    }
    
    /**
     * Muestra el menú principal con opciones de Login e Inscripción
     */
    public function index() {
        $this->vista = 'inicio';
        return [];
    }
}
?>
