
<?php
require 'function.php';
$id_sensor = $_REQUEST["id"];
$pack_name=$_REQUEST["pack_name"];
$limit = (isset($_REQUEST["limit"]))?($_REQUEST["limit"]):289;

$url = 'http://smartme-data.unime.it/api/action/datastore_search?resource_id='.$id_sensor.'&limit='. $limit .'&sort=Date%20desc';
$data = call_api($url);
$type_sensor=ucfirst($data->result->fields[2]->id);

$orig = [];
$res_limit = array(145 => "Last 24 Hours", 289 => "Last 48 Hours", 433 => "Last 3 Days", 910 => "Last Week");


switch ($type_sensor){
    case "Temperature":
        $measure="°C";
        break;
    case "Brightness":
        $measure="lux";
        break;
    case "Humidity":
        $measure="%";
        break;
    case "Pressure":
        $measure="hPa";
        break;
    case "Gas":
        $measure="ppm";
        break;
    case "Noise":
    case "Sound_detect":
        $measure="amplitude";
        break;
}
?>


<div class="modal-header">
  <a href="#" class="pull-right" data-dismiss="modal" aria-label="Close">
    <span class="fa fa-close"></span>
  </a>
    <h3>
      <p ><?=$type_sensor?> <small><span class="label label-info"><span class="fa fa-tag"></span> Measure Unit: <?=$measure?></span></small>
      <span class="pull-right"><small>#<?= $data->result->resource_id ?></small></span></p>
      <a href="http://smartme-data.unime.it/datastore/dump/<?= $data->result->resource_id ?>">
        <button type="button" class="btn btn-warning btn-sm"><span class="fa fa-download"></span> Download CSV</button>
      </a>
    <a href="http://smartme-data.unime.it/dataset/<?= $pack_name; ?>/resource/<?= $data->result->resource_id ?>">
        <button type="button" class="btn btn-primary btn-sm"><span class="fa fa-external-link"></span> Open Data</button></a>
    </h3>
    <p class="small">Viewing <?=$res_limit[$limit]?> <?=$_REQUEST["limit"]?></p>
</div>

<!-- Main content -->
<div class="modal-body">

    <div class="row">
      <div id="chart" class="col-xs-12 col-md-12">
        <div id="hicharts" style="width: 95% ;max-width: 100%; height:300px"></div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><?=$type_sensor?>
          </div>
          <div id="box-tabella" class="box-body hidden">
            <table id="tabella-dati" class="table table-bordered table-striped">
              <thead>
              <tr>
              <?php
              foreach ($data->result->fields as $fields) {?>
                  <th><?= $fields->id?></th>
              <?php }?>
              </tr>
              </thead>
              <tbody>
              <?php
                 if ($type_sensor=='Coordinates'){
                   foreach ($data->result->records as $record) { ?>
                     <tr>
                       <td><?= $record->_id ?></td>
                       <td><?= $record->time ?></td>
                       <td><?= $record->ept ?></td>
                       <td><?= $record->lat?></td>
                       <td><?= $record->lon ?></td>
                       <td><?= $record->alt?></td>
                       <td><?= $record->epx ?></td>
                       <td><?= $record->epy ?></td>
                       <td><?= $record->epv ?></td>
                       <td><?= $record->track?></td>
                       <td><?= $record->speed?></td>
                       <td><?= $record->climb?></td>
                       <td><?= $record->eps?></td>
                     </tr>
                 <?php }
                 } else {
                   $Date_array=array();
                   foreach ($data->result->records as $record) {
                       ?>
                    <tr>
                      <td><?= $record->_id ?></td>
                      <td><?= date('d/m/Y H:i:s', strtotime($record->Date))?></td>
                      <td><?= round($record->{$type_sensor},3) ?></td>
                      <td><?= $record->Altitude ?></td>
                      <td><?= $record->Longitude ?></td>
                      <td><?= $record->Latitude ?></td>
                    </tr>
                    <?php
                     array_push($Date_array,array('data'=>date('d/m/y H:i', strtotime($record->Date)),'value'=>round($record->{$type_sensor},1)));
                     array_push($orig,array('data'=>date('m/d/y H:i', strtotime($record->Date)),'value'=>round($record->{$type_sensor},1)));
                  }
                 }
              ?>
              </tbody>
              <tfoot>
              <tr>
                <?php
                foreach ($data->result->fields as $fields) {?>
                  <th><?= $fields->id?></th>
                <?php }?>
              </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div><!-- /.content -->
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<script>

  $(function()
  {

      var dati_sensore = [
            <?php
              $index=count($orig);
              while ($index){
                $pad = ($index>1)?" , ":"";
                $val=$orig[--$index];
                    echo('[ "'. $val['data'] . '" , "'.$val['value'].'"]' . $pad);
                } //while
            ?>
      ];

      $.each(dati_sensore, function(k,v){
          var d = new Date( v[0]);
          d.setHours(d.getHours() + 2);
          v[0] = Date.parse(d);
          v[1] = parseFloat(v[1]);
      });


      $('#hicharts').highcharts('StockChart',{
        chart: {
            type: 'line',
            events: {
                load: function(){
                    console.log($('#hicharts').css('width','100%'));
                }
            }

        },
        title: {
            text: '<?=$type_sensor?>'
        },
        rangeSelector : {
            buttons: [{
                type: 'hour',
                count: 1,
                text: '1h'
            }, {
                type: 'day',
                count: 1,
                text: '1d'
            }, {
                type: 'all',
                text: 'All'
            }],
            inputEnabled: false, // it supports only days
            selected: 4 // all
        },
        xAxis: {
            dateTimeLabelFormats: {
                hour:"%b %e, %H:%M",
                month: '%e. %b',
                year: '%b'
            },
            type: 'datetime'
        },
        yAxis: {
            title: {
                text: 'unit: <?=$measure?>'
            }
        <?php
        if ($measure=="amplitude")
        {
        ?>,
            plotBands: [{
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
            }]
        <?php } ?>
        },
        tooltip: {
            valueDecimals: 1,
            <?php
            // Format differente nel caso di NOISE.
            switch(true){
            case ($measure=="amplitude"):
            ?>
            useHTML: true,
            formatter: function(){
                var s = '<span class="small">'+ Highcharts.dateFormat("%A, %b %e,  %H:%M", this.x) + '</span>';
                $.each(this.points, function () {
                    var yy = this.y;
                    var label;

                   switch(true){
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
            shared: true,

            <?php
            break;
            default:
            ?>
            valueSuffix: ' <?=$measure?>'
            <?php
            break;
            } ?>
        },

        series: [{
            name: '<?=$type_sensor?>',
          data: dati_sensore
        }]
    });


      $("#tabella-dati").on('init.dt', function(){
          $('#box-tabella').removeClass('hidden');
      }).DataTable();

// $(this).trigger('show.bs.modal');
  });



</script>
