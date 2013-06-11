<?php

class Gmap_Polygon extends Gmap_Polyline{
    private $options = array();

    function __construct($id)
    {
        parent::__construct($id);
        $this->options = Kohana::$config->load('gmap.polygon');
    }

    /**
     *
     * @param hex $color
     * @return Gmap_Polygon
     */
    public function setFillColor($color){
        $this->options['fillColor'] = $color;
        return $this;
    }

    /**
     *
     * @param float between 0.0 and 1.0
     * @return Gmap_Polygon
     */
    public function setFillOpacity($color){
        $this->options['fillColor'] = $color;
        return $this;
    }

    public function getOptions(){
        return parent::getOptions() + $this->options;
    }




}
