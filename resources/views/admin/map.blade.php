<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Map locations</title>
    <style>
       .gmnoprint .gm-style-mtc button{
            background:#ef2027!important;
            color:#fff!important;
        }
         .gmnoprint .gm-style-mtc button:hover, .gmnoprint .gm-style-mtc button:focus{
            border: 1px solid #cfc054!important;
        }
        .gm-control-active.gm-fullscreen-control{
             background: #ef2027!important;
            color:#fff!important;
        }
        .gm-control-active.gm-fullscreen-control img{
            filter: brightness(500%);
        }
         @font-face {
            font-family: 'Lato-Semibold';
            src: url('font/Lato-Semibold.ttf');
        }
         @font-face {
            font-family: 'Lato-Regular';
            src: url('font/Lato-Regular.ttf');
        }
        .gmnoprint button{
                background:#ef2027!important;
        }
        .gmnoprint button img{
            filter: brightness(500%);
        }
      </style>
</head>

<body>
<div id="map" style="height: 90vh; width: 100%;"></div>
    <div class="row" style="border: 1px solid #bfb2b2;background:#fff;width:100%;display: flex;align-items: center;height: 3.9rem;">
      <div style="width: 30%;text-align: center;" > <a style="background:#ef2027;color:#fff;padding:.5rem 2rem;border-radius:0px;margin-top:0px;text-decoration:none;font-family: 'Lato-Regular'; font-weight: 200;font-size: 14px;"
            href="{{ url('/dashboard') }}">Back To Dashboard<i class="fal fa-reply" style="padding-left: 5px;"></i></a></div>
       <div  style="width: 30%"> <p style="font-family: 'Lato-Regular';
    font-size: 14px;">Empty Map Location: <b> {{ $emptyMarker->count() }} </b></p></div>
       <div style="width: 40%"></div>
        <div style="width: 20%"></div>
    </div>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJdzfNK0VG9o40xK6P-haaVh3ognsx0fw&v=3.exp&callback=initMap"
        async defer></script>
  
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>

    <script>
      locations = []
    </script>
    @foreach ($markers as $index => $event)
      <script>
        locations.push({
          lat: parseFloat("{{ trim($event->lat) }}"),
          lng: parseFloat("{{ trim($event->lng) }}")
        })
      </script>
    @endforeach
    
    <script>
        function initMap() {

            //The center location of our map.
            var centerOfMap = new google.maps.LatLng(25.19777891746296, 55.278176647123736);
            //Map options.
            var options = {
                center: centerOfMap, //Set center.
                zoom: 7 //The zoom value.
            };

            //Create the map object.
            map = new google.maps.Map(document.getElementById('map'), options);

            const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            const markers = locations.map((location, i) => {
              return new google.maps.Marker({
                position: location,
                label: labels[i % labels.length]
              });
            });
          

            new MarkerClusterer(map, markers, {
              imagePath:
                "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
            });

        }

    </script>

</body>

</html>
