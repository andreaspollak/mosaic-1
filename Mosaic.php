<?php

class Mosaic {
	private $source;
    private $source_size;
    private $zone_size;
	private $dest;
	private $dest_params;
    
    public function __construct($source,$dest,$zone_size,$dest_params = 'params.json',$source_size = array()) {
        $this->source = $source;
        $this->dest_params = $dest_params;
        $this->zone_size = $zone_size;
        
        if(empty($source_size)) {
            $size = getimagesize($this->source);
            $this->source_size = array($size[0],$size[1]);
        }
        copy($source,$dest);
        
        $file = array();
        $file['mosaic']['file'] = $dest;
        $file['mosaic']['height'] = $size[0];
        $file['mosaic']['width'] = $size[1];
        $file['pictures'] = array();
        
        $x = 0;
        $y = 0;
        while($x <= $this->source_size[1]) {
            while($y <= $this->source_size[0]) {
                $zone['x'] = $x;
                $zone['y'] = $y;
                $zone['colors'] = dominant_color();
                array_push($file['pictures'], $zone);
                $y = $y+$zone_size[0];
            }
            $y = 0;
            $x = $x+$zone_size[1];
        }
        
        /* TODO VERIF DROIT D'ECRITURE */
        /*
        if (substr(sprintf('%o', fileperms($this->output)), -4) != 775) {
            throw new \Exception('Folder permission denied');
        }
        */
        $fopen = fopen($this->dest_params, "w+");
        fwrite($fopen, json_encode($file));
        fclose($fopen);
    }
    
    public function mosaic_add($input,$input_size = array()) {
        $result = array();
        
        if(empty($input_size)) {
            $size = getimagesize($input);
            $input_size = array($size[0],$size[1]);
            $result['intpu_size'] = $input_size;
        }
        /*
        $fread = json_decode(file_get_contents($this->dest_params), true);
        
        $fread['pictures'] = array();
        
        $picture['name'] = $input;
        $picture['height'] = $size[0];
        $picture['width'] = $size[1];
        
        array_push($fread['pictures'],$picture);
        
        $fopen = fopen($this->dest_params, "w+");
        fwrite($fopen, json_encode($fread));
        fclose($fopen);
         * 
         */
    }
    
    public function dominant_color() {
        $i = imagecreatefromjpeg($this->source);
        $color['rouge'] = '';
        $color['bleu'] = '';
        $color['gris'] = '';
        $total = '';
        for ($x=0;$x<imagesx($i);$x++) {
            for ($y=0;$y<imagesy($i);$y++) {
                $rgb = imagecolorat($i, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $color['rouge'] += $r;
                $color['gris'] += $g;
                $color['bleu'] += $b;
                $total++;
            }
        }
        return $color;
    }
    
    /* TODO */
    /* FONCTION de place disponible */
    /* FONCTION de nombre de participants */
}

?>