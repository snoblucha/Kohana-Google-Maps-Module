<?php
class Gmap_Controls {
    /**
     *
     * @var Gmap_Controls_Maptype
     */
    private $maptype;

    /**
     *
     * @var Gmap_Controls_Navigation
     */
    private $navigation;


    /**
     *
     * @var Gmap_Maptype_Scale
     */
    private $scale;

    /**
     *
     * @return Gmap_Controls_Maptype
     */
    public function getMaptype()
    {
        return $this->maptype;
    }



    /**
     *
     * @return Gmap_Controls_Navigation
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     *
     * @return Gmap_Controls_Scale
     */
    public function getScale()
    {
        return $this->scale;
    }


    function __construct()
    {
        $this->maptype = new Gmap_Controls_Maptype();
        $this->scale = new Gmap_Controls_Scale();
        $this->navigation = new Gmap_Controls_Navigation();

    }

    public function getOptions(){
       return array(
            'scale' => $this->scale->getOptions(),
            'navigation' => $this->navigation->getOptions(),
            'maptype' => $this->maptype->getOptions(),
        );

        

    }



}