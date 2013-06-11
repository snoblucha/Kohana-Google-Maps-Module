<?php

class Gmap_Marker {

    private $lat;
    private $lng;
    private $id;
    private $title;
    private $icon;
    private $content;

    /**
     * Create marker.
     * @param string/int $id
     * @param float $lat
     * @param float $lng
     * @return \Gmap_Marker
     */
    public static function factory($id, $lat, $lng)
    {
        return new Gmap_Marker($id, $lat, $lng);
    }

    public function __construct($id, $lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->id = $id;
        $this->title = $id;
    }

    /**
     * Path to icon.
     * @param string $icon
     * @return Gmap_Marker
     */
    public function icon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Set the content to be displayed on click on the marker
     * @param string $content Content of the popup window
     * @return Gmap_Marker
     */
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * returns json encoded value
     * @return string
     */
    public function render()
    {
        $res = array();
        foreach ($this as $key => $value)
        {
            $res[$key] = $value;
        }
        return json_encode($res);
    }

    public function __toString()
    {
        return $this->render();
    }

    /**
     * Get the defined id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}