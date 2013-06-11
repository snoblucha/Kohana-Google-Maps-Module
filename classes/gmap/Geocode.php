<?php

class Gmap_Geocode extends Gmap_Marker {

    private $address;
    private $bounds = null;
    private $region = null;
    private $language = null;

    public function getBounds()
    {
        return $this->bounds;
    }

    public function getRegion()
    {
        return $this->regions;
    }

    /**
     * The bounding box of the viewport within which to bias geocode results more prominently.
     * @see https://developers.google.com/maps/documentation/geocoding/?hl=cs#Viewports
     *
     * @param type $bounds
     * @return type
     */
    public function setBounds($bounds)
    {
        $this->bounds = $bounds;
        return $this;
    }

    /**
     * The region code, specified as a ccTLD ("top-level domain") two-character value. This parameter will only influence, not fully restrict, results from the geocoder.
     * @see https://developers.google.com/maps/documentation/geocoding/?hl=cs#RegionCodes
     * @param type $region
     * @return type
     */
    public function setRegion($region)
    {
        $this->regions = $region;
        return $this;
    }

    /**
     *
     * @param string $id
     * @param string $address
     * @return \Gmap_Geocode
     */
    public static function geocode($id, $address)
    {
        return new Gmap_Geocode($id, $address);
    }

    function __construct($id, $address)
    {
        parent::__construct($id, null, null);
        $this->setAddress($address);
    }

    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the address
     * @param String $address in format: "street number, city"
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getOptions()
    {

        $res = array('address' => $this->getAddress(),);
        if ($this->bounds != null)
        {
            $res['bounds'] = $this->bounds;
        }
        if ($this->language != null)
        {
            $res['language'] = $this->language;
        }
        if ($this->region != null)
        {
            $res['region'] = $this->region;
        }

        return parent::getOptions() + $res;
    }

}