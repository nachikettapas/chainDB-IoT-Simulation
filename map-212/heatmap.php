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
<body class="hold-transition skin-blue layout-top-nav">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- = Includo Header e Menu========================= -->
    <?php
    require 'header.php';
    //require 'sidebar.php'
    ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <h1>
                #SmartME
                <small>it all starts here</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
        </div>
        <!-- Main content -->
        <div class="content">
            <div class="row">
                <div class="col-md-8">
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="row">
                                	<div class="text-center">
                                		<img src="img/logo_smartme.png" width="80%" alt="Logo #SmartME">
                                    </div>
                                    <h3 class="profile-username text-center">#SmartME</h3>
                                    <p class="text-muted text-center">Innovatively making the city of Messina "smart".</p>
                            	</div>
                            	<div class="row">
                            		<div class="text-center">
                                		<a href="http://cloudwave-fp7.eu/" target="blank">
                                			<img src="img/logo_cloudwave.png" width="60%" alt="Logo CloudWave FP7 project">
                                    	</a>
                                    </div>
                            	</div>
                            </div>
                            
                            <div class="col-md-6">
                                <h3 class="box-title">The Project</h3>

                                <p>The <b>#SmartME project</b> is a crowdfunded project born from a wish of a team of
                                    researchers in the Mobile and Distributed
                                    Systems Lab (MDSLab) at the University of Messina. Its aim is to encourage a
                                    conversation with the municipality of Messina
                                    in order to spur the creation of a novel virtual ecosystem based upon the paradigm of
                                    the <b>Internet of Things (IoT)</b>.</p>

                                <p>To morph Messina into a smart city, an Open Data
                                    platform has been set up through the employment of low-cost microcontroller boards
                                    equipped with sensors and actuators
                                    and installed on buses, lamp posts, and buildings of local institutions, all over the
                                    urban area. Thanks to such
                                    infrastructure, it is now possible to collect data and information for designing
                                    advanced services for citizens.</p>

                                <div class="row">
                                    <div class="col-md-12">
                                        <dt>Legend:</dt>
                                                <dd><img src="img/red-dot.png"> #SmartME sensors</dd>
                                                <dd><img src="img/icon_pothole.png" width="30px"> #SmartME pothole</dd>
                                                <dd><img src="img/taxi_marker.png" width="30px"> #SmartME taxi </dd>
                                    </div>
                                </div>
                            </div>
                                <!-- /.box-body -->
                        </div>
                            <!-- /.box -->
                    </div>
                        <!-- /.box-body -->
                </div>
                    <!-- /.box -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Latest News</h3>
                        </div>
                        <div class="box-body">

                            <!-- Post -->
                            <div class="post">
                                <div class="user-block">
                                    <img src="img/news.png" alt="user image">
                                        <span class="username">
                                          <a href="#">June 27, 2016</a>
                                        </span>
                                        <span class="pull-right">
                                            <a href="news.php" class="btn btn-primary btn-xs">Read more</a>
                                        </span>
                                    <span class="description"> Deployment</span>
                                </div>
                                <!-- /.user-block -->
                                <p><b>First application demo of #SmartME.</b></p>

                            </div>
                            <!-- /.post -->

                            <!-- Post -->
                            <div class="post">
                                <div class="user-block">
                                    <img src="img/news.png" alt="user image">
                                        <span class="username">
                                          <a href="#">March 17, 2016</a>
                                        </span>
                                        <span class="pull-right">
                                            <a href="news.php" class="btn btn-primary btn-xs">Read more</a>
                                        </span>
                                    <span class="description"> Deployment</span>
                                </div>
                                <!-- /.user-block -->
                                <p><b>Deployment and installation of the first seven sensor boards in the city
                                        center.</b></p>

                            </div>
                            <!-- /.post -->

                            <!-- Post -->
                            <div class="post">
                                <div class="user-block">
                                    <img src="img/news.png" alt="user image">
                                        <span class="username">
                                          <a href="#">April 28, 2015</a>
                                        </span>
                                        <span class="pull-right">
                                            <a href="news.php" class="btn btn-primary btn-xs">Read more</a>
                                        </span>
                                    <span class="description"> Deployment</span>
                                </div>
                                <!-- /.user-block -->
                                <p><b>First working meeting.</b></p>

                            </div>
                            <!-- /.post -->
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                </div>
                <!-- /.box -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">The Map</h3>
                            <div class="pull-right">
                                    <b>
                                        <a href="/index.php#mapdiv">
                                            <i class="fa fa-map-o"></i> back to the map</a>
                                    </b>
                            </div>
                        </div>
                        <div class="box-body">
                                <div id="mapdiv" style="height: 640px"></div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                <!--<div class="col-md-9">
                    <div class="box box-primary collapsed-box ">
                        <div class="box-header with-border">
                            <h3 class="box-title">Summary board</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-condensed">
                                <tr>
                                    <th>Board Name</th>
                                    <th>Longitudine</th>
                                    <th>Latitude</th>
                                    <th>Altitude</th>
                                    <th>Status</th>
                                </tr>
                                <?php
                                    $dataset=call_api('http://212.189.207.206:8888/list');
                                    foreach ($dataset->list as $board) {
                                ?>
                                <tr>
                                    <td><?=$board->label?></td>
                                    <td><?=$board->longitude?></td>
                                    <td><?=$board->latitude?></td>
                                    <td><?=$board->altitude?></td>
                                    <?php
                                        if ($board->status=='C') { ?>
                                            <td><span class="label label-success"><i span class="fa fa-check"></i> CONNESSA</span></td>
                                    <?php } else { ?>
                                            <td><span class="label label-danger"><i span class="fa fa-close"></i> DISCONESSA</span></td>
                                    <?php }
                                    }?>
                                </tr>
                            </table>
                        </div>
                        <!-- box-body -->
                    </div>
                    <!-- /.box -->
            <!-- /.row -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
     </div>
    <?php include 'footer.php' ?>
</div>
<!-- ./wrapper -->

<script type="text/javascript" src="assets/dist/js/jquery-2.2.1.min.js"></script>

<!--
    <script type="text/javascript" src="assets/dist/js/d3.min.js"></script>
    <script type="text/javascript" src="assets/dist/js/crossfilter.min.js"></script>
    <script type="text/javascript" src="assets/dist/js/dc.min.js"></script>

!-->

<!-- Bootstrap 3.3.5 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/leaflet.js"></script>
<script type="text/javascript" src="js/leaflet.markercluster.js"></script>
<!--    heatmap.js plugin -->
<script src="js/heatmap.js"></script>
<script src="js/leaflet-heatmap.js"></script>
<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- leaflet.fullscreen plugin -->
<link rel="stylesheet" href="js/Control.FullScreen.css" />
<script src="js/Control.FullScreen.js"></script>

<!-- Leaflet.Control.Custom -->
<script src="js/Leaflet.Control.Custom.js"></script>

<!-- SlimScroll -->
<script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="assets/plugins/fastclick/fastclick.min.js"></script>

<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>
<script src="assets/highstock.js"></script>
<script src="assets/jsonpath.js"></script>

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

<script>

    $(document).ready(function () {
        var notWorkingBoards = ["",  "sme-00-0006 - Policlinico Universitario", "sme-00-0016 - Villa Pace"];
        // Creating a FeatureGroup for markers
        var markersLayer = new L.FeatureGroup();
        // Funzioni di supporto
        // inserimento dei mark dall'elenco delle BOARDS.
        function GetSensoriConDati() {
            var jcall = JsonpCall(package_url, "", 1000, "GetCKAN");
            var res = [];
            var extras = [];

            var board_spente = notWorkingBoards;

            jcall.done(function (data) {
                $.each(data.result, function (k, v) {
                    extras = v.extras;
                    var lat;
                    var long;


		    //CARMELO START
                    //Bisogna evitare --> "organization":null,
                    if(v.organization != null) {
                    //CARMELO STOP
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
		   //CARMELO START
		   }
		   //CARMELO STOP
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

        function GetTaxi() {
            var jcall = JsonpCall(package_url, "", 12, "GetCKAN");
            //var extras = [];

            var packs=[];

            jcall.done(function (data) {
                $.each(data.result, function (k, v) {
                    extras = v.extras;
                    var lat;
                    var long;

		    //CARMELO START
		    //Bisogna evitare --> "organization":null,
		    if(v.organization != null) {
		    //CARMELO STOP
                      if (v.num_resources > 0 && v.organization.title === "TEST") {
                       // console.log(v.organization.title);
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

                        var position = JSON.parse(JsonpCall("jsonp_call.php?sensor=" + packs[k]['resources'][1].name + "&id=" +packs[k]['resources'][1].id, packs[k]['resources'][1].name, 1,"GetCKAN").responseText);

                        var record = position[0];
                        if(record){
                                   packs[k]['date'] = record.date;
                                   packs[k]['lat'] = record.Latitude;
                                   packs[k]['long'] = record.Longitude;
                                   packs[k]['value'] = record.value;
                        }
		      //CARMELO START
		      }
		      //CARMELO STOP
                    }
                });

            }).then(function () {
                for (var i = 0; i < packs.length; i++) {
                    var pack = packs[i];
                    try {
                        if (pack.lat) {
                            var lat = pack.lat;
                            var long = pack.long;
                            var elenco_sensori = "";
                            var board = "";
                            var sensori = pack.resources;

                            var taxi_icon = L.icon({
                                iconUrl: "img/taxi_marker.png",
                                iconSize: [26,32]
                            });

                            for (var j = 0; j < sensori.length; j++) {
                                if (sensori[j].name != "sensors") {
                                    var sensor_url = (sensori[j].name == "gas") ? "" : 'pack_name=' + pack.name + '&id=' + sensori[j].id + '&limit=<?=$limit?>&sensor=' + sensori[j].name;
                                    var padding = (sensori[j].name == "gas") ? " Coming Soon" : "";
                                    var color = "bg-navy";
                                    var icon = "fa fa-bars";

                                    if (icons[sensori[j].name].color){
                                        color = icons[sensori[j].name].color;
                                        icon = icons[sensori[j].name].icon;
                                    } else {
                                        console.log(j);
                                    }

                                    elenco_sensori += '<a class="list-group-item call_modal ' + color +
                                        ' bold" style="color:white" sensor-name="' + sensori[j].name +
                                        '" id="' + sensori[j].id + '" pack_name="' + pack.name +
                                        '" url="' + sensor_url + '" href="#sensor_modal">' +
                                        '<i class="' + icon + '"></i> '
                                        + icons[sensori[j].name].name
                                        + ' <span class="label text-maroon" style="background-color: white">'
                                        + padding + "</span></a>\n";
                                } else {
                                    board = '&nbsp;<a class="btn btn-success btn-sm pull-right track-modal" ' +
                                        'pack_name="' + pack.name + '" ' +
                                        //    'data-toggle="modal" ' +
                                        //    'data-target="#track_modal"' +
                                        'res_id="' + sensori[j].id + '" ' +
                                        'limit="' + <?=$limit?> + '">' +
                                        '<i style="color: white" class="fa fa-location-arrow"></i></a>' + "<br><br>\n";
                                }
                            }

                            var popup = L.popup({maxWidth: 700, minWidth: 200})
                                .setContent(
                                '<div class="punto" id="' + pack.id + '" ' +
                                'pack="' + pack.id + '" ><b>' + pack.name + '</b>' + board +
                                '<br>\n' +
                                '<span class="sample_date text-light-blue">&nbsp;</span>' +
                                '<div class="list-group text-left">' + elenco_sensori + '</div></div>');

                            var marker = L.marker([lat, long], {title: pack.label, icon: taxi_icon }).bindPopup(popup);

                            taxi.addLayer(marker);
                            map.addLayer(taxi);
                        }
                    } catch (err) {
                        console.log(err);
                    }
                }
            });
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


        var sensors = L.markerClusterGroup({});
        var potholes = L.markerClusterGroup({});
        var taxi = L.markerClusterGroup({disableClusteringAtZoom: 9});
        var polyline;
        var point_layer = L.layerGroup();

        var packages = [];
        var sensori = [];
        var ckan_organization = "SmartMe";
        var ckanOrganization= ckan_organization;
        var limit = <?=$limit?>;

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

        // elenco dei packages si trova alla seguente URL:
        var package_url = "http://smartme-data.unime.it/api/3/action/current_package_list_with_resources";
        var datasetsList_url = package_url;
        // esecuzione prima chiamata per la generazione dell'elenco dei sensori
        //GetSensoriConDati();
        //PotHolesLoad();

        //GetTaxi();

/*
        setInterval(function(){
            taxi.clearLayers();
            GetTaxi();
        }, 3000);
*/
        // Datasets list
        var datasets = [];

        var sens_ls = [ "temperature", "brightness", "humidity", "pressure", "gas", "noise" ];

        var requiredData = sens_ls[0];   // Data to retrieve: default is temperature
        var retrieveAll = false;   // 'true': to retrieve all the 'requiredData' samples
                                   // from the database


        //   === Global variables: 'time machine' configuration ===
        var timeMachine;   // Refers to the 'time machine' instance.
        var dataProcSel = "hourly";   // "hourly": collected data is processed to be visualized
                                      // on an hourly base.


        // The hourly time machine configuration.. each 'dataframe' is equally spaced
        // from the frame before ( see: ticksInterval field ).

        var hourlyConfig = {
            ticksInterval: 120,     // expressed in minutes
            from_thisDate: '',
            to_thisDate: '',

            init: function() {
                this.from_thisDate = new Date();
                this.to_thisDate = dateSub( this.from_thisDate, 24*60 );   // default configuration: 'time machine' goes back in time
            },

            heatmapDataPoints: []

            // heatmapDataPoints ( two-dimensional array ); stores the processed data.
            // Each element of the array ( that is also an array ) is related to a
            // different 'dataframe' ( therefore, a different heatmap ).
        };

        hourlyConfig.init();


        //   === Map creation and heatmap ===

        // The default map shows samples between: 'current date - sampleFilter' and
        // 'current date + sampleFilter'.
        var sampleFilter = 120;   // expressed in minutes
        // Configuring the heatmap layer
        var config = {

            // try also: scaleRadius false, radius: 40

            "radius": 0.01,   // Should be small only if scaleRadius is true (or small radius is intended);
                              // if scaleRadius is false it will be the constant radius used in pixels

            "maxOpacity": .9,
            "scaleRadius": true,   // Scales the radius based on map zoom

            // false: the heatmap uses the global maximum for colorization
            // true: uses the data maximum within the current map boundaries
            // ( there will always be a red spot with useLocalExtremas true )
            "useLocalExtrema": false,

            gradient: {

                '.25': 'rgb(0,0,255)',   // blue
                '.55': 'rgb(0,255,0)',   // green
                '.85': 'yellow',
                '1': 'rgb(255,0,0)'      // red
            },

            // blur: 0.3,       Blur factor that will be applied to all datapoints.
            //                  The higher the blur factor is, the smoother the gradients will be

            latField: 'lat',   // which field name represents the latitude - default "lat
            lngField: 'lng',   // which field name represents the longitude - default "lng
            valueField: 'count'   // which field name represents the data value - default "value"
        };

        // Creating a layer for the heatmap
        var heatmapLayer = new HeatmapOverlay( config );


        var overlayMaps = {
            //"SmartME Potholes": potholes,
            //"SmartME Sensors" : sensors,
            //"SmartME Taxi" : taxi,
             "Heatmap" : heatmapLayer
        };
        var map = L.map('mapdiv', {
            center: [38.20523, 15.55972],
            zoom: 12,
            layers: [roads, heatmapLayer]
        });
        //var lcontrol = L.control.layers("",overlayMaps).addTo(map);
      //L.control.layers(overlayMaps).addTo(map);

        // Maximum 'requiredData' value
        // ( used as a reference value to render the heatmap )

        var maxRefValue = 30;     // temperature heatmap: try 30 ( maxRefValue ) and 0 ( minRefValue ).
        var minRefValue = 0;

// HEATMAP

        //   === Getting the resources ===

        function getResourcesHMList() {
            var extras = [];

            var jsonp2Call = $.ajax( {

                // Configuring the Ajax
                // request

                url: datasetsList_url,
                dataType: 'jsonp',
                async: false,    // Performing a synchronous request ( read note )..

                // Note - however, cross-domain requests and dataType: "jsonp" requests
                // do not support synchronous operation.

                cache: true,
                data: { "limit": 1000 },   // Note: a limit of 100 is not enough!

            })
                .done( function ( data ) {

                $.each( data.result, function ( index, value ) {

                    // console.log( "DEBUG | 1 | jcall.done > ", value );
                    extras = value.extras;

                    var lat;
                    var long;

		    //CARMELO START
		    //Bisogna evitare --> "organization":null,
		    if(value.organization != null) {
		    //CARMELO STOP
                      if ( value.num_resources > 0 && value.organization.title == ckanOrganization && ( notWorkingBoards.indexOf( value.notes ) < 0 ) ) {

                        datasets[index] = {

                            id: value.id,
                            label: "",
                            name: value.name,
                            lat: "",
                            long: "",
                            resources: [],
                        };

                        $.each( value.resources,  function( ind, val ) {
                            if ( val.name ) {
                                datasets[index]['resources'].push( { name: val.name, id: val.id } );
                            }
                        });

                        if ( extras.length ) {
                            for ( var i = 0; i < extras.length; i++ ) {
                                var record = extras[ i ];
                                switch ( record.key ) {
                                    case "Label":   datasets[index]['label'] = record.value;
                                        break
                                    case "Latitude":   datasets[index]['lat'] = record.value;
                                        break;
                                    case "Longitude":   datasets[index]['long'] = record.value;
                                        break;
                                }   // switch
                            }   // for
                        }   // if
                      }   // external if
		    //CARMELO START
		    }
		    //CARMELO STOP
                });   // external $.each

                // console.log("DEBUG | 2 | jsonpCall executed!");

            })
                .fail( function() {
                console.log( "Error | request to the database failed!" );

            })   // jsonpCall.fail
                .always( function() {
                buildDefaultHeatmap();
            })
                .then( function() {
                // 'startIt': the callback called when pressing the submit button
                // 'buildDefaultHeatmap': the callback called when an option is selected from the dropdown
                var cfgBox = new L.control.configBox( startIt, buildDefaultHeatmap, { "position": 'topright'});
                cfgBox.addTo(map);

            });   // jsonpCall.then

        }   // function getResourcesList


        // Builds the default heatmap with the last-recorded
        // 'requiredData' samples ( default is temperature ).
        function buildDefaultHeatmap() {

            var dataset;
            var retrievedData;
            var resourceId;

            for ( var i = 0; i < datasets.length; i++ ) {
                // console.log("DEBUG | 3 | buildDefaultHeatmap(), datasets", datasets[i]);
                if ( datasets[i] ) {
                    try {
                        dataset = datasets[i];
                        resourceId = getId( dataset.resources, requiredData );

			//CARMELO START
			if(resourceId && resourceId != undefined){
			//CARMELO STOP

                          retrievedData = $.ajax( {
                            url: 'http://smartme-data.unime.it/api/action/datastore_search',
                            async: false,
                            cache: true,
                            dataType: 'jsonp',
                            data: { resource_id: resourceId, limit: 1, sort: "Date desc" }
                          });   // $.ajax

                          retrievedData.done( function ( data ) {
                            if ( data.result.records[0] && toDate( data.result.records[0].Date ) ) {

                                // Preparing the filter for inactive sensors..
                                var sampleDate = toDate( data.result.records[0].Date );
                                var currentDate = new Date();
                                var printOrNot = isBetween( sampleDate, calcMin( currentDate, sampleFilter ), calcMax( currentDate, sampleFilter ) );

                                var textIcon;
                                var marker;

                                var lat = data.result.records[0].Latitude;
                                var long = data.result.records[0].Longitude;
                                var value = parseInt( data.result.records[0][capitalizeFirstLetter(requiredData)] );

                                // A lightweight icon for markers that uses a simple <div> element
                                // instead of an image.
                                textIcon = L.divIcon( {

                                    className: "labelClass",
                                    html: value
                                });

                                // Inactive sensors are 'n/a'
                                if( !printOrNot ) textIcon.options.html = 'n/a';

                                marker = L.marker( [ lat, long ], {
                                    title: requiredData,
                                    icon: textIcon
                                });

                                markersLayer.addLayer( marker);
                                // Building the heatmap only for coherent data ( old samples will not be
                                // displayed )..
                                if ( printOrNot ) heatmapLayer.addData({ lat: lat, lng: long, count: value });
                            }   // if
                          });   // retrievedData.done
  		        //CARMELO START
		        }
		        //CARMELO STOP
                    }   // try
                    catch ( err ) {
                        console.log( "- Error reading data -", err.message);
                    }
                }   // if
            }   // for
        }   // function buildDefaultHeatmap


        // Data retrieval ( wrapper )
        function DataRetrieval( options ) {

            var retrAll = options.downloadAll;

            this.init = function() {

                deferreds = [];
                fullData = [];
            };

            this.retrieve = function() {

                this.init();
                this.getData_sql();
            };

            this.getData_sql = function() {

                var resUrl = 'http://smartme-data.unime.it/api/action/datastore_search_sql';
                var resourceId;
                var dataAjxQuery;

                for ( var i = 0; i < datasets.length; i++ ) {

                    if ( datasets[i] ) {

                        var obj = {};

                        obj.label = datasets[i].label;
                        obj.lat = datasets[i].lat;
                        obj.lng = datasets[i].long;
                        obj.id = datasets[i].id;
                        obj.res = datasets[i].resources;
                        obj[requiredData] = [];

                        fullData.push( obj );

                    }   // if

                }   // for loop

                $.each ( fullData, function ( ind , val  ) {

                    try {

                        if ( val ) {

                            resourceId = getId( val.res, requiredData );
			    //CARMELO START
			    if(resourceId && resourceId != undefined){
			    //CARMELO STOP
                              dataAjxQuery = $.ajax({   // performs an sql query

                                url: resUrl,
                                async: false,
                                cache: true,
                                dataType: 'jsonp',
                                indx: ind,
                                data: { "sql": prepareSqlStatement( resourceId, retrAll ) },

                              });   // $.ajax

                              dataAjxQuery.done( function ( data ) {

                                var index = this.indx;
                                fullData[index][requiredData] = data.result.records;
                              });
			    //CARMELO START
			    }
			    //CARMELO STOP
                        }   // if
                    }   // try

                    catch( err ) {
                        console.log( "- Error reading data -", err.message);
                    }   // catch

                    deferreds.push ( dataAjxQuery );

                });   //$.each

            };   // this.getData()

        }    // function DataRetrieval


        // Returns: the SQL SELECT Statement to retrieve data from the database
        // ( see 'this.getData_sql' )
        function prepareSqlStatement ( resId, download ) {

            var sqlStatement = '';
            var retrieveAllData = download;

            sqlStatement += 'SELECT';
            sqlStatement += ' ';
            sqlStatement += '"'+capitalizeFirstLetter( requiredData )+'"';
            sqlStatement += ', "Date" ';
            sqlStatement += 'from ' +'"'+resId+'" ';

            if ( !retrieveAllData ) {

                sqlStatement += 'WHERE "Date" BETWEEN '+'\''+hourlyConfig.to_thisDate.toISOString()+'\' '+ 'AND ' +'\''+hourlyConfig.from_thisDate.toISOString()+'\' ';
            }

            sqlStatement += 'ORDER BY "Date" DESC';

            return sqlStatement;

            // It returns something like this!
            // SELECT "Temperature", "Date" from "8e943f1c-75c6-4c94-a3b3-d508a549ebbc" WHERE "Date" BETWEEN '2017-02-06T09:57:00.000Z' AND '2017-02-07T09:57:00.000Z' ORDER BY "Date" DESC
        }


// === Time machine code is here! ===

        function dataProcessingSel() {

            switch ( dataProcSel ) {

                case "hourly": hourlyTimeMachineData();
                    break;
            }
        }

// - Time machine wrapper -

        function TimeMachine( options ) {

            this.data = options.data;
            this.ref_max = options.heatmapRefValue_max;
            this.ref_min = options.heatmapRefValue_min;
            this.cfg = options.heatmapCfg;
            this.rev = options.reverse;   // note: if reverse is true, the extreme right of
                                          // the slider shows the most recent samples. Warning:
                                          // this feature is achieved reversing the 'data' array
                                          // ( not its copy - just keep in mind to avoid unexpected
                                          // results! )

            this.position = options.sliderPosition;  // the position of the slider
                                                     // ( possible values: 'topleft', 'topright', 'bottomleft' or 'bottomright' )

            this.markersL = new L.FeatureGroup();
            this.heatmapL = new HeatmapOverlay(this.cfg);
            this.markersL.addTo(map);
            this.heatmapL.addTo(map);

            this.remove = function() {

                this._slider.remove();
                this.markersL.remove();
                this.heatmapL.remove();
            };

            // Prints the correct date ( the one
            // corresponding to the input )
            this._getString = function ( val ) {

                return this.data[val].label;
            }.bind(this);

            this._timeTravel = function ( val ) {

                var marker;
                var text = L.divIcon( { "className": "labelClass", "html": "" });
                var datap = this.data[val];
                var data = { "max": this.ref_max, "min": this.ref_min, "data": [] };

                this.markersL.clearLayers();

                for ( var i = 0; i < datap.length; i++ ) {

                    if ( datap[i].count ) {

                        text.options.html = datap[i].count;
                        data.data.push(datap[i]);
                    }

                    else {

                        if ( !datap[i].count ) text.options.html = 'n.a.';
                    }

                    marker = L.marker( [ datap[i].lat, datap[i].lng ], { icon: text });
                    this.markersL.addLayer( marker );
                }

                this.heatmapL.setData( data );  // setData removes all previously existing points
                                                // from the heatmap instance and re-initializes the datastore

            }.bind(this);


            this.init = function () {

                var sliderCfg = {   // slider configuration

                    "width": '300px',
                    "position": this.position,   // 'topleft', 'topright', 'bottomleft' or 'bottomright'
                    "min": 0,
                    "max": this.data.length - 1,
                    "value": 0,
                    "title": 'time machine slider',
                    "getString": this._getString,
                    "increment": true,   // true: increment and decrement buttons next to the slider
                    "showValue": true,   // true: show the input value next to the slider
                    "showStringValue": true   // true: show a string next to the slider, provided by the 'getString' method
                };

                if ( this.rev ) {

                    this.data.reverse();
                    sliderCfg.value = sliderCfg.max;
                }

                this._slider =  new L.control.slider( this._timeTravel, sliderCfg );
                this._slider.addTo( map );
            };

            this.init();

        }   // timeMachine


// Starts the time machine!
        function startIt() {

            var status = document.querySelector('#status');
            var subBtn = document.querySelector('#submitButton');
            var senSel = document.querySelector('#senselec');

            if( timeMachine ) {   // Removing ( if any ) the existing time machine instance

                timeMachine.remove();
            }

            // Prevent user to perform any actions while
            // downloading data
            subBtn.disabled = true;
            senSel.disabled = true;

            status.innerHTML = 'Status: downloading data';

            var data = new DataRetrieval( { "downloadAll": retrieveAll } );   // obtaining data from the database
            data.retrieve();

            $.when.apply($, deferreds).then(function() {   // waiting on multiple asynchronous calls to complete..

                // console.log("DEBUG | 4 | fullData ", fullData )

                subBtn.disabled = false;   // submit button is now enabled
                senSel.disabled = false;
                status.innerHTML = 'Status: -';

                dataProcessingSel();   // processing data

                // Clearing the map!
                markersLayer.remove();
                heatmapLayer.remove();

                // Creating a new time machine
                timeMachine = new TimeMachine( {

                    "data": hourlyConfig.heatmapDataPoints,
                    "heatmapCfg": config,
                    "heatmapRefValue_max": maxRefValue,
                    "heatmapRefValue_min": minRefValue,
                    "sliderPosition": 'bottomleft',
                    "reverse": true,     // note: if reverse is true, the extreme right of
                                         // the slider shows the most recent samples. Warning:
                                         // this feature is achieved reversing the 'data' array
                                         // ( not its copy - just keep in mind to avoid unexpected
                                         // results! )
                });

            });   // $.when.apply

        }   // startIt function


// Processing data on an hourly base.
        function hourlyTimeMachineData() {

            var date = hourlyConfig.from_thisDate;
            var ref = date;    // reference date
            var interval = hourlyConfig.ticksInterval;   // interval between 'dataframes' ( expressed in minutes )
            var until = hourlyConfig.to_thisDate;

            hourlyConfig.heatmapDataPoints = [];

            var ind = 0;

            var cfg = {

                "ind": new Array( fullData.length ),
                "min": "",
                "max": "",
                "ref": ""
            };

            cfg.ind.fill(0);

            // if 'true', samples are proccessed until the oldest one
            if ( retrieveAll ) {

                until = lessRecDate( fullData );
            }

            while( date >= until ) {   // Beginning from the most recent date..

                var dataForPeriod = [];

                cfg.min = calcMin( date, interval/2 );
                cfg.max = calcMax( date, interval/2 );
                cfg.ref = date;

                for ( var i = 0; i < fullData.length; i++ ) {

                    var obj = {};
                    var el = searchValid( fullData[i][ requiredData ], i, cfg );

                    obj.lat = fullData[i].lat;
                    obj.lng = fullData[i].lng;

                    if ( el ) obj.count = parseInt( el[capitalizeFirstLetter(requiredData )] );
                    else obj.count = el;

                    dataForPeriod.push( obj );

                }   // external for

                hourlyConfig.heatmapDataPoints[ind] = dataForPeriod;
                hourlyConfig.heatmapDataPoints[ind].label = date.toLocaleString();

                date = dateSub( date, interval );

                ind++;

            }   // external while
        }


        function searchValid( arr, id, cfg ) {

            var starts = cfg.ind[id];
            var min = cfg.min;
            var max = cfg.max;
            var ref = cfg.ref;

            var acceptable = [];
            var ends = arr.length;

            // DEBUG: if arr is empty, loop not
            // executed. It returns undefined.
            for ( var i = starts; i < ends; i++ ) {

                var date = toDate( arr[i].Date );

                if ( isBetween( date, min, max ) ) {

                    acceptable.push( arr[i] );
                    continue;
                }

                if ( isBefore( date, min ) ) {

                    break;
                }

            }   // for

            cfg.ind[id] = i;

            if ( acceptable.length > 0 ) return closestDateTo( acceptable, ref );
        }


// Returns: undefined if arr is
// empty ( else: an object ).
        function closestDateTo( arr, ref ) {

            var i = 0;
            var el;
            var minDiff;

            if ( arr ) {

                minDiff = Math.abs( toDate( arr[0].Date ) - ref );
                el = arr[0];
            }

            for( i in arr ) {

                var date = toDate( arr[i].Date );
                var diff = Math.abs( date - ref );

                if ( diff < minDiff ) {

                    minDiff = diff;
                    el = arr[i];
                }

            }

            return el;
        }


// Gets the date of the oldest ( 'requiredData' ) sample;
// note: it needs to work that data is sorted in descending order ( it means
// it is ordered from the most recent sample to the oldest one )
        function lessRecDate ( arr ) {

            var olDate = new Date();
            var date;
            var arrLen;

            for ( var i = 0; i < arr.length; i++ ) {

                arrLen = arr[i][requiredData].length;

                if ( arr[i][requiredData][arrLen-1] ) date = toDate( arr[i][requiredData][arrLen-1].Date );

                if ( date < olDate ) olDate = date;
            }

            return olDate;
        }


//   === Custom controls ===

// Slider
        L.Control.Slider = L.Control.extend({

            update: function( value ) {   // The callback function receives the slider
                // value ( input by the human user )
                return value;
            },

            options: {
                width: '300px',
                position: 'bottomleft',
                min: 0,
                max: 11,
                id: "slider",
                value: 0,     // input by the human user
                title: 'Leaflet Horizontal Slider',
                increment: true,

                getValue: function( value ) {

                    return value;
                },

                getString: function( value ) {

                    return '-';
                },

                showValue: true,
                showStringValue: true
            },

            initialize: function( f, options ) {

                L.setOptions( this, options );

                if ( typeof f == "function" ) {

                    this.update = f;
                } else {

                    this.update = function( value ) {
                        console.log( value );
                    };
                }

                if ( typeof this.options.getValue != "function" ) {

                    this.options.getValue = function( value ) {
                        return value;
                    };
                }

                if ( typeof this.options.getString != "function" ) {

                    this.options.getString = function( value ) {
                        return '-';
                    };
                }
            },   // initialize

            onAdd: function(map) {

                this._initLayout();
                this.update(this.options.value + "");
                return this._container;
            },

            // Clean up code
            onRemove: function( map) {

                // console.log("DEBUG | On remove | Slider");
                this._minus.remove();
                this.slider.remove();
                this._sliderContainer.remove();
                this._plus.remove();
                this._sliderValue.remove();
                this._container.remove();
            },

            _updateValue: function() {

                this.value = this.slider.value;

                if (this.options.showValue && !this.options.showStringValue) {

                    this._sliderValue.innerHTML = this.options.getValue(this.value);
                    this._sliderValue.style.width = '35px';
                }

                if (this.options.showValue && this.options.showStringValue) {

                    this._sliderValue.innerHTML = this.options.getString(this.value);
                }

                this.update(this.value);
            },

            // layout and listeners
            _initLayout: function() {

                var className = 'leaflet-control-slider';

                this._container = L.DomUtil.create('div', className );

                if (this.options.showValue) {   // showValue is true..

                    this._sliderValue = L.DomUtil.create('p', className + '-value', this._container); // Debug: leaflet-control-slider-value

                    if ( !this.options.showStringValue ) {

                        this._sliderValue.innerHTML = this.options.getValue(this.options.value);
                        this._sliderValue.style.width = '35px';
                    }

                    else {

                        this._sliderValue.innerHTML = this.options.getString(this.options.value);
                    }
                }

                if ( this.options.increment ) {

                    this._plus = L.DomUtil.create('a', className + '-plus', this._container);  // leaflet-control-slider-plus
                    this._plus.innerHTML = "+";

                    L.DomEvent.on(this._plus, 'click', this._increment, this);
                    L.DomUtil.addClass(this._container, 'leaflet-control-slider-incdec');
                }

                this._sliderContainer = L.DomUtil.create('div', 'leaflet-slider-container', this._container);
                this.slider = L.DomUtil.create('input', 'leaflet-slider', this._sliderContainer);

                this.slider.title = this.options.title;
                this.slider.id = this.options.id;
                this.slider.type = "range";
                this.slider.min = this.options.min;
                this.slider.max = this.options.max;
                this.slider.step = 1;
                this.slider.value = this.options.value;

                L.DomEvent.on(this.slider, "input", function(e) {
                    this._updateValue();
                }, this);

                if ( this.options.increment ) {

                    this._minus = L.DomUtil.create('a', className + '-minus', this._container);  // Debug: leaflet-control-slider-minus
                    this._minus.innerHTML = "-";
                    L.DomEvent.on(this._minus, 'click', this._decrement, this);
                }

                if ( this.options.showValue ) {
                    this._sliderContainer.style.width = ( this.options.width.replace('px', '') - 0 ) + 'px';
                } else {
                    this._sliderContainer.style.width = (this.options.width.replace('px', '') - 0) + 'px';
                }

                L.DomEvent.disableClickPropagation( this._container );

            },   // _initLayout

            _increment: function() {

                this.slider.value = this.slider.value * 1 + 1;
                this._updateValue();
            },

            _decrement: function() {

                this.slider.value = this.slider.value * 1 - 1;
                this._updateValue();
            }
        });

        L.control.slider = function(f, options) {
            return new L.Control.Slider(f, options);
        };


// Configuration panel
        L.Control.ConfigBox = L.Control.extend({

            callback: function() {

                console.log("Callback function not set");
            },

            onChangeCallback: function() {

                console.log("Callback function ( dropdown 'onchange' event ) not set");
            },

            options: {

                position: 'topright'
            },

            initialize: function( machine_func, onChange_func, options ) {

                L.setOptions( this, options );

                if ( typeof machine_func === "function" ) {
                    this.callback = machine_func;
                }

                if ( typeof onChange_func === "function") {
                    this.onChangeCallback = onChange_func;
                }
            },

            onAdd: function (map) {

                this._initLayout();
                return this._container;
            },
            /*
             disableSubmit: function() {

             document.getElementById("submitButton").disabled = true;
             },*/

            _validateGradBound: function ( input ) {   // Basic input validation

                var isValid = true;

                var reg = new RegExp("[0-9]+, *[0-9]+");

                // note: trim() removes whitespace from both sides of a string
                var bound = input.trim().split(",");

                var lBound = parseInt( bound[0] );
                var uBound = parseInt( bound[1] );

                if ( !reg.test( input ) ) return false;

                // note: isNaN() determines whether a value is an illegal number (Not-a-Number)
                isValid = ( lBound!=="" && lBound!==" " && !isNaN( lBound ) ) && ( uBound!=="" && uBound!==" " && !isNaN( uBound ) );

                return isValid;
            },

            _validateDate: function ( rDate, pDate ) {

                var reg = new RegExp("[0-9]?[0-9]/[0-9]?[0-9]/[0-9]{4}, *[0-9]?[0-9]:[0-9]{2}");

                var rDateObj = stringToDate( rDate );
                var pDateObj = stringToDate( pDate );

                var current = new Date();

                return isAfter( rDateObj, pDateObj ) && reg.test( rDate ) && reg.test( pDate ) && isAfter( current, rDateObj );
            },

            _buildLastSampleHeatmap: function ( event ) {

                if ( event.target.id === 'senselec' ) {

                    // Clearing the map!
                    heatmapLayer.remove();
                    markersLayer.clearLayers();

                    heatmapLayer = new HeatmapOverlay( config );

                    if ( !map.hasLayer( heatmapLayer ) ) heatmapLayer.addTo( map );
                    if ( !map.hasLayer( markersLayer ) ) markersLayer.addTo( map );

                    if ( timeMachine ) {
                        timeMachine.remove();
                    }

                    requiredData = event.target.value;

                    buildDefaultHeatmap();
                }
            },

            _onClick: function ( event ) {

                var dateSelFrom = document.querySelector('#showfrom');
                var dateSelTo = document.querySelector('#showto');
                var sens = document.querySelector('#senselec');
                var gradBound = document.querySelector('#bound');
                var datafrInterv = document.querySelector('#datafinterv');
                var status = document.querySelector('#status');

                // Handling checkbox event
                if(event.target.id ==='cbdownloadall') {

                    if ( retrieveAll ) {

                        retrieveAll = false;
                        dateSelTo.disabled = false;
                        dateSelFrom.disabled = false;
                    }

                    else {

                        retrieveAll = true;
                        dateSelFrom.disabled = true;
                        dateSelTo.disabled = true;
                    }
                }

                if ( event.target.id === 'submitButton' ) {

                    var isValid = true;

                    if ( !this._validateDate( dateSelFrom.value, dateSelTo.value ) ) isValid = false;

                    if ( !this._validateGradBound( gradBound.value ) ) isValid = false;

                    if ( isValid ) {

                        var uBound = gradBound.value.trim().split(",")[1];
                        var lBound = gradBound.value.trim().split(",")[0];

                        status.innerHTML = "Status: ok";
                        maxRefValue = parseInt( uBound );
                        minRefValue = parseInt( lBound );
                        hourlyConfig.ticksInterval = parseInt( datafrInterv.value );
                        requiredData = sens.value;
                        hourlyConfig.from_thisDate = stringToDate( dateSelFrom.value );
                        hourlyConfig.to_thisDate = stringToDate( dateSelTo.value );

                        this.callback();
                    }

                    else status.innerHTML = "Status: please check your input!";

                }
            },

            _dropdownOpz: function ( arr, sel ) {

                var cont = '';

                for ( var i = 0; i < arr.length; i++ ) {

                    cont += '<option ';

                    if ( arr [i] === sel ) {

                        cont += 'selected ';
                    }

                    cont+= 'value="'+arr[i]+'">'+capitalizeFirstLetter(arr[i])+'</option>';
                }

                return cont;
            },

            _initLayout: function() {

                var className = 'leaflet-control-config';   // leaflet-control-config
                var dropdownClass = '"'+className+'-dropdown'+'"';   // leaflet-control-config-dropdown
                var checkboxClass = '"'+className+'-checkbox'+'"';   // leaflet-control-config-checkbox
                var inputClass = '"'+className+'-input'+'"';   // leaflet-control-config-input
                var buttonClass = '"'+className+'-submit'+'"';   // leaflet-control-config-submit
                var statusClass = '"'+className+'-status'+'"';   // leaflet-control-config-status

                var fDate = hourlyConfig.from_thisDate;
                var eDate = hourlyConfig.to_thisDate;
                var fromDate = fDate.toLocaleString().replace(/(.*)\D\d+/, '$1');
                var toDate = eDate.toLocaleString().replace(/(.*)\D\d+/, '$1');

                var content = '<h4>Sensors Heatmap</h4>'+
                    '<select title="Select the data to visualize" class=' +dropdownClass+' '+'id="senselec" name="senselec">'+    // <select title="Select the data to visualize" class="leaflet-control-config-dropdown" id="senselec" name="senselec">
                    this._dropdownOpz( sens_ls, requiredData ) +
                    '</select>'+

                    '<input  type="checkbox" class='+checkboxClass+' '+'id="cbdownloadall">'+
                    '<label title="Check if you want to download the entire dataset for the selected sensor ( it might take a while! )" for="cbdownloadall">Download the entire dataset</label><br><br>'+

                    '<label for="bound">Lower bound / Upper bound: </label>'+
                    '<input placeholder="Please, insert a number" title="Set the lower bound / upper bound for the gradient" type="text" class='+inputClass+' '+'id="bound" name="lowerupperbound" value="'+minRefValue+', '+maxRefValue+'"'+'>'+

                    '<label for="datafinterv">\'Dataframe\' interval: </label>'+
                    '<input placeholder="Expressed in minutes" title="Set the interval between \'dataframes\' ( time machine )" type="text" class='+inputClass+' '+'id="datafinterv" name="dataframeinterval" value="'+hourlyConfig.ticksInterval+'"'+'>'+

                    '<label for="showfrom">From ( dd/mm/yyyy, --:-- ): </label>'+
                    '<input placeholder="Please, insert a valid date" title="Set the starting date" type="text" class='+inputClass+' '+'id="showfrom" name="showfromdate" value="'+fromDate+'"'+'>'+

                    '<label for="showto">To ( dd/mm/yyyy, --:-- ): </label>'+
                    '<input placeholder="Please, insert a valid date" title="Set the ending date" type="text" class='+inputClass+' '+'id="showto" name="showtodate" value="'+toDate+'"'+'>'+

                    '<p id="status" class='+statusClass+' '+'>Status: - </p>'+

                    '<input type="button" id="submitButton" class='+buttonClass+' '+'value="Submit">';


                this._container = L.DomUtil.create('div', className );
                this._container.innerHTML = content;

                L.DomEvent.on(this._container, 'change', this._buildLastSampleHeatmap, this);
                L.DomEvent.on(this._container, 'click', this._onClick, this);
                L.DomEvent.disableClickPropagation( this._container );

            }   // init function

        });

// After that options are set, the callback 'machine_func'
// is executed
        L.control.configBox = function( machine_func, onChange_func, options ) {
            return new L.Control.ConfigBox( machine_func, onChange_func, options );
        };

        getResourcesHMList();
        buildDefaultHeatmap();
// OLD
        map.on('popupopen', function (e) {
            var el = $('<div></div>');
            var link = [];
            el.html(e.target._popup._content);
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

        function DrawGraph(url){
            var dati_sensore = $.getJSON(url,
                function(data) {
                    $.each(data, function (k, v) {
                        var d = new Date(v.date);
                        v.x = Date.parse(d);
                        v.y = parseFloat(v.value);
                    });
                    return data;
                });

            dati_sensore.done(function (data){
                var chart_width = parseInt($('.modal-lg').width() -50 );
                var Chart = new Highcharts.StockChart({
                    chart: {
                        type: 'line',
                        renderTo: "hicharts",
                        height: '320',
                        width: chart_width, // (chart_width>760)?chart_width:560,
                        events: {
                            redraw: function () {
                                // addNoise(Chart, sensor_name);
                            }
                        }
                    },
                    title: {
                        text: sensor_name
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
                            text: 'unit:' + unit[sensor_name]
                        }
                    },
                    tooltip: {
                        valueDecimals: 1,
                        valueSuffix: " " + unit[sensor_name]
                    },
                    series: [{
                        name: sensor_name,
                        data: data
                    }]

                });
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
             post_data = $(this).attr('url');
             pack_name = $(this).attr('pack_name');
             unit  = <?=json_encode($unit)?>;

            $("#sensor_name").html(capitalizeFirstLetter(sensor_name));
            $("#measure_unit").html(unit[sensor_name]);
            $('#download_csv').attr('href', 'http://smartme-data.unime.it/datastore/dump/' + id_sensor);
            $('#open_data_link').attr('href', 'http://smartme-data.unime.it/dataset/' + pack_name + '/resource/' + id_sensor);


            url = 'jsonp_call.php?id=' + id_sensor+ '&limit=<?= $limit ?>&sensor=' + sensor_name;

            DrawGraph(url);

            $("#sensor_modal").modal('show');

        });

        function addNoise (Chart, sensor_name){
            // CASE NOISE add plot bands
            if (sensor_name == "noise") {
                Chart.yAxis.addPlotbands(
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
                    .series[0].update({
                        useHTML: true,
                        formatter: function () {
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
                                    ': <b>' +
                                    this.y + '</b> Amplitude ' +
                                    '<b class="text-center">' + label + '</b>';
                            });
                            return s;
                        },
                        shared: true
                    });
            }
        }

        $("#modal_last_result").change(function () {
            var limit = $(this).val();
            var url = 'jsonp_call.php?id=' + id_sensor+ '&limit=' + limit + '&sensor=' + sensor_name;
            DrawGraph(url);
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


    // Gets the resource_id corresponding
    // to the required data ( temperature,
    // brightness, humidity, etc. )
    function getId( resources, sensor ) {
        var data = resources;
        for ( var j = 0; j < data.length; j++ ) {
            if ( data[j]['name'] === sensor ) {
                return data[j]['id'];
            }
        }
    }

    function getCurrentDay() {
        return new Date().getDate();
    }

    function getCurrentHour() {
        return new Date().getHours();
    }

    function getCurrentMonth() {
        return new Date().getMonth();
    }

    function getCurrentYear() {
        return new Date().getFullYear();
    }

    // Returns true if 'date' is most recent than 'u'
    function isAfter( date, u ) {
        return date > u;
    }

    // Returns true if 'date' is less recent than 'l'
    function isBefore( date, l ) {
        return date < l;
    }

    // For DEBUG only
    function showDates( arr, string ) {
        for ( var i = 0; i < arr.length; i++ ) {
            console.log( string, toDate( arr[i].Date ).toLocaleString(), '+', parseInt(arr[i].Brightness) );
        }
    }

    // Returns true if 'date' is between 'l' and 'u'
    function isBetween( date, l, u ) {
        return date >=l && date <= u;
    }

    // Subtracts 'min' from 'date'
    // ( min is expressed in minutes)
    function dateSub( date, min ) {
        return new Date( date.getTime() - min * 60000 );
    }

    // Converts the timestamp into
    // a 'Date' object
    function toDate( timestamp ) {   // timestamp is in ISO 8601 format
        var split = timestamp.split(".");
        var ISOdate = split[0]+'Z';   // Adding UTC designator ("Z"),
                                      // to avoid conversion issues.
        return new Date( ISOdate );
    }

    // Input: gg/mm/yyyy, hh:mm ( a string )
    // Output: a new Date objet
    function stringToDate( str ) {

        var day, month, year, hr, min;

        var spl = str.split(",");
        var d_spl = spl[0].split("/");
        var h_spl = spl[1].split(":");

        day = d_spl[0];
        month = d_spl[1]-1;
        year = d_spl[2];
        hr = h_spl[0];
        min = h_spl[1];

        return new Date( year, month, day, hr, min );
    }

    // Adds 'offset' to 'rif'
    // ( 'offset' is expressed in minutes )
    function calcMax( rif, offset ) {

        return new Date( rif.getTime() + offset * 60000 );   // Note: getTime() method returns
                                                             // the number of milliseconds
                                                             // since 1970/01/01
    }

    // Subtracts 'offset' from 'rif'
    // ( 'offset' is expressed in minutes )
    function calcMin( rif, offset ) {

        return new Date( rif.getTime() - offset * 60000 );
    }



</script>


</body>
</html>
