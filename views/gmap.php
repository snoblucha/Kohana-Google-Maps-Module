<script type="text/javascript">    
    window.onload = (function(){     
      gmaps['<?php echo $options["instance"] ?>'] = new Gmap(<?= json_encode($options) ?>);
      markers = <?= json_encode($marker) ?>;
      polylines = <?= json_encode($polylines) ?>;
      polygons = <?= json_encode($polygons) ?>;
      gcrequests = <?= json_encode($geocode_requests) ?>;                    
      gmaps['<?php echo $instance; ?>'].initialize(markers, polylines, polygons, gcrequests);
    });
</script>
<div id="gmap_<?php echo $options['instance']; ?>" 
     style="width:<?php echo $options['gmap_size_x']; ?>; height:<?php echo $options['gmap_size_y']; ?>">
</div>