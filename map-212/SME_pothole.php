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
                <li class="active"><a href="#">#SmartME Pothole</a></li>
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
                        <div class="col-md-12">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>Download App</h3>
                                    <p>#SmartME Pothole For Android</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-social-android"></i>
                                </div>
                                <a href="download/SME_Pothole.apk" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                    </div><!-- /.col -->


                    <!-- Default box -->
                    <div class="col-md-9">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">#SmartME Pothole</h3>
                            </div>
                            <div class="box-body">
                                <div class="post">
                                    <div class="box-body">
                                        <p class="text-center"><img src="img/SmartME_pothole.jpg" width="50%"></p>
                                        <p>The Pothole Detection and Mapping PDM application is based on two components:
                                            an Android app, meant to be running on mobiles and a centralized backend working
                                            as collector hub for sampled data, while also tasked with filtering, analysis
                                            and data-mining of such collection.</p>
                                        <p>The core idea consists in leveraging commonly available sensing capabilities of mobiles,
                                            carried around by people also during commuting and other driving-related activities,
                                            to automatically detect and rank road surface conditions.</p>
                                        <p>The combined sampling of acceleration values, as measured by on-board motion detection
                                            sensors, and of geospatial coordinates, as provided from the GPS subsystem, serves as
                                            a first step in generating a qualitative map of travelled roads, highlighting possible
                                            conditions of road distress as well as the potential existence of “potholes”.</p>
                                        <p>Indeed the application, started up by the user as soon as she begins her travel, performs
                                            a continuously ongoing sensing activity with regard to accelerometer-provided measurements.</p>
                                        <p>An ad-hoc developed algorithm evaluates the fluctuations in the sampled values for acceleration:
                                            intuitively, when stumbling upon a pothole along the path, or driving through a road
                                            featuring a distressed surface, these fluctuations may be abrupt. Based on predefined
                                            thresholds it then marks the existence of a potentially critical condition at those
                                            geospatial coordinates: as already pointed out, the collection of acceleration data is
                                            carried out in combination with data about current position, obtained by means of GPS.</p>
                                        <p>The measurements at the basis of the detection mechanisms are those related to the
                                            accelerometer-provided acceleration vector, its (computed) euclidean norm and in
                                            particular the (impulsive) vertical (z-axis) displacement. Based on these input data
                                            a Web-based application has been implemented which, by interfacing and querying a
                                            centralized database, performs basic filtering, aggregation and data mining operations
                                            over available data to extract useful information.</p>
                                        <p>Saving “extra” data such as the differential value of each component of the acceleration
                                            vector along the three axes of the frame of reference has been deemed essential to extract
                                            additional information from sampled data. Even if just evaluating the euclidean norm of the
                                            acceleration vector is provably enough to identify potential conditions of distress
                                            for the road surface, the analysis of that same value decomposed into its components
                                            may be useful, e.g., to pinpoint highly critical conditions (non-zero values over all
                                            three components may be evidence of a fully distressed road or, probably, an unpaved one).</p>
                                        <p>Such information may turn out to be useful for administrative bodies and competent authorities
                                            in general to plan focused maintenance services and conveniently schedule according to the
                                            class of road distress severity. Business logic, data analysis and filtering lay mostly
                                            within the aforementioned Web application: this kind of approach has been adopted to
                                            minimize the computational load for mobiles running the application, even if the latter
                                            is designed anyway to carry out certain mechanisms and apply filtering rules locally
                                            to prevent false positives. We employed as testbed a dozen mobiles among volunteering
                                            students, roaming inside the municipality of Messina, and as a result we identified a
                                            number of potholes over this area, albeit with a coverage limited to just the paths
                                            covered by this population most of the time, due to its peculiar traveling patterns.
                                        </p>
                                    </div><!-- /.box-body -->

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Screenshots</h3>
                            </div>
                            <div class="box-body">
                                <div class="post">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <a href="img/screenshot/pothole/big/1.jpg" data-lightbox="SME Pothole">
                                                    <img src="img/screenshot/pothole/1.jpg" alt="First slide">
                                                </a>
                                            </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box-body -->
                        </div><!-- /.box -->
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

    <!-- AdminLTE for demo purposes -->
    <script type="text/javascript" src="assets/dist/js/leaflet.js"></script>
    <script type="text/javascript" src="assets/dist/js/ll_MarkerCluster.js"></script>

    <!-- DataTables -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="assets/plugins/fastclick/fastclick.min.js"></script>

    <!-- AdminLTE App -->
    <script src="assets/dist/js/app.min.js"></script>

    <!-- LightBox -->
    <script src="assets/lightbox/dist/js/lightbox.js"></script>


    <div class="modal fade" tabindex="-1" id="sensor_modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Sensor data</h4>
                </div>
                <div class="modal-body">
                    <i class="fa fa-2x fa-spin fa-spinner"></i>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </body>
</html>
