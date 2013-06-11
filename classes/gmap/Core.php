<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Contains the Google Map class.
 *
 * @package    gmap
 * @author     Leonard Fischer <leonard.fischer@sn4ke.de>
 * @copyright  (c) 2011 Leonard Fischer
 * @version    1.3
 */
class Gmap_Core {

    private $id;

    /**
     * Center lat
     * @var float
     */
    private $lat;
    private $lng;

    /**
     * Zoom in range:
     * @var int
     */
    private $zoom;
    private $width;
    private $height;

    /**
     * Sensor
     * @var boolean
     */
    private static $sensor = false;
    protected static $enabled = false;
    protected static $instances = array();
    private $markers = array();
    private $polylines = array();
    private $polygons = array();

    /**
     *
     * @var Gmap_Controls
     */
    private $controls;

    /**
     *
     * @var Gmap_Maptype
     */
    private $type;

    /**
     *
     * @var Array of Gmap_Geocode
     */
    private $geocode_request = array();
    protected $view = NULL;

    /**
     * The factory method for instant method-chaining.
     *
     * @param String $id Id of the map. Singleton.
     * @return Gmap
     */
    public static function factory($id = null)
    {
        if (!isset(self::$instances[$id]))
        {
            self::$instances[$id] = new Gmap($id);
        }
        return self::$instances[$id];
    }

    /**
     * Constructor for the Google-Map class.
     *
     * @param array $options
     */
    public function __construct($id = null)
    {
        if ($id === null)
        {
            $id = uniqid();
        }
        $this->id = $id;

        $config = Kohana::$config->load('gmap');

        //set the values from config
        $this->setMaptype(new Gmap_Maptype($config->get('maptype')));
        $this->setCenter($config->get('lat'), $config->get('lng'));
        $this->setSize($config->get('width'), $config->get('height'));

        $this->setView($config->get('view'));
        $this->setZoom($config->get('zoom'));
        $this->setSize($config->get('width'), $config->get('width'));


        $this->controls = new Gmap_Controls();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getView()
    {
        return $this->view;
    }

    /**
     * Get the conrols of the map
     * @return Gmap_Controls
     */
    public function getControls()
    {
        return $this->controls;
    }

    /**
     *
     * @return Gmap_Maptype
     */
    public function getMaptype()
    {
        return $this->type;
    }

    /**
     * Renders the google-map template.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Add a marker to the map.
     * @param Gmap_Marker $marker Marker to add
     * @return Gmap
     */
    public function addMarker(Gmap_Marker $marker)
    {
        $this->markers[$marker->getId()] = $marker;
        return $this;
    }

    /**
     * Add geocode request to map.
     * @param Gmap_Geocode $geocode
     * @return Gmap_Core
     */
    public function addGeocode(Gmap_Geocode $geocode)
    {
        $this->geocode_request[$geocode->getId()] = $geocode;
        return $this;
    }

    /**
     * Add a polygon to the map.
     * @param Gmap_Polygon $polygon Polygon
     * @return Gmap
     */
    public function addPolygon(Gmap_Polygon $polygon)
    {
        $this->polygons[$polygon->getId()] = $polygon;
        return $this;
    }

    /**
     * Add a polyline to the map.
     *
     * @param Gmap_Polyline $polyline Polyline
     * @return Gmap
     */
    public function addPolyline(Gmap_Polyline $polyline)
    {
        $this->polylines[$polyline->getId()] = $polyline;
        return $this;
    }

    /**
     * Cleanes the JSON strings by removing the quotes from google-variables.
     *
     * @param string $str
     * @return string
     */
    public static function clean_json_string($str)
    {
        return preg_replace('~"(google\.(.*?))"~', '$1', $str);
    }

    /**
     * Renders the google-map template.
     *
     * @uses Text::random()
     * @uses Arr::merge()
     * @param string $view Defines a view for rendering.
     * @return string
     */
    public function render($view = '', $force_enable = false)
    {
        // Bind the necessary variables.
        $this->view = View::factory($view ? $view : $this->view)
                ->bind('markers', $this->markers)
                ->bind('polylines', $this->polylines)
                ->bind('polygons', $this->polygons)
                ->bind('geocode_requests', $this->geocode_request)
                ->bind('instance', $this);

        // Render the view.
        $result = (!self::$enabled || $force_enable ? View::factory('gmap_enable')
                                ->render() : '')
                . $this->view->render();
        self::$enabled = true;
        return $result;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set a size for the rendered Google-Map.
     * You may set a CSS attribute like for example "500px", "50%" or "10em".
     * If you just set an integer, "px" will be used.
     *
     * @param mixed $width May be a CSS attribute ("500px", "50%", "10em") or an int.
     * @param mixed $height May be a CSS attribute ("500px", "50%", "10em") or an int.
     * @return Gmap
     */
    public function setSize($width = NULL, $height = NULL)
    {
        if ($width != NULL)
        {
            $this->width = (is_numeric($width)) ? $width . 'px' : $width;
        }
        if ($height != NULL)
        {
            $this->height = (is_numeric($height)) ? $height . 'px' : $height;
        }
        return $this;
    }

    /**
     * Set another map-type. Possible types are 'road', 'satellite', 'hybrid' and 'terrain'.
     *
     * @param Gmap_Maptype $maptype
     * @return Gmap
     */
    public function setMaptype(Gmap_Maptype $maptype)
    {
        $this->type = $maptype;
        return $this;
    }

    /**
     * Set a new position to show, when starting up the map.
     *
     * @param float $lat
     * @param float $lng
     * @return Gmap
     */
    public function setCenter($lat = NULL, $lng = NULL)
    {
        if ($lat != NULL)
        {
            $this->lat = Gmap::validate_latitude($lat);
        }
        if ($lng != NULL)
        {
            $this->lng = Gmap::validate_longitude($lng);
        }
        return $this;
    }

    /**
     * Is sensor set?
     * @return boolean
     */
    public static function getSensor()
    {
        return self::$sensor;
    }

    /**
     * Set the sensor-parameter for the google-api.
     *
     * @param boolean $sensor
     * @return Gmap
     */
    public static function setSensor($sensor)
    {
        if (!is_bool($sensor))
        {
            throw new Kohana_Exception('The parameter must be boolean. ":sensor" given', array(':sensor' => $sensor));
        } // if

        self::$sensor = $sensor;

        return $this;
    }

// function

    /**
     * Set the view for displaying the Google-map.
     *
     * @param string $view
     * @return Gmap
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

// function

    /**
     * Set the zoom level for the Google-map.
     *
     * @param int $zoom
     * @return Gmap
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
        return $this;
    }

    public function getOptions()
    {
        $res = array(
            'id' => $this->getId(),
            'lat' => $this->lat,
            'lng' => $this->lng,
            'zoom' => $this->zoom,
            'maptype' => (string) $this->type,
            'controls' => $this->getControls()->getOptions(),
        );

        return $res;
    }

    /**
     * Validate, if the latitude is in bounds.
     *
     * @param float $lat
     * @return float
     */
    protected static function validate_latitude($lat)
    {
        if ($lat > 180 OR $lat < -180)
        {
            throw new Kohana_Exception('Latitude has to lie between -180.0 and 180.0! Set to ":lat"', array(':lat' => $lat));
        } // if

        return $lat;
    }

// function

    /**
     * Validate, if the longitude is in bounds.
     *
     * @param float $lng
     * @return float
     */
    protected static function validate_longitude($lng)
    {
        if ($lng > 90 OR $lng < -90)
        {
            throw new Kohana_Exception('Longitude has to lie between -90.0 and 90.0! Set to ":lng"', array(':lng' => $lng));
        } // if

        return $lng;
    }

}

