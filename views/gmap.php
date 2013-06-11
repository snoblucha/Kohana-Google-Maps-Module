<script type="text/javascript">
    window.onload = (function(){
      gmaps['<?php echo $options["instance"] ?>'] = new Gmap(<?= json_encode($options) ?>);

      <?foreach ($markers as $marker):?>
            gmaps['<?php echo $instance; ?>'].addMarker(<?= $marker ?>);
      <?endforeach;?>

      <?foreach ($polylines as $polyline):?>
            gmaps['<?php echo $instance; ?>'].addPolyline(<?= $polyline ?>);
      <?endforeach;?>

      <?foreach ($polygons as $polygon):?>
            gmaps['<?php echo $instance; ?>'].addPolygon(<?= $polygon ?>);
      <?endforeach;?>

      <?foreach ($geocode_requests as $gcrequest):?>
            gmaps['<?php echo $instance; ?>'].geocode(<?= $gcrequest ?>);
      <?endforeach;?>

      //gmaps['<?php echo $instance; ?>'].initialize(markers, polylines, polygons, gcrequests);
    });
</script>

<div id="gmap_<?php echo $options['instance']; ?>"
     style="width:<?php echo $options['gmap_size_x']; ?>; height:<?php echo $options['gmap_size_y']; ?>">
</div>