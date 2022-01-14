<html>

<head>
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"> -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>

    <div class="main-content">

        <div class="container-fluid mb-5 mt-5 centerr">
            <h3> Current Location according to your Public IP Address </h3>

            <div class="info">This website uses <a href="http://ipinfo.io/">ipinfo </a> to get IP details and location and <a href="https://www.openstreetmap.org/">openstreetmap</a> for displaying map. Pleaase check their Terms of Service and Privacy Policy.
                <br>This is not that accurate as using location/GPS tracking which we are not doing on this website.
            </div>
            <div class="ipinfo" id="map">
            </div>
            <div id="mapview" style="height:70vh;">
                loading...
            </div>
        </div>


    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>



    <script>
        $(document).ready(function() {

            var elem = $("#map");


            $.ajax({
                url: "https://ipinfo.io/json?token=e05a9a77599629",
                method: "GET",
                dataType: "json",
                success: (data) => {
                    //update tags on every change
                    console.log(data);
                    var loc = data.loc.split(",")
                    elem.html("IP : " + data.ip + "<br> Region: " + data.region);

                    var map = L.map('mapview').setView([loc[0], loc[1]], 13);
                    console.log(data.loc);


                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                    console.log(data.loc);

                    L.marker([loc[0], loc[1]]).addTo(map)
                        .bindPopup('IP ADDRESS: ' + data.ip + "<br> Region: " + data.region + "<br>Location: " + data.loc)
                        .openPopup();
                    console.log(data.loc);

                },


                error: () => {
                    $("#mapview").html("Fetching info failed.");

                }
            })
        });
    </script>


</body>

</html>
