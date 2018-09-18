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
                <li class="active"><a href="#">Technologies</a></li>
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
                                    <li class="list-group-item"><img src="img/loghi/Smartme.io_2" height="70px">
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
                                <h3 class="box-title">Technologies</h3>
                            </div>
                            <div class="box-body">
                                <div class="post">
                                    <p><img src="img/sensori/Sensori_SmartME.png" width="70%" class="center-block"></p>
                                    <div class='user-block'>
                                        <img class='img-circle img-bordered-sm' src='img/logo_smartme.png' alt='user image'>
                                        <span class='username'>
                                              <a href="#">#SmartME - Datasheets</a>
                                            </span>
                                    </div><!-- /.user-block -->
                                    <div class="box-body">
                                        <ul class="products-list product-list-in-box">
                                            <!-- item -->
                                            <li class="item">
                                                <div class="product-img">
                                                    <img src="img/sensori/thermistor.png" style="width: 60%; height: 60%" alt="Thermistor Sensor">
                                                </div>
                                                <div class="product-info">
                                                    <a href="#" class="product-title">Temperature Sensor</a>
                                                    <span class="product-description">Tinkerkit Thermistor</span>
                                                    <p><a href="datasheets/TinkerKitThermistorModule.pdf">
                                                            <button type="button" class="btn btn-primary pull-right"><span class="fa fa-file-pdf-o"></span>  Datasheet</button>
                                                        </a>
                                                    </p>
                                                </div>
                                            </li><!-- /.item -->
                                            <!-- item -->
                                            <li class="item">
                                                <div class="product-img">
                                                    <img src="img/sensori/brightness.png" style="width: 60%; height: 60%" alt="Brightness Sensor">
                                                </div>
                                                <div class="product-info">
                                                    <a href="#" class="product-title">Brightness Sensor</a>
                                                    <span class="product-description">Tinkerkit Ldr</span>
                                                    <p><a href="datasheets/TinkerKitLDRSensor.pdf">
                                                            <button type="button" class="btn btn-primary pull-right"><span class="fa fa-file-pdf-o"></span>  Datasheet</button>
                                                        </a>
                                                    </p>
                                                </div>
                                            </li><!-- /.item -->
                                            <!-- item -->
                                            <li class="item">
                                                <div class="product-img">
                                                    <img src="img/sensori/mpl3115.png" style="width: 60%; height: 60%" alt="Pressure Sensor">
                                                </div>
                                                <div class="product-info">
                                                    <a href="#" class="product-title">Pressure Sensor</a>
                                                    <span class="product-description">Thinkerkit Mpl3115</span>
                                                    <p><a href="datasheets/MPL3115A2.pdf">
                                                            <button type="button" class="btn btn-primary pull-right"><span class="fa fa-file-pdf-o"></span>  Datasheet</button>
                                                        </a>
                                                    </p>
                                                </div>
                                            </li><!-- /.item -->
                                            <!-- item -->
                                            <li class="item">
                                                <div class="product-img">
                                                    <img src="img/sensori/mq9.png" style="width: 60%; height: 60%" alt="Gas Sensor">
                                                </div>
                                                <div class="product-info">
                                                    <a href="#" class="product-title">Gas Sensor</a>
                                                    <span class="product-description">Groove MQ9</span>
                                                    <p><a href="datasheets/MQ-9-gas_sensor.pdf">
                                                            <button type="button" class="btn btn-primary pull-right"><span class="fa fa-file-pdf-o"></span>  Datasheet</button>
                                                        </a>
                                                    </p>
                                                </div>
                                            </li><!-- /.item -->
                                            <!-- item -->
                                            <li class="item">
                                                <div class="product-img">
                                                    <img src="img/sensori/Hih.png" style="width: 60%; height: 60%" alt="Humidity Sensor">
                                                </div>
                                                <div class="product-info">
                                                    <a href="#" class="product-title">Humidity Sensor</a>
                                                    <span class="product-description">HIH-4030</span>
                                                    <p><a href="datasheets/umidita-SEN-09569-HIH-4030-datasheet.pdf">
                                                            <button type="button" class="btn btn-primary pull-right"><span class="fa fa-file-pdf-o"></span>  Datasheet</button>
                                                        </a>
                                                    </p>
                                                </div>
                                            </li><!-- /.item -->
                                            <!-- item -->
                                            <li class="item">
                                                <div class="product-img">
                                                    <img src="img/sensori/ky38.png" style="width: 60%; height: 60%" alt="Noise Sensor">
                                                </div>
                                                <div class="product-info">
                                                    <a href="javascript::;" class="product-title">Noise Sensor</a>
                                                    <span class="product-description">KY38</span>
                                                    <p><a href="datasheets/rumore-ky-038.pdf">
                                                            <button type="button" class="btn btn-primary pull-right"><span class="fa fa-file-pdf-o"></span>  Datasheet</button>
                                                        </a>
                                                    </p>
                                                </div>
                                            </li><!-- /.item -->
                                        </ul>
                                    </div><!-- /.box-body -->

                                </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>

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
