<?php defined('SYSPATH') or die('No direct access allowed.');

// Don't delete or rename any keys unless you know what you're doing!

return array (
	// Default map-center.
	'lat' => 50.5,
	'lng' => 14,

	// Default zoom-level.
	'zoom' => 12,



	// Default "sensor" setting - Used for mobile devices.
	'sensor' => FALSE,

        //should map be enabled automatically by default? It means, that at first render of
        // any map, also Gmap::enable() is included in output. See Readme for more details.
        'disableAutoEnable' => FALSE,

	// Default map-type.
	'maptype' => 'road', //satellite, hybrid, terrain


	// Default view-options.
	'view' => 'gmap',
	'width' => '600',
	'height' => '600',

	// Default Google Maps controls.
	'controls' => array(
		'maptype' => array(
			'display' => TRUE,
			'style' => 'default', //see Gmap_Controls_Maptype
			'position' => NULL, //top, top_left, and vice versa
		),
		'navigation' => array(
			'display' => TRUE,
			'style' => 'default',//see Gmap_Controls_Navigation
			'position' => NULL,
		),
		'scale' => array(
			'display' => TRUE,
			'position' => NULL,
		),
	),

	// Default options for polylines.
	'polyline' => array(
		'strokeColor' => '#000',
		'strokeOpacity' => 1,
		'strokeWeight' => 3,
            ),

	// Default options for polygons.
	'polygon' => array(
		//stroke params are taken from polyline
		'fillColor' => '#000',
		'fillOpacity' => .5,
	),
);