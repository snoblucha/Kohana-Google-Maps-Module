<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=<?php echo ($options['sensor']) ? 'true' : 'false'; ?>"></script>
<script type="text/javascript">
function Gmap(options){

        this.options = options;
        this.polyline_coords = {};
        this.polylines = {};
        this.polygons = {};
        this.polygon_coords = {};
        this.markers = {};
        this.info_windows = {};
        this.geocode_request = {};
        this.geocode_result = {};

    };


    Gmap.prototype.addPolyline = function(polyline){

        this.polyline_coords[polyline['id']] = [];

        for(j in polyline['coords']) {
            this.polyline_coords[polyline['id']].push( new google.maps.LatLng( polyline['coords'][j][0], polyline['coords'][j][0]));
        }

        this.polylines[polyline['id']] = new google.maps.Polyline({
            path: this.polyline_coords[polyline['id']],
            strokeColor: polyline['options']['strokeColor'],
            strokeOpacity: polyline['options']['strokeOpacity'],
            strokeWeight: polyline['options']['strokeWeight']
        });

        this.polylines[polyline['id']].setMap(this.map);
    }

    Gmap.prototype.addPolygon = function(polygon){

        this.polygon_coords[polygon['id']] = [];
        for( i in polygon['coords']){
            this.polygon_coords[polygon['id']].push(new google.maps.LatLng(polygon['coords'][i][0], polygon['coords'][i][1]));
        }

        this.polygons[polygon['id']] = new google.maps.Polygon({
            paths: this.polygon_coords[polygon['id']],
            strokeColor: polygon['options']['strokeColor'],
            strokeOpacity: polygon['options']['strokeOpacity'],
            strokeWeight: polygon['options']['strokeWeight'],
            fillColor: polygon['options']['fillColor'],
            fillOpacity: polygon['options']['fillOpacity']
        });

        this.polygons[polygon['id']].setMap(this.map);
    }

    Gmap.prototype.initialize = function(markers, polylines, polygons, gcrequests) {
        var options = {};
        options.center =  new google.maps.LatLng(this.options.lat, this.options.lng);
        options.zoom = this.options.zoom;
        options.mapTypeId =  eval(this.options.maptype);

        if (this.options['gmap_controls']['maptype']['display']){
            options.mapTypeControl = true;
            options.mapTypeControlOptions = {}
            options.mapTypeControlOptions.style = eval(this.options.gmap_controls.maptype.style);
            options.mapTypeControlOptions.position = eval(this.options.gmap_controls.maptype.position);
        } else {
            options.mapTypeControl = false;
        }

        if (this.options['gmap_controls']['navigation']['display']){
            options.navigationControl = true;
            options.navigationControlOptions = {}
            options.navigationControlOptions.style = eval(this.options.gmap_controls.navigation.style);
            options.navigationControlOptions.position = eval(this.options.gmap_controls.navigation.position);
        } else {
            options.navigationControl = false;
        }

        if (this.options['gmap_controls']['scale']['display']){
            options.scaleControl = true;
            options.scaleControlOptions = {}
            options.scaleControlOptions.style = eval(this.options.gmap_controls.scale.style);
            options.scaleControlOptions.position = eval(this.options.gmap_controls.scale.position);
        } else {
            options.scaleControl = false;
        }



        this.map = new google.maps.Map(document.getElementById("gmap_"+this.options.instance), options);

        if(polylines){
            for(i in polylines){
                this.addPolyline(polylines[i]);
            }
        }

        if(polygons){
            for(i in polygons) this.addPolygon(polygons[i]);
        }

        if(markers){
            for(i in markers){
                this.addMarker(markers[i]);
            }
        }

        if(gcrequests){
            for(i in gcrequests){
                this.geocode(gcrequests[i]);
            }
        }
    };

    Gmap.prototype.geocode = function(request){
        this.geocode_request[request['id']] = request;
        var geocoder = new google.maps.Geocoder();
        var gmRequest = {};
        var This = this;
        gmRequest.address = request.address;
        geocoder.geocode(gmRequest, function(result, status){
            if(status == google.maps.GeocoderStatus.OK) {//address found - add marker
                This.geocode_result[request['id']] = result;//store result
                request.lat = result[0].geometry.location.lat();
                request.lng = result[0].geometry.location.lng();
                This.addMarker(request);
            }
        });

    }

    Gmap.prototype.addMarker = function(marker){
        var options = {
            position: new google.maps.LatLng(marker.lat, marker.lng),
            map: this.map,
            title: marker.title
        };
        if(marker.icon){
            options.icon = marker.icon;
        }
        this.markers[marker.id] = new google.maps.Marker(options);
        if(marker.content){
            this.info_windows[marker.id] = new google.maps.InfoWindow({
                content: marker.content
            });
        }
        var This = this;
        google.maps.event.addListener(this.markers[marker.id], 'click', function() {
            This.info_windows[marker.id].open(This.map, This.markers[marker.id]);
        });

    };


    var gmaps = [];
    var markers, polylines, polygons, gcrequests;
</script>
