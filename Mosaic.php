<?php

class Mosaic {
	private $source;
    private $source_size;
	private $dest;
	private $dest_params;
    
    public function __construct($source,$dest,$dest_params = 'params.json',$source_size = array()) {
        $this->source = $source;
        $this->dest_params = $dest_params;
        /* TODO VERIF DROIT D'ECRITURE */
        /*
        if (substr(sprintf('%o', fileperms($this->output)), -4) != 775) {
            throw new \Exception('Folder permission denied');
        }
        */
        $handle = fopen($this->dest_params, "w+");
        if(empty($source_size)) {
            $size = getimagesize($this->source);
            $this->source_size = array($size[0],$size[1]);
        }
        copy($source,$dest);
    }
    
    public function mosaic_add($input,$input_size = array()) {
        $result = array();
        
        if(empty($input_size)) {
            $size = getimagesize($input);
            $input_size = array($size[0],$size[1]);
            $result['intpu_size'] = $input_size;
        }
        
        return $result;
    }
}

?>