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
                                    <p>#SmartME Sensors For Android</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-social-android"></i>
                                </div>
                                <a href="download/SME_Sensor.apk" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div><!-- /.col -->

                    <!-- Default box -->
                    <div class="col-md-9">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">#SmartME Sensors</h3>
                            </div>
                            <div class="box-body">
                                <div class="post">
                                    <div class="box-body">
                                        <p>One of the vertical use cases that has been implemented in the #SmartME project
                                            is the collection of city environmental monitoring data in a standard open data format.
                                            We exploited CKAN, an open source data portal software, to store and visualize the
                                            collected data.</p>
                                        <p>Asynchronous plugins are used in this application for sampling environmental data
                                            and sending it to the CKAN datastore. The plugins run on top of Arduino YUN boards
                                            deployed in the Messina urban area.</p>
                                        <p>The Arduino YUN is an embedded board based on the Atmel ATmega32u4 micro-controller
                                            and the Atheros AR9331 System-on-a Chip. Linino OS, a Linux distribution based on
                                            OpenWrt, runs on the Atheros MIPS processor, also supporting microcontroller-exposed
                                            interfaces to General Purpose I/O (GPIO) pins. The board has built-in Ethernet and
                                            WiFi support, a USB-A port, micro-SD card slot, 20 digital I/O pins (of which 7 can be
                                            used as PWM outputs and 12 as analog inputs), a 16 MHz crystal oscillator,
                                            a micro USB connection, an ICSP header, and 3 reset buttons.</p>
                                        <p>In order to host a set of low-cost sensors, the YUN board has been equipped with a
                                            Tinkerkit Shield. In particular, a Tinkerkit thermistore, Ldr, and Mpl3115 have
                                            been employed as temperature, brightness, and pressure sensors, respectively.
                                            A Groove MQ9 is installed as CO sensor, to obtain information about air quality.
                                            Finally, a Honeywell HIH-4030 has been selected as humidity sensor while an Arduino
                                            KY38 captures the environmental noise level.</p>
                                        <p>Using the ideino-linino library, plugins periodically sample the voltage levels
                                            of the pins to which sensors are connected. Such voltage samples are then elaborated
                                            to obtain the environmental data and finally sent to CKAN together with a timestamp
                                            and the geographical position of the node.</p>
                                    </div><!-- /.box-body -->

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
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
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Screenshots</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="img/screenshot/sensor/big/1.jpg" data-lightbox="SME Sensors">
                                        <img src="img/screenshot/sensor/1.jpg" alt="First slide">
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="img/screenshot/sensor/big/2.jpg" data-lightbox="SME Sensors">
                                            <img src="img/screenshot/sensor/2.jpg" alt="First slide">
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="img/screenshot/sensor/big/3.jpg" data-lightbox="SME Sensors">
                                            <img src="img/screenshot/sensor/3.jpg" alt="First slide">
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="img/screenshot/sensor/big/4.jpg" data-lightbox="SME Sensors">
                                            <img src="img/screenshot/sensor/4.jpg" alt="First slide">
                                        </a>
                                    </div>
                                </div>
                            </div>

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

    </body>
</html>
