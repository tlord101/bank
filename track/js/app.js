document.addEventListener("DOMContentLoaded", function() {
    let pusher = new Pusher('ebe203dcbf0a2d8071ee', {
        cluster: 'mt1'
    });

    let channel = pusher.subscribe('courier-tracking');
    channel.bind('location-update', function(data) {
        marker.setPosition(new google.maps.LatLng(data.latitude, data.longitude));
        map.setCenter(marker.getPosition());
    });

    // Handle form submission
    document.getElementById("locationForm").addEventListener("submit", function(e) {
        e.preventDefault();
        let location = document.getElementById("locationInput").value;
        geocodeLocation(location);
    });

    function geocodeLocation(location) {
        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: location }, function(results, status) {
            if (status === 'OK') {
                let lat = results[0].geometry.location.lat();
                let lng = results[0].geometry.location.lng();
                
                // Send the coordinates to the backend
                updateLocation(lat, lng);
            } else {
                alert('Geocoding failed: ' + status);
            }
        });
    }

    function updateLocation(lat, lng) {
        fetch("update-location.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `latitude=${lat}&longitude=${lng}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'Location updated') {
                console.log("Location updated successfully");
            } else {
                console.error("Failed to update location");
            }
        });
    }
});
