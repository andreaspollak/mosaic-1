<?php

class Mosaic {
	private $output;
	private $output_h;
	private $output_w;
	private $output_dir;
    
    public function __construct($output,$output_dir,$output_h = null,$output_w = null) {
        if (substr(sprintf('%o', fileperms($output)), -4) != 775) {
            throw new \Exception('Folder permission denied');
        }
        $this->output = $output;
        $this->output_dir = $output_dir;
        
        if(empty($output_h)) {
            var_dump($output_dir.$output);
            $output_h = getimagesize($output_dir.$output);
        }
        //$this->output_h = $output_h;
        //$this->output_w = $output_w;
    }
    
    public function mosaic_generate($input,$input_h,$input_w) {
        $result = array();
        
        return $result;
    }
}

?>