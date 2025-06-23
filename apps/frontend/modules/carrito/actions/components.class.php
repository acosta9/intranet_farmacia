<?php 
require_once dirname(__FILE__).'/../lib/carritoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/carritoGeneratorHelper.class.php';

class carritoComponents extends sfComponents {
    public function executeAgregar() { 
        $this->form = new CarritoForm();
    }
    
    public function executeAgregardos() { 
        $this->form = new CarritoForm();
    }
    
    public function executeAgregartres() { 
        $this->form = new CarritoForm();
    }
    
    public function executeAgregarcuatro() { 
        $this->form = new CarritoForm();
    }
    
    public function executeCarrito() {              
    }
} 
?> 
