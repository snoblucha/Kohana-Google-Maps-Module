<?php

class Gmap_Object {

    private $id;

    /**
     * Get the defined id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    function __construct($id)
    {
        $this->id = $id;
    }

    public function getOptions()
    {
        return array(
            'id' => $this->getId(),
        );
    }

    public function __toString()
    {
        return $this->render();
    }

    /**
     * returns json encoded value
     * @return string
     */
    public function render()
    {
        $res = $this->getOptions();
        return json_encode($res);
    }

}
