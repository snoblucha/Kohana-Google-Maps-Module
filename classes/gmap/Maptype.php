<?php

class Gmap_Maptype {

    const MAPTYPE_ROAD = 'google.maps.MapTypeId.ROADMAP';
    const MAPTYPE_SATELLITE = 'google.maps.MapTypeId.SATELLITE';
    const MAPTYPE_HYBRID = 'google.maps.MapTypeId.HYBRID';
    const MAPTYPE_TERRAIN = 'google.maps.MapTypeId.TERRAIN';

    private $value = self::MAPTYPE_HYBRID;
    protected static $maptypes = array(
        'road' => self::MAPTYPE_ROAD,
        'satellite' => self::MAPTYPE_SATELLITE,
        'hybrid' => self::MAPTYPE_HYBRID,
        'terrain' => self::MAPTYPE_TERRAIN,
    );

    public function __toString()
    {
        return $this->value;
    }

    public static function ROAD()
    {
        return new Gmap_Maptype(self::MAPTYPE_ROAD);
    }

    public static function SATTELITE()
    {
        return new Gmap_Maptype(self::MAPTYPE_SATTELITE);
    }

    public static function HYBRID()
    {
        return new Gmap_Maptype(self::MAPTYPE_HYBRID);
    }

    public static function TERRAIN()
    {
        return new Gmap_Maptype(self::MAPTYPE_TERRAIN);
    }

    private function __construct($type)
    {
        $this->value = $type;
    }

}