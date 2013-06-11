<?php

class Gmap_Controls_Navigation extends Gmap_Controls_Base {

    const TYPE_SMALL = 'small';
    const TYPE_ZOOM_PAN = 'zoom_pan';
    const TYPE_ANDROID = 'android';
    const TYPE_DEFAULT = 'default';

    private $type;

    private static $navigations = array(
        'small' => 'google.maps.NavigationControlStyle.SMALL',
        'zoom_pan' => 'google.maps.NavigationControlStyle.ZOOM_PAN',
        'android' => 'google.maps.NavigationControlStyle.ANDROID',
        'default' => 'google.maps.NavigationControlStyle.DEFAULT',
    );

    function __construct()
    {
        $config = Kohana::$config->load('gmap.controls.maptype');

        $this->setDisplay(Arr::get($config, 'display', true));
        $this->setType(Arr::get($config, 'type', 'default'));
        $this->setPosition(Arr::get($config, 'position', self::POSITION_TOP_RIGHT));
    }

    /**
     * Set the type of the maptype control horizontal|default|dropdown or use const from class TYPE_*
     * @param String $type
     * @return Gmap_Controls_Navigation
     * @throws UnexpectedValueException
     */
    public function setType($type)
    {
        if (isset(self::$navigations[$type]))
        {
            $this->type = self::$navigations[$type];
        }
        else
        {
            throw new UnexpectedValueException("Navigation $type is not recognized");
        }
        return $this;
    }

    public function getOptions(){
        $res = parent::getOptions();
        $res['type'] = $this->type;
        return $res;
    }

}