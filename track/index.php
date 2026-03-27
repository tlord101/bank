<!DOCTYPE html>
<html>
<head>
    <title>Courier Tracking</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAzA2iR8Xv4ElOu17s1h72BDnH78DbOgQ"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="js/app.js" defer></script>
</head>
<body>
    <div id="map" style="height: 500px; width: 100%;"></div>

    <script>
        let map;
        let marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: -34.397, lng: 150.644 },
                zoom: 8
            });

            marker = new google.maps.Marker({
                position: { lat: -34.397, lng: 150.644 },
                map: map,
                title: 'Courier Location'
            });
        }

        window.onload = initMap;
    </script>
</body>
</html>
