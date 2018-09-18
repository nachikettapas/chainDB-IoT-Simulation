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
                <li class="active"><a href="#">#SmartME Energy</a></li>
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
                                <h3 class="box-title">#SmartME Energy</h3>
                            </div>
                            <div class="box-body">
                                <div class="post">
                                    <div class="box-body">
                                        <p class="text-center"><img src="img/SmartME_energy.jpg" width="50%"></p>
                                        <p>This project, already in prototype form, consists of a smart electronic device
                                            that by analysing the absorption of the electric loads connected to the electrical
                                            grid, allows identifying the standby consumption of equipment and eliminating them
                                            simply removing, selectively, the power.</p>
                                        <p>The prototype is installed to the University of Messina and now is storing and analysing
                                            the load data of the many devices installed such as computers, printers, access point and more.
                                            When the monitoring detects an idle state of the device, after a programmable time it
                                            intervenes to remove the unnecessary power consumption.</p>
                                        <p>The proposed solution, compared to the commercial ones, has many differences. Some the
                                            main features of the prototype are:
                                            <ul>
                                                <li>Smart processing ability: represents the ability to perform actions on the basis
                                                    of the occurrence of events;</li>
                                                <li>Electrical power management: represents the ability to turn off the power of the
                                                    device that are in standby state;</li>
                                                <li>Data transmission: represents the ability to transfer data via Ethernet/WiFi;</li>
                                                <li>Scalability: since the solution based on Linux distribution, this feature
                                                    represents the ability to manage add-on that, dynamically, increases the device
                                                    functionality.</li>
                                            </ul>
                                        </p>
                                    </div><!-- /.box-body -->

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Modules</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-1">
                                        <a href="img/screenshot/energy/big/1AP.jpg" data-lightbox="SME Energy">
                                            <img src="img/screenshot/energy/1AP.jpg" alt="Access Point + Arduino Yun">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="img/screenshot/energy/big/2ST.jpg" data-lightbox="SME Energy">
                                            <img src="img/screenshot/energy/2ST.jpg" alt="Electric panel's satellite module for load management">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="img/screenshot/energy/big/3ST.jpg" data-lightbox="SME Energy">
                                            <img src="img/screenshot/energy/3ST.jpg" alt="Electric panel's satellite module for light management">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="img/screenshot/energy/big/4DK.jpg" data-lightbox="SME Energy">
                                            <img src="img/screenshot/energy/4DK.jpg" alt="Desk's satellite module for load management">
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="img/screenshot/energy/big/5QE.jpg" data-lightbox="SME Energy">
                                            <img src="img/screenshot/energy/5QE.jpg" alt="Electric panel with installed modules">
                                        </a>
                                    </div>
                                </div>
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
