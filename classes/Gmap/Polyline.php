<?php

class Gmap_Polyline extends Gmap_Object {

    private $options = array();
    private $coords = array();

    private $bounds;


    function __construct($id)
    {
        parent::__construct($id);
        $this->options = Kohana::$config->load('gmap.polygon');
        $this->bounds = new Gmap_Bounds();
    }


    /**
     *
     * @param type $color
     * @return Gmap_Polyline
     */
    public function setStrokeColor($color)
    {
        $this->options['strokeColor'] = $color;
        return $this;
    }

    /**
     *
     * @param float $opacity between 0.0 and 1.0
     * @return Gmap_Polyline
     */
    public function setStrokeOpacity($opacity)
    {
        $this->options['strokeOpacity'] = $opacity;
        return $this;
    }

    /**
     *
     * @param float $strokeWeight
     * @return Gmap_Polyline
     */
    public function setStrokeWeight($strokeWeight)
    {
        $this->options['strokeWeight'] = $strokeWeight;
        return $this;
    }

    public function addPoint($lat, $lng)
    {
        $this->coords[] = array($lat, $lng);
        $this->bounds->addLatLng($lat, $lng);

        return $this;
    }

    public function getOptions()
    {
        return parent::getOptions() + $this->options +  array(
            'coords' => $this->coords,
        );
    }

    /**
     *
     * @return Gmap_Bounds
     */
    public function getBounds(){
        return $this->bounds;
    }

}