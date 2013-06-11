<?php

class Gmap_Controls_Scale extends Gmap_Controls_Base {
    function __construct()
    {
         $config = Kohana::$config->load('gmap.controls.scale');


        $this->setDisplay(Arr::get($config,'display',true));
        $this->setPosition(Arr::get($config,'position', self::POSITION_TOP_RIGHT));
    }

}