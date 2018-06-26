<!DOCTYPE html>
<?php
//include 'config.php';
require 'function.php';
require 'head.php';

$url = 'http://smartme-data.unime.it/api/3/action/package_list';
$dataset = call_api($url);

$res_limit = array(145 => "Last 24 Hours", 289 => "Last 48 Hours", 433 => "Last 3 Days", 910 => "Last Week");

$limit = (int)(isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 145;

$unit = array("temperature" => "C", "brightness" => "Lux", "humidity" => "%", "pressure" => "hPa", "gas" => "ppm", "noise" => "Amp");

?>
<body>
<div id="mapdiv" style="height:100vh"></div>

<script type="text/javascript" src="assets/dist/js/jquery-2.2.1.min.js"></script>

<!-- Bootstrap 3.3.5 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/leaflet.js"></script>
<script type="text/javascript" src="js/leaflet.markercluster.js"></script>


<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="assets/plugins/fastclick/fastclick.min.js"></script>

<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>
<script src="assets/highstock.js"></script>
<script src="assets/jsonpath.js"></script>
<script src="js/moment.js"></script>
<!--script src="js/jquery.clipchamp.mjpeg.player.js"></script !-->


<div class="modal fade" id="sensor_modal"  tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="pull-right" data-dismiss="modal" aria-label="Close">
                    <span class="fa fa-close"></span>
                </a>
                <h3 class="modal-title">
                    <p>
                        <span id="sensor_name"></span> in <span id="measure_unit"></span>
                    </p>
                    <div class="pull-right">
                        <a id="download_csv" href="http://smartme-data.unime.it/datastore/dump/{{$resource_id}}"
                           class="btn btn-warning btn-sm"><span class="fa fa-download"></span> Download CSV
                        </a>
                        <a id="open_data_link" target="_blank" href="http://smartme-data.unime.it/dataset/{{$pack_name}}/resource/{{resource_id}}"
                           class="btn btn-primary btn-sm"><span class="fa fa-external-link"></span> Open Data
                        </a>
                    </div>
                </h3>
                <p class="small">Viewing <?=$res_limit[$limit]?></p>
                <div class="form-group form-inline">
                    <label>Data view:</label>
                    <select class="form-control" id="modal_last_result">
                        <?php
                        foreach ($res_limit as $k => $v) {
                            $t = ($k == $limit) ? "selected " : "";
                            echo '<option value="' . $k . '" ' . $t . ">" . $v . "</option>\n";
                        }
                        ?>
                        <option value="m">Last 30 days</option>
                    </select>
                </div>
            </div>
            <!-- Main content -->
            <div class="modal-body">
                <div class="row">
                    <div id="chart" class="col-xs-12 col-md-12">
                        <div id="hicharts" class="col-xs-12 col-md-12"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="info_modal"  tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
    <script type="text/javascript" src="assets/dist/js/leaflet-realtime.min.js"></script>
<script>

    $(document).ready(function () { 

        // Funzioni di supporto
        // inserimento dei mark dall'elenco delle BOARDS.
         var taxi_icon = L.icon({
                iconUrl: "img/taxi_marker.png",
                iconSize: [26,32]
            });

        function GetTaxi() {
            return false;
            $.getJSON({url:"/jsonp_call.php?taxi=1"})
            
            .done(function (data) {
               $.each(data,function(k,pack){
                   try{
                        if(pack.geometry.type==="Point"){
                        var lat = pack.geometry.coordinates[1];
                        var long = pack.geometry.coordinates[0];
                        var taxi_icon = L.icon({
                            iconUrl: "img/taxi_marker.png",
                            iconSize: [26,32]
                        });

                        var popup = L.popup({maxWidth: 700, minWidth: 200})
                            .setContent(
                            '<div class="punto" id="' + pack.properties.id + '" ' +
                            'pack="' + pack.properties.id + '" ><b>' + pack.properties.id + " " +pack.properties.popupContent + '</b>' +
                            '<br>\n' +
                            '<span class="sample_date text-light-blue">&nbsp;</span>' +
                            '</div>');

                        var marker = L.marker([lat, long], {title: "Taxi: " + pack.properties.id, icon: taxi_icon }).bindPopup(popup);

                        taxi.addLayer(marker);
                        map.addLayer(taxi);
                    } 
                   } catch(e){
                       console.log(e);
                   }
                   
                   
                })
            })
            .fail(function(error){
                console.log(error);
            })
        }

        function GetSensoriConDati() {
            var jcall = JsonpCall(package_url, "", 1000, "GetCKAN");
            var res = [];
            var extras = [];

            var board_spente = ["",  "sme-00-0006 - Policlinico Universitario", "sme-00-0016 - Villa Pace"];

            jcall.done(function (data) {
                $.each(data.result, function (k, v) {
                    extras = v.extras;
                    var lat;
                    var long;
                   // if (typeof v.organization.title === 'undefined') {return true};
                    if (v.num_resources > 0 && v.organization.title == ckan_organization && (board_spente.indexOf(v.notes) < 0)) {
                        packages[k] = {
                            id: v.id,
                            lat: "",
                            long: "",
                            label: "",
                            name: v.name,
                            resources: [],
                            sensori: ""
                        };

                        $.each(v.resources, function (kk, vv) {
                            if (vv.name) {
                                packages[k]['resources'].push({name: vv.name, id: vv.id})
                            }
                        });

                        if (extras.length) {
                            for (var i = 0; i < extras.length; i++) {
                                var record = extras[i];
                                switch (record.key) {
                                    case "Label":
                                        packages[k]['label'] = record.value;
                                        break;
                                    case "Latitude":
                                        packages[k]['lat'] = record.value;
                                        break;
                                    case "Longitude":
                                        packages[k]['long'] = record.value;
                                        break;
                                }
                            }
                        }
                    }
                });
            }).then(function () {
                for (var i = 0; i < packages.length; i++) {
                    var pack = packages[i];
                    try {
                        if (pack.lat) {
                            var lat = pack.lat;
                            var long = pack.long;
                            var elenco_sensori = "";
                            var board = "";
                            var sensori = pack.resources;
                            for (var j = 0; j < sensori.length; j++) {
                                if (sensori[j].name != "sensors") {
                                    var sensor_url = (sensori[j].name == "gas") ? "" : 'pack_name=' + pack.name + '&id=' + sensori[j].id + '&limit=<?=$limit?>&sensor=' + sensori[j].name;
                                    var padding = (sensori[j].name == "gas") ? " Coming Soon" : "";

                                    elenco_sensori += '<a class="list-group-item call_modal ' + icons[sensori[j].name].color +
                                        ' bold" style="color:white" sensor-name="' + sensori[j].name +
                                        '" id="' + sensori[j].id + '" pack_name="' + pack.name +
                                        '" url="' + sensor_url + '" href="#sensor_modal">' +
                                        '<i class="' + icons[sensori[j].name].icon + '"></i> '
                                        + sensori[j].name + ' <span class="label text-maroon" style="background-color: white">'
                                        + padding + "</span></a>\n";
                                } else {
                                    board = '&nbsp;<a class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#info_modal" href="details.php?pack_name=' + pack.name + '&pack_id=' + pack.id + '&res_id=' + sensori[j].id + '">' +
                                        '<i style="color: white" class="fa fa-info-circle"></i></a>' + "<br><br>\n";
                                }
                            }
                            if (lat) {
                                var yun = L.icon({
                                    iconUrl: "img/red-dot.png",
                                    iconSize: [32,32]
                                });

                                var marker = L.marker([lat, long], {title: pack.label, icon: yun });
                                var popup = L.popup({maxWidth: 500, minWidth: 180})
                                    .setContent('<div class="punto" id="' + pack.id + '" pack="' + pack.id + '" ><b>' + pack.label + '</b>' + board + '<br>\n<span class="sample_date text-light-blue">&nbsp;</span>' +
                                    '<div class="list-group text-left">' + elenco_sensori + '</div></div>');

                                marker.bindPopup(popup);
                                sensors.addLayer(marker);
                                map.addLayer(sensors);
                            }

                        }
                    } catch (err) {
                        console.log(".");
                    }

                }
            });


        }

        function getParkingInfo(){
            
            var free, busy;

            $.getJSON("./jsonp_call.php?parking=true").done(function(data) {
                   var t = JSON.parse(JSON.stringify(data));
                    console.log(t);
                    
                    var resource_id = '89bf03ee-89e0-437b-8ed5-e28d5a731185'
                    var link_to_graph = '<a class="list-group-item call_modal ' +
                                    ' bold" style="color:black; background:LightBlue" sensor-name="Free parking lots " '+
                                    ' id="' + resource_id + '" pack_name="" url="' + resource_id + '" sensor_type="free" sensor_unit="lots unit" href="#sensor_modal"><i class="fa fa-bar-chart"></i> View Stats </a>\n'

                   $('#parking_info').html('<br><b>parking lot free: ' + t.free + "/" + 22 + "</b><br>" +
                        '<div>'+ link_to_graph +'</div>'
                   );
                }
            )
            
        };

        function GetEnergy() {
            var jcall = JsonpCall(package_url, "", 12, "GetCKAN");
            //var extras = [];

            var packs=[];

            jcall.done(function (data) {
                $.each(data.result, function (k, v) {
                    extras = v.extras;
                    var lat;
                    var long;
                    
                    if (typeof v !== 'undefined' ) { 
                        var isEnergy = v.title.startsWith('CIAM-ESaving');
                        if (v.num_resources > 0 && isEnergy) {
                        packs[k] = {
                            id: v.id,
                            lat: "",
                            long: "",
                            label: "",
                            name: v.name,
                            resources: [],
                            sensori: ""
                        };

                        $.each(v.resources, function (kk, vv) {
                            if (vv.name) {
                                packs[k]['resources'].push({name: vv.name, id: vv.id})
                            }
    
                        });

                        var position = {};
                        try {

                            var t = EnergyCall("jsonp_call.php",packs[k]['resources'][1].id, 1,"GetCKAN").responseText;
                            position = JSON.parse(t);

                        } catch (e_1){
                            console.log(e_1)
                        }
                    
                        var record = position[0];
                        if(record){
                                   packs[k]['date'] = record.date;
                                   packs[k]['lat'] = record.Latitude;
                                   packs[k]['long'] = record.Longitude;
                                   packs[k]['value'] = record.value;
                                   packs[k]['unit'] = record.Unit;
                        }
                      }
                        
                    };
                    
                });

            }).then(function () {

                for (var i = 0; i < packs.length; i++) {
                    var pack = packs[i];
                    var elenco_sensori = '';
                    try {
                        if (pack.lat) {
                            var lat = pack.lat;
                            var long = pack.long;

                            var energy_icon = L.icon({
                                iconUrl: "img/energy_marker.png",
                                iconSize: [19,32]
                            });

                            var sensori = pack.resources;
                            for (var j = 0; j < sensori.length; j++) {
                                
                                var sensor_url = 'pack_name=' + pack.name + '&id=' + sensori[j].id + '&limit=<?=$limit?>';

                                elenco_sensori += '<a class="list-group-item call_modal ' +
                                    ' bold" style="color:black" sensor-name="' + sensori[j].name +
                                    '" id="' + sensori[j].id + '" pack_name="' + pack.name +
                                    '" url="' + sensor_url + '" sensor_type="energy" sensor_unit="'+ pack.unit +'" href="#sensor_modal">' +
                                    sensori[j].name + ' <span class="label text-maroon" style="background-color: DarkKhaki"></span></a>\n';
                            }

                            var popup = L.popup({maxWidth: 700, minWidth: 200})
                                .setContent(
                                '<div class="punto"  id="' + pack.id + '" ' +
                                'pack="' + pack.id + '" ><b>' + pack.name + '</b>'+
                                '<br>\n' +
                                '<span class="sample_date text-light-blue">&nbsp;</span>' +
                                '<div class="list-group text-left" >' + elenco_sensori + '</div></div>');

                            var marker = L.marker([lat, long], {title: pack.name, icon: energy_icon }).bindPopup(popup);

                            energy.addLayer(marker);
                            map.addLayer(energy);
                        }
                    } catch (err) {
                        //console.log(err);
                    }
                }
            });
        }

        function GetCam(){

            var cam_icon = L.icon({
                iconUrl: "img/cam_marker.png",
                iconSize: [20,32]
            });

           var popup = L.popup({maxWidth: 700, minWidth: 200})
                                .setContent('<div class="cam" style="width: 320px;"><img id="camera" width="320" height="240" src="http://212.189.207.225:8282/mjpg/video.mjpg" /></div>');
            var marker = L.marker([38.25949,15.59525], {title: "security_cam", icon: cam_icon }).bindPopup(popup);
            cam.addLayer(marker);
            map.addLayer(cam); 
        }

        function GetParkingCam(){

            var cam_icon = L.icon({
                iconUrl: "img/park_marker.png",
                iconSize: [20,32]
            });

           var popup = L.popup({maxWidth: 700, minWidth: 200})
                                .setContent('<div class="parking_cam" style="width: 420px; position: relative;"><img id="parking_camera" width="420" src="http://psmdmi.parksmart.it:9012/imgs/cam1.jpg" /><object id="svg_cam_1" data="http://psmdmi.parksmart.it:9012/css/cam1.svg" type="image/svg+xml" class="img-responsive" style="position: absolute; top: 0px;left: 0;">your browser does not support svg</object></div><spa>Engineering Department\' Parking Area<span id="parking_info"></span>');
            var marker = L.marker([38.25860, 15.59639], {title: "parking_cam", icon: cam_icon }).bindPopup(popup);
            parking.addLayer(marker);
            map.addLayer(parking); 
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function JsonpCall(url, val, limit, func) {

            var data_call = $.ajax({
                url: url,
                dataType: 'jsonp',
                async: false,
                cache: true, // necessario per interrogare ckan
                data: {"resource_id": val, "limit": limit},
                jsonpCallback: func
            });
            return data_call;
        }

        function EnergyCall(url, val, limit, func) {
            var limit = limit || 150;
            var data_call = $.ajax({
                url: url,
                dataType: 'json',
                async: false,
                //cache: true, // necessario per interrogare ckan
                data: {"energy_id": val, "limit": limit},
                jsonpCallback: func
            });
            console.log(data_call);
            return data_call;
        }

        function GetSensorList(data) {
            $.each(data.result.records, function (k, v) {
                if (v.name != "_table_metadata") {
                    sensori[k] = v;
                }
            });
        }

        function GetCKAN(data) {
            return data;
        }

        function PotHolesLoad() {
            $.getJSON({
                url: 'jsonp_call.php?potholes=1',
                error: function (e) {
                    console.log(e);
                }
            }).done(function(data){
                HolesLoaded(data);
            });

        }
        function HolesLoaded(d) {
            // console.log(data);
            for (var i = 0; i < d.length; i++) {
                var pack = d[i];
                try {
                    var lat = pack.lat;
                    var long = pack.lon;
                    var bump = L.icon({
                        iconUrl: "img/icon_pothole.png",
                        iconSize: [32,32]
                    });
                    var marker = L.marker([lat, long], {title: pack.address, icon: bump});
                    var popup = L.popup({maxWidth: 500, minWidth: 180})
                        .setContent('<div class="punto " id="' + pack.id + '" pack="' + pack.id + '" > ' +
                        '<h4> <b>'+ pack.num + '</b> Reports.</h4>' +
                        '<h4>' + pack.address + '</h4>' +
                        '<h4>Mean Acceleration from <b>' + Math.round10(pack.minMeanAcc ,-2)+ '</b>' +
                        ' to <b>' + Math.round10(pack.maxMeanAcc,-2)+ '</b>' +
                        '</h4></div>');
                    marker.bindPopup(popup);
                    potholes.addLayer(marker);
                    map.addLayer(potholes);
                } catch (err) {
                    console.log(err);
                }

            }
        }

        // variabili globali

        var roads = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> - by <b>Ciam</b>'
        });

        var map = L.map('mapdiv', {
            center: [38.20523, 15.55972],
            zoom: 10,
            layers: roads
            });

        var sensors = L.markerClusterGroup({});
        var potholes = L.markerClusterGroup({});
        var energy = L.markerClusterGroup({disableClusteringAtZoom: 13});
        var taxi = L.markerClusterGroup({disableClusteringAtZoom: 9});
        var cam = L.layerGroup();
        var parking = L.layerGroup();
        var polyline;
        var point_layer = L.layerGroup();
        var Chart = "";
        var parking_resource_ids = ['89bf03ee-89e0-437b-8ed5-e28d5a731185'];

        var packages = [];
        var sensori = [];
        var ckan_organization = "SmartMe";
        var limit = <?=json_encode($limit)?>;
        var unit = <?=json_encode($unit)?>;

        var icons = {
            noise: {color: "bg-navy", icon: "fa fa-volume-up", name: "noise"},
            temperature: {color: "bg-orange", icon: "fa fa-sun-o", name: "temperature"},
            brightness: {color: "bg-green", icon: "fa fa-lightbulb-o", name: "brightness"},
            light: {color: "bg-green", icon: "fa fa-lightbulb-o", name: "brightness"},
            humidity: {color: "bg-aqua", icon: "fa fa-tint", name: "humidity"},
            relativehumidity: {color: "bg-aqua", icon: "fa fa-tint", name: "humidity"},
            pressure: {color: "bg-purple", icon: "fa fa-dot-circle-o", name: "pressure"},
            gas: {color: "bg-maroon", icon: "fa fa-industry", name: "co2 / no2"},
            accelerometer: {color: "bg-blue-gradient", icon: "fa fa-dashboard", name: "accel."},
            linearacceleration: {color: "bg-blue-gradient", icon: "fa fa-tachometer", name: "lin. acceleration"},
            gravity: {color: "bg-blue-gradient", icon: "fa fa-globe", name: "gravity"},
            speed: {color: "bg-green-gradient", icon: "fa fa-road", name: "speed"},
            gyroscope: {color: "bg-red-gradient", icon: "fa fa-undo", name: "gyroscope"},
            rotationvector: {color: "bg-red-gradient", icon: "fa fa-repeat", name: "rotation vector"},
            magneticfield: {color: "bg-blue-gradient", icon: "fa fa-magnet", name: "magnetic field"},
            magnetometer: {color: "bg-blue-gradient", icon: "fa fa-magnet", name: "magnetometer"},
            proximity: {color: "bg-teal-gradient", icon: "fa fa-mobile", name: "proximity"}
        };

        function FetchTaxi(){
            
            $.getJSON('/jsonp_call.php?taxi=true')
            .done(function(data){
                try{
                    var t = JSON.parse(localStorage.getItem('taxi'));
                }catch(e){
                        console.log(e);
                }
                
               var max = data.length;
        // controllare l'id data... e aggiungere id_tail feature.coordinate
               for (i=0; i< max; i++){
                   try{
                        if(typeof data[i+1] != "undefined" && data[i+1].geometry.type=="LineString")
                                                data[i+1].geometry.coordinates.push(data[i].geometry.coordinates);
                        console.log(data[i]);
                   }catch(ee){
                       console.log(data[i],data[i+1].geometry);
                   }
               }
               //console.log(data);  
               console.log(j++); 

               localStorage.setItem('taxi', JSON.stringify(data));
               return data;
            });
        }

        // GET TAXI in RealTime...
        
        realtime_taxi = L.realtime( 'jsonp_call.php?taxi=true' ,
            {
                pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, {icon: taxi_icon})
                },
                onEachFeature: function onEachFeature(feature, layer) {
                    if (feature.properties) {
                        var popupContent = '<div class="punto" id="' +  feature.properties.id  + '" ' +
                                'pack="' +  feature.properties.id + '" >' +
                                '<h4 class="text-center" ><span class="label label-success">' + feature.properties.id + '</span></h4>';
                        popupContent += '<div class="text-center"><ul class="list-group">';
                        popupContent += '<li class="list-group-item text-left">' + feature.properties.popupContent + ' </li>';
                        popupContent += '</ul><p class="small">Last Sample: ' + feature.properties.date + '</p></div></div>';
                        layer.bindPopup(popupContent, {minWidth: 200});
                    }
                },
                interval: 3000
            }
        );
        

        var overlayMaps = {
            "SmartME Potholes": potholes,
            "SmartME Sensors" : sensors,
            "SmartME Taxi" : realtime_taxi,
            "SmartME Energy" : energy,
            "SmartME Parking" : parking,
            "LiveCam" : cam
        };

      
        var lcontrol = L.control.layers("",overlayMaps).addTo(map);
        // elenco dei packages si trova alla seguente URL:
        var package_url = "http://smartme-data.unime.it/api/3/action/current_package_list_with_resources";

        // esecuzione prima chiamata per la generazione dell'elenco dei sensori
        GetTaxi();
        GetSensoriConDati();
        PotHolesLoad();
        GetCam();
        GetEnergy();    
        GetParkingCam();
        
        /*
        var timeout = 1000;
        var j=0;
        setInterval(FetchTaxi(),timeout);
        */
        map.on('popupopen', function (e) {
            var t= e.target._popup._content;
            
            var el = $('<div></div>');
            var link = [];
            el.html(t);
            var parking_cam = $($(el)[0]).children('div').hasClass('parking_cam');
            if (parking_cam){
                var t = getParkingInfo();
                $('#parking_info').html(t);
                return true;
            }
            var security_cam = $($(el)[0]).children('div').hasClass('cam');

            if (security_cam){
                security_cam = el[0].getElementsByClassName('cam')[0];
                var random = Math.floor(Math.random() * Math.pow(2, 31));
                $(security_cam).html('<img id="camera" width="320" height="240" src="http://212.189.207.225:8282/mjpg/video.mjpg?r=' + random + '" ssrc="/jsonp_call.php?cam=true" \>');
                //var img ="/jsonp_call.php?cam=true+image.png";
                var img = 'http://212.189.207.225:8282/mjpg/video.mjpg?r=' + random ;
                $('#camera').attr('src' , img);
                return true;
            }
            var pack_id = el[0].getElementsByClassName('punto')[0].getAttribute("pack");
            var AllData = $.getJSON('jsonp_call.php?pack_name=' + pack_id);
            AllData.done(function (data) {
                // imposto data ultimo sample
                //el[0].getElementsByClassName('sample_date')[0].innerHTML = data[0].date;

                //console.log(el[0].getElementsByClassName('sample_date')[0]);

                var all_sens = $('a', el).filter(function (k, val) {
                    var sensor_id = val.toString().split("=")[0];

                   // console.log(sensor_id);

                    if (sensor_id) {
                        var text = capitalizeFirstLetter(val.text.trim());
                        var result = JSONPath("$..*[?(@.name==='" + text + "')]", AllData);

                        if (result.length) {
                            var t = result[0].value;
                            var d = result[0].date;
                            var id_element = val.getAttribute('id');
                            if (val.getAttribute('id') == result[0].id) {
                                var tt = $("#" + id_element).html();
                                $("#" + id_element).html(tt + ' <span class="text-center text-bold pull-right">' + t + '</span>');
                            }
                            $(".sample_date").html("Last Sample: <b>" + data[0].date + "</b>");
                        }
                    }
                });
            });
        });

        $("#last_result").change(function () {
            window.location = "<?=$_SERVER['PHP_SELF']?>?limit=" + $(this).val();
        });

        $(".modal").on('hidden.bs.modal',  function (e) {
            $(this).data('bs.modal', null);
            $(this).removeData('bs.modal');
        });


        // Returns: the SQL SELECT Statement to retrieve data from the database
        // ( see 'this.getData_sql' )
        function prepareSqlStatement ( resId, sensor ,limit) {
            sensor_field = capitalizeFirstLetter(sensor);
            // workaround per differenza di co
            var isParking = parking_resource_ids.indexOf(resId) > -1;
            var time_field = "Date";
            if (sensor == 'value') sensor_field="value"; //solo per SmartEnergy!
            if(isParking) {
                time_field = "timestamp";
                sensor_field = "free";
            }
            
            var sqlStatement = '';

            sqlStatement += 'SELECT "'+ time_field +'" as x , "'+ sensor_field +'" as y';
            sqlStatement += ' from ' +'"'+resId+'" ';
            //sqlStatement += 'WHERE "Date" BETWEEN '+'\''+hourlyConfig.to_thisDate.toISOString()+'\' '+ 'AND ' +'\''+hourlyConfig.from_thisDate.toISOString()+'\' ';
            sqlStatement += ' WHERE "'+ time_field +'" BETWEEN '+'\''+moment().subtract(limit,'days').toISOString()+'\' '+ ' AND ' +' \''+moment().toISOString() +'\'' ;
            sqlStatement += ' ORDER BY "'+ time_field +'" ASC';

            return sqlStatement;

            // It returns something like this!
            // SELECT "Temperature", "Date" from "8e943f1c-75c6-4c94-a3b3-d508a549ebbc" WHERE "Date" BETWEEN '2017-02-06T09:57:00.000Z' AND '2017-02-07T09:57:00.000Z' ORDER BY "Date" DESC
        }


        function DrawGraph(url, resourceId, sensor_name,lim, sensor_unit){
            url = url + '?sql=' + prepareSqlStatement(resourceId , sensor_name, lim);
            var chart_width = parseInt($('.modal-lg').width() -50 );
            var records = [];

            var unit_label = (typeof unit[sensor_name] === 'undefined')?unit:unit[sensor_name];

            //console.log(unit_label);
            try{
               //Chart.destroy()
            }catch(e){
                console.log(e);
            }
            var options =  {
                    chart: {
                        type: 'line',
                        renderTo: "hicharts",
                        height: '320',
                        width: chart_width
                    },
                    title: {
                        text: sensor_name + " samples."
                    },
                    rangeSelector: {
                        buttons: [{
                            type: 'hour',
                            count: 1,
                            text: '1h'
                        }, {
                            type: 'hour',
                            count: 3,
                            text: '3h'
                        }, {
                            type: 'day',
                            count: 1,
                            text: '1d'
                        }, {
                            type: 'day',
                            count: 3,
                            text: '3d'
                        },{
                            type: 'all',
                            text: 'All'
                        }],
                        inputEnabled: true, // it supports only days
                        selected: 4 // all
                    },
                    xAxis: {
                        dateTimeLabelFormats: {
                            hour: "%b %e, %H:%M",
                            month: '%e. %b',
                            year: '%b'
                        },
                        type: 'datetime'
                    },
                    yAxis: {
                        title: {
                            text: 'measure unit:' + unit_label
                        }
                    },
                    tooltip: {
                        valueDecimals: 1,
                        valueSuffix: " " + unit_label
                    },
                    series: [{
                        name: sensor_name,
                        data: records
                    }],
                    plotOptions:{
                        series:{
                            turboThreshold:5000//set it to a larger threshold, it is by default to 1000
                        }
                    }
                  };
            var dati_sensore = $.getJSON( {url: url, //url ,
                 //data: { "sql": prepareSqlStatement( resourceId , sensor_name ) },
                 dataType: 'jsonp'
            }).done(function (data){
                $.each(data.result.records, function (k, v) {
                  v.x = new Date(v.x);
                  v.y = parseFloat(v.y);
                  //records.push({ x: Date(v.x) , y: parseFloat(v.y)}) 
                  
                });
                records = data.result.records;
                options.series[0].data =records;
                

            }).always(function(data){
                Chart = new Highcharts.StockChart(options);
                if (sensor_name == "noise" || sensor_name =="Noise")
                    addNoise(Chart);
            });

        }

        function DrawTrack(url){
            var latlng = [];
            var dati_sensore = $.getJSON(url ,
                function(data) {
                    $.each(data, function (k, v) {
                        latlng.push(new L.latLng([v.lat, v.lng]));
                    });
                    return data;
                });

            dati_sensore.done(function (data){
                // create a red polyline from an array of LatLng points

                try{
                    map.removeLayer(potholes);
                    map.removeLayer(sensors);
                    map.removeLayer(polyline);

                }
                catch(e){
                    console.log(e);
                }

                polyline = L.polyline(latlng, {color: 'red'});

                //setStartStop(data);

                map.addLayer(polyline);
                map.fitBounds(polyline.getBounds());
                map.closePopup();
            });

        }

        function setStartStop(data){

            console.log(L._layer);

            var max = data.length;
            var divisors = parseInt(data.length % 10);
            var popup = null;

            if (divisors > 3){
                for( var i = 0; i<max; i+=divisors ){
                    point_layer = L.marker(data[i], {title: data[i].date});

                    popup = L.popup({maxWidth: 700, minWidth: 200})
                        .setContent('<div><b>' + data[i].date + '</b></div>');

                    point_layer.bindPopup(popup);
                    map.addLayer(point_layer);
                }
            } else {
                point_layer = L.marker(data[0], {title: data[0].date});

                popup = L.popup({maxWidth: 700, minWidth: 200})
                    .setContent('<div><b>' + data[0].date + '</b></div>');

                point_layer.bindPopup(popup);
                map.addLayer(point_layer);

                point_layer = L.marker(data[max-1], {title: data[max-1].date});

                popup = L.popup({maxWidth: 700, minWidth: 200})
                    .setContent('<div><b>' + data[max-1].date + '</b></div>');

                point_layer.bindPopup(popup);
                map.addLayer(point_layer);

            }


        }


        $(document).on('click', '.track-modal', function(e){

            e.preventDefault();
            id_sensor = $(this).attr('id');
            sensor_name =  $(this).attr('sensor-name');
            post_data = $(this).attr('url');
            pack_name = $(this).attr('pack_name');
            unit  = <?=json_encode($unit)?>;

            url = 'jsonp_call.php?pack_name=' + pack_name + '&limit=<?= $limit ?>&sensor=undefined';

            DrawTrack(url);

            $("#track_modal").modal('show');

        });

        $(document).on('click' , '.call_modal', function(e)
        {
            e.preventDefault();
            
             id_sensor = $(this).attr('id');
             sensor_name =  $(this).attr('sensor-name');
             if (sensor_name == 'gas') return 0;
             
             post_data = $(this).attr('url');
             pack_name = $(this).attr('pack_name');
             isEnergy = $(this).attr('sensor_type') || ""; // Solo per SmartEnergy
             unit  = $(this).attr('sensor_unit') || <?=json_encode($unit)?>;
             var unit_label = (typeof unit[sensor_name] === 'undefined')?unit:unit[sensor_name];
            $("#sensor_name").html(capitalizeFirstLetter(sensor_name));
            $("#measure_unit").html(unit_label);
            $('#download_csv').attr('href', 'http://smartme-data.unime.it/datastore/dump/' + id_sensor);
            $('#open_data_link').attr('href', 'http://smartme-data.unime.it/dataset/' + pack_name + '/resource/' + id_sensor);


            // url = 'jsonp_call.php?id=' + id_sensor+ '&limit=<?= $limit ?>&sensor=' + sensor_name;
            url = 'http://smartme-data.unime.it/api/action/datastore_search_sql';

            if(isEnergy) sensor_name = "value"; // solo per Energy
            DrawGraph(url,id_sensor,sensor_name, 1, unit);
        

            $("#sensor_modal").modal('show');

        });

        function addNoise (chart){
            // CASE NOISE add plot bands
               
                chart.yAxis[0].addPlotBand(
                    {
                        from: 8.25,
                        to: 43,
                        color: 'rgba(68, 170, 213, 0.1)',
                        label: {
                            text: 'Talk Loudly',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, {
                        from: 43,
                        to: 115,
                        color: 'rgba(0, 0, 0, 0)',
                        label: {
                            text: 'Phone Ring, Loud radio/tv',
                            style: {
                                color: '#FFFFFF'
                            }
                        }
                    }, {
                        from: 115,
                        to: 394,
                        color: 'rgba(68, 170, 213, 0.1)',
                        label: {
                            text: 'Alarm Ringtone, Party, Traffic',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, {
                        from: 394,
                        to: 1000,
                        color: 'rgba(0, 0, 0, 0)',
                        label: {
                            text: 'Rush Hour Traffic',
                            style: {
                                color: '#606060'
                            }
                        }
                    })
                    
                    chart.tooltip.options.formatter = function () {
                            var s = '<span class="small">' + Highcharts.dateFormat("%A, %b %e,  %H:%M", this.x) + '</span>';
                            $.each(this.points, function () {
                                var yy = this.y;
                                var label;
                                switch (true) {
                                    case (yy < 2.75):
                                        label = "rustle";
                                        break;
                                    case (yy >= 2.75 && yy < 4):
                                        label = "library";
                                        break;
                                    case (yy >= 4 && yy < 8.25):
                                        label = "domestic enviroment";
                                        break;
                                    case (yy >= 8.25 && yy < 43):
                                        label = "talk loudly";
                                        break;
                                    case (yy >= 43 && yy < 115):
                                        label = "phone ring, loud radio/tv";
                                        break;
                                    case (yy >= 115 && yy < 394):
                                        label = "ringtone, party, road";
                                        break;
                                    case (yy >= 394):
                                        label = "rush hour traffic";
                                        break;
                                }

                                s += '<br/>' + this.series.name +
                                    ': Amp <b>' +
                                this.y.toFixedDown(2) + '</b><br>  ' +
                                    '<b class="text-center">' + label + '</b>';
                            });
                            return s;
                        }
        
        }

        $("#modal_last_result").change(function () {
            var limit = $(this).val();
            //var url = 'jsonp_call.php?id=' + id_sensor+ '&limit=' + limit + '&sensor=' + sensor_name;
            var type_limit ={'145':1,'289':2,'433':3,'910':7, 'm':30};
            // test new url
            url = 'http://smartme-data.unime.it/api/action/datastore_search_sql';
            DrawGraph(url,id_sensor,sensor_name,type_limit[limit]);
        });


    });

    function decimalAdjust(type, value, exp) {
        // If the exp is undefined or zero...
        if (typeof exp === 'undefined' || +exp === 0) {
            return Math[type](value);
        }
        value = +value;
        exp = +exp;
        // If the value is not a number or the exp is not an integer...
        if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
            return NaN;
        }
        // Shift
        value = value.toString().split('e');
        value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
        // Shift back
        value = value.toString().split('e');
        return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
    }

    // Decimal round
    if (!Math.round10) {
        Math.round10 = function (value, exp) {
            return decimalAdjust('round', value, exp);
        };
    }
    // Decimal floor
    if (!Math.floor10) {
        Math.floor10 = function (value, exp) {
            return decimalAdjust('floor', value, exp);
        };
    }
    // Decimal ceil
    if (!Math.ceil10) {
        Math.ceil10 = function (value, exp) {
            return decimalAdjust('ceil', value, exp);
        };
    }
    Number.prototype.toFixedDown = function(digits) {
    var re = new RegExp("(\\d+\\.\\d{" + digits + "})(\\d)"),
        m = this.toString().match(re);
    return m ? parseFloat(m[1]) : this.valueOf();
    };


</script>


</body>
</html>
