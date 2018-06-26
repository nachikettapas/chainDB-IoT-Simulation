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
                <li class="active"><a href="#">Timeline</a></li>
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
                                <h3 class="box-title">Timeline</h3>
                            </div>
                            <div class="box-body">
                                <!-- The timeline -->
                                    <ul class="timeline timeline-inverse">
                                        <!-- timeline time label -->
                                        <li class="time-label">
                                            <span class="bg-blue">
                                              June, 27 2016
                                            </span>
                                        </li>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <li>
                                            <i class="fa fa-calendar-check-o bg-red"></i>
                                            <div class="timeline-item">

                                                <h2 class="timeline-header"><a href="#">Messina ICT Innovation day, co-located with IEEE-ISCC 2016.</a></h2>
                                                <div class="timeline-body">
                                                    First application demo of #SmartME
                                                    <ul>
                                                        <li>#SmartME Sensor</li>
                                                        <li>#SmartME Tour</li>
                                                        <li>#SmartME Pothole</li>
                                                        <li>#SmartME Parking</li>
                                                        <li>#SmartME Bus Stop</li>
                                                        <li>#SmartME Lighting</li>
                                                        <li>#SmartME Energy</li>
                                                    </ul>
                                                    <div class="row">
                                                        <div class="col-md-offset-2 col-md-8">
                                                            <div class="embed-responsive embed-responsive-16by9">
                                                                <iframe width="560" height="315" src="https://www.youtube.com/embed/WxPg2Mv2Te0" frameborder="0" allowfullscreen></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </li>
                                        <!-- END timeline item -->

                                        <!-- timeline time label -->
                                        <li class="time-label">
                                            <span class="bg-blue">
                                              March, 17 2016
                                            </span>
                                        </li>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <li>
                                            <i class="fa fa-calendar-check-o bg-red"></i>
                                            <div class="timeline-item">

                                                <h2 class="timeline-header"><a href="#">Deployment and installation of the first seven sensor boards in the city center.</a></h2>
                                                <div class="timeline-body">
                                                    <ul>
                                                        <li>Rettorato - P.zza Pugliatti 1</li>
                                                        <li>Palazzo Mariani - P.zza Antonello</li>
                                                        <li>Dipartimento Scienze Politiche e Giuridiche - P.zza XX Settembre 4</li>
                                                        <li>SIR Facoltà di Scienze e Tecnologie - C.da Papardo Polo Universitario</li>
                                                        <li>Policlinico Universitario - AOU Policlinico G. Martino Viale Gazzi Messina</li>
                                                        <li>Dipartimento Civiltà antiche e moderne - Viale Annunziata - Polo Universitario</li>
                                                        <li>Dipartimento Scienze cognitive, psicologiche, pedagogiche e degli studi culturali - Via Concezione, n.6</li>
                                                    </ul>
                                                </div>
                                        </li>
                                        <!-- END timeline item -->

                                        <!-- timeline time label -->
                                        <li class="time-label">
                                            <span class="bg-blue">April, 28 2015</span>
                                        </li>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <li>
                                            <i class="fa fa-video-camera bg-yellow"></i>
                                            <div class="timeline-item">
                                                <h3 class="timeline-header"><a href="#">First working meeting</a></h3>
                                                <div class="timeline-body">
                                                    <ul>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="embed-responsive embed-responsive-16by9">
                                                                    <iframe width="420" height="315" src="https://www.youtube.com/embed/G_VnAPNX9VQ" frameborder="0" allowfullscreen></iframe>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="embed-responsive embed-responsive-16by9">
                                                                    <iframe width="420" height="315" src="https://www.youtube.com/embed/Pds6necpWMs" frameborder="0" allowfullscreen></iframe>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="embed-responsive embed-responsive-16by9">
                                                                    <iframe width="420" height="315" src="https://www.youtube.com/embed/u_XVY6xgrX8" frameborder="0" allowfullscreen></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </ul>
                                                    <!--<img src="http://placehold.it/150x100" alt="..." class="margin">
                                                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                                                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                                                    <img src="http://placehold.it/150x100" alt="..." class="margin">-->
                                                </div>
                                            </div>
                                        </li>
                                        <!-- END timeline item -->

                                        <!-- timeline time label -->
                                        <li class="time-label">
                                            <span class="bg-blue">
                                              April, 14 2015
                                            </span>
                                        </li>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <li>
                                            <i class="fa fa-eur bg-aqua"></i>
                                            <div class="timeline-item">
                                                <h2 class="timeline-header"><a href="#">Conclusion of the funding phase</a></h2>
                                                <!--<div class="timeline-body">
                                                    https://www.eppela.com/en/projects/5787-smartme-la-messina-del-futuro
                                                </div>-->
                                            </div>
                                        </li>
                                        <!-- timeline time label -->
                                        <li class="time-label">
                                            <span class="bg-blue">
                                              February, 17 2015
                                            </span>
                                        </li>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <li>
                                            <i class="fa fa-eur bg-aqua"></i>
                                            <div class="timeline-item">

                                                <h2 class="timeline-header"><a href="#">Startup of the funding stage</a></h2>
                                                <div class="timeline-body">
                                                    Platform EPPELA: #SMARTME MESSINA IN THE FUTURE - Innovatively making the city of Messina "smart".
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="https://www.eppela.com/en/projects/5787-smartme-la-messina-del-futuro" target="_blank" class="btn btn-primary btn-xs">Read more</a>
                                                <!--    <a class="btn btn-danger btn-xs">Delete</a>
                                                </div>-->
                                            </div>
                                        </li>
                                        <!-- END timeline item -->
                                        <li>
                                            <i class="fa fa-clock-o bg-gray"></i>
                                        </li>
                                    </ul>
                                </div><!-- /.tab-pane -->
                            </div><!-- /.tab-content -->
                        </div><!-- /.nav-tabs-custom -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
          </div><!-- /.content-wrapper -->
          <?php include 'footer.php'?>
        </div><!-- ./wrapper -->




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