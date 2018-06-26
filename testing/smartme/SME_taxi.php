<!DOCTYPE html>
<?php
  //include 'config.php';
  require 'function.php';
  require 'head.php';

    $url = 'http://smartme-data.unime.it/api/3/action/package_list';
    $dataset=call_api($url);
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
            <section class="content-header">
              <h1>
                #SmartME
                <small>it all starts here</small>
              </h1>
              <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"><a href="#">#SmartME Taxi</a></li>
              </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <img src="img/logo_smartme.png" width="100%" alt="User profile picture">
                                <h3 class="profile-username text-center">#SmartME</h3>
                                <p class="text-muted text-center">Innovatively making the city of Messina "smart".</p>
                                <ul class="list-group list-group-unbordered">
                                    <b><i class="fa fa-gears margin-r-5"></i>Credits</b><br/><br/>
                                    <li class="list-group-item"><img src="img/loghi/logounimecolor.png" height="70px">
                                        <span class="pull-right"><a href="http://www.unime.it" target="_blank">University of Messina</a></span></li>
                                    <li class="list-group-item"><img src="img/loghi/logo_ciam.png" height="70px">
                                        <span class="pull-right"><a href="http://www.unime.it/ciam" target="_blank">Ciam</a></span></li>
                                    <li class="list-group-item"><img src="img/loghi/Smartme.io_2.png" height="70px">
                                        <a href="http://www.smartme.io" target="_blank"><span class="pull-right">Smartme.io</a></span></li>
                                    <li class="list-group-item"><img src="img/loghi/mdslogo2_1.png" height="70px">
                                        <a href="http://mdslab.unime.it/" target="_blank"><span class="pull-right">MDSLab</a></span></li>
                                    <br/>
                                    <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                                    <p class="text-muted">Messina - Sicily, Italy</p>
                                    <hr>
                                    <strong><i class="fa fa-tag margin-r-5"></i> Skills</strong>
                                    <p>
                                        <span class="label label-danger">Open Data</span>
                                        <span class="label label-info">Smart City</span>
                                        <span class="label label-success">Arduino</span>
                                        <span class="label label-warning">Sensors</span>
                                        <span class="label label-primary">Internet of Things (IoT)</span>
                                    </p>
                                    <hr>
                                </ul>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->

                    <!-- Default box -->
                    <div class="col-md-9">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">#SmartME Taxi</h3>
                                <p class="text-left"><img src="img/SmartME_taxi.jpg" width="200px"></p>
                            </div>

                            <div class="box-body">
                                <div class="post">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <iframe id="jollytaxy"></iframe>
                                                <script src="http://188.11.217.25:7988/taxi_widget/assets/js/jqueryChecker.js"></script>
                                                    <script>window.onload = Jquerychecker('#jollytaxy');</script>
                                                <!---div id="taxi_map" style="height: 700px; "></div !-->
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <!-- div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Screenshots</h3>
                            </div>
                            <div class="box-body">
                                <div class="post">
                                    <div class="box-body">

                                    </div><!-- /.box-body
                                </div><!-- /.box-body
                        </div !--><!-- /.box -->
                    </div>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
          </div><!-- /.content-wrapper -->

        </div><!-- ./wrapper -->
    <?php include 'footer.php'?>
    <script type="text/javascript" src="assets/dist/js/jquery-2.2.1.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="assets/dist/js/leaflet.js"></script>
    <script type="text/javascript" src="assets/dist/js/leaflet-realtime.min.js"></script>

    <!-- FastClick -->
    <script src="assets/plugins/fastclick/fastclick.min.js"></script>

    <!-- AdminLTE App -->
    <script src="assets/dist/js/app.min.js"></script>

    <script>
        $(document).ready(function () {

            function onEachFeature(feature, layer) {
                if (feature.properties) {
                    var popupContent = '<h4 class="text-center" ><span class="label label-success">' + feature.properties.id + '</span></h4>';
                    popupContent += '<div class="text-center"><ul class="list-group">';
                    popupContent += '<li class="list-group-item text-left">' + feature.properties.popupContent + ' </li>';
                    popupContent += '</ul><p class="small">Last Sample: ' + feature.properties.date + '</p></div>';
                    layer.bindPopup(popupContent, {minWidth: 250});
                }
            }

            var taxi_icon = L.icon({
                iconUrl: "img/taxi_marker.png",
                iconSize: [26,32]
            });

            var map = L.map('taxi_map',{
                    center: [38.20523, 15.55972],
                    zoom: 11
                }),
                realtime = L.realtime({
                    url: '/jsonp_call.php?taxi=1',
                    crossOrigin: true,
                    type: 'json'
                },
                {
                    pointToLayer: function (feature, latlng) {
                        return L.marker(latlng, {icon: taxi_icon})
                    },
                    onEachFeature: onEachFeature,
                    interval: 2 * 2000
                }).addTo(map);

            var overlayMaps = {
                "taxi": realtime
            };
            var layerControl = L.control.layers(null, overlayMaps, {collapsed: false }).addTo(map);

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> - by <b>Ciam</b>'
            }).addTo(map);

            realtime.on('update', function(e) {

                //map.fitBounds(realtime.getBounds(), {maxZoom: 14});
            });

            }); // Ready
    </script>

    </body>
</html>
