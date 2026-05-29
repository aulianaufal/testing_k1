<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf {
    // Declare the property first
    protected $fpdf;
    
    public function __construct() {
        // Include FPDF library
        include_once APPPATH.'third_party/fpdf/fpdf.php';
        
        $this->fpdf = new FPDF();
    }

    public function getInstance() {
        return $this->fpdf;
    }
}
