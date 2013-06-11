<?php

class Gmap_Controls_Maptype extends Gmap_Controls_Base {

    const TYPE_DEFAULT = 'default';
    const TYPE_DROPDOWN = 'dropdown';
    const TYPE_HORIZONTAL = 'horizontal';

    /**
     * Type of the maptype control
     * @var String
     */
    private $type;

    private static $maptypes = array(
        'horizontal' => 'google.maps.MapTypeControlStyle.HORIZONTAL_BAR',
        'dropdown' => 'google.maps.MapTypeControlStyle.DROPDOWN_MENU',
        'default' => 'google.maps.MapTypeControlStyle.DEFAULT',
    );

    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type of the maptype control horizontal|default|dropdown or use const from class TYPE_*
     * @param String $type
     * @return Gmap_Controls_Maptype
     * @throws UnexpectedValueException
     */
    public function setType($type)
    {
        if(isset(self::$maptypes[$type])){
            $this->type = self::$maptypes[$type];
        } else {
            throw new UnexpectedValueException("Maptype $type is not recognized");
        }
        return $this;

    }


    function __construct()
    {
        $config = Kohana::$config->load('gmap.controls.maptype');


        $this->setDisplay(Arr::get($config,'display',true));
        $this->setType(Arr::get($config,'type','default'));
        $this->setPosition(Arr::get($config,'position', self::POSITION_TOP_RIGHT));
    }



    public function getOptions(){
        $res = parent::getOptions();
        $res['type'] = $this->type;
        return $res;
    }

}
