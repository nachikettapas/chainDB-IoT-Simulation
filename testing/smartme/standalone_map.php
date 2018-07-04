<!DOCTYPE html>
<?php
//include 'config.php';
require 'function.php';
require 'head.php';

//This URL is not being used anywhere at all.
$url = 'http://localhost:5000/retrieve/sensors';
$dataset = call_api($url);

$res_limit = array(145 => "Last 24 Hours", 289 => "Last 48 Hours", 433 => "Last 3 Days", 910 => "Last Week");

$limit = (int)(isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 145;

$unit = array("temperature" => "C", "brightness" => "Lux", "humidity" => "%", "pressure" => "hPa", "gas" => "ppm", "noise" => "Amp");

?>

<div id="loading_bar"></div>
<div id="mapdiv" style="height: 640px"></div>


<script type="text/javascript" src="assets/dist/js/jquery-2.2.1.min.js"></script>

<!-- Bootstrap 3.3.5 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/leaflet.js"></script>
<script type="text/javascript" src="js/leaflet.markercluster.js"></script>
<script type="text/javascript" src="assets/dist/js/leaflet-realtime.min.js"></script>

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


<div class="modal fade" id="lamp_modal"  tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="pull-right" data-dismiss="modal" aria-label="Close">
                    <span class="fa fa-close"></span>
                </a>
		<h3 class="modal-title">Turn ON/OFF a lamp</h3>
	    </div>
            <div class="modal-body">

                 <div class="form-group form-inline">
                     <label>Lamp list</label>
                          <select class="form-control" id="lamp_list">
				<?php
					for($i=1;$i<=10;$i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
			  </select>

		     <label>Status</label>
			  <select class="form-control" id="lamp_status">
				<option value="100">ON</option>
				<option value="0">OFF</option>
			  </select>

    		     <button type=button" class="btn btn-default" onclick="change_lamp_status();">
			Send
                     </button>
		</div>
	    </div>
            <fieldset>
                <legend>Output</legend>
                <p id="lampstatus-output" />
            </fieldset>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    
<script>

	// SYSTEM !!!! (after CNET demo ...)
    function change_lamp_status(){
	var lamp_id = document.getElementById("lamp_list").value;
	var dimming = document.getElementById("lamp_status").value;

	var loader_pathfile = './ajax-loader.gif';
	document.getElementById('loading_bar').style.visibility='visible';
	document.getElementById('loading_bar').style.width='100%';
        document.getElementById('loading_bar').style.height='100%';
        document.getElementById('loading_bar').style.position='fixed';//'absolute';//'fixed';
        document.getElementById('loading_bar').style.top='0';
        document.getElementById('loading_bar').style.left='0';
        document.getElementById('loading_bar').style.zIndex='9999';
        document.getElementById('loading_bar').style.background="url('"+loader_pathfile+"') no-repeat center center rgba(0,0,0,0.25)";


	$.ajax({
		url: "http://212.189.207.206:8555/"+lamp_id+"/"+dimming,
		type: "GET",
		dataType: 'jsonp',

		success: function(response){
			//document.getElementById("lampstatus-output").innerHTML = JSON.stringify(response.result);
			document.getElementById('loading_bar').style.visibility='hidden';
			document.getElementById("lampstatus-output").innerHTML = "Lamp "+lamp_id+ " new brightness value --> "+dimming;
		},
		error: function(response){
			//document.getElementById("lampstatus-output").innerHTML = "ERROR: "+JSON.stringify(response.result);
			document.getElementById('loading_bar').style.visibility='hidden';
			document.getElementById("lampstatus-output").innerHTML = "Lamp "+lamp_id+ " new brightness value --> "+dimming;
		}

	});
    }


    $(document).ready(function () {

	var flag_first_load = true;

        // Funzioni di supporto
        // inserimento dei mark dall'elenco delle BOARDS.
         var taxi_icon = L.icon({
                iconUrl: "img/taxi_marker.png",
                iconSize: [26,32]
            });
            
        function onEachFeature(feature, layer) {
            // does this feature have a property named popupContent?
            if (feature.properties && feature.properties.popupContent) {
                layer.bindPopup(feature.properties.popupContent);
            }
        }



        function GetMap() {

	    distretti.clearLayers();

            var district = $.ajax('./assets/map/districts.geojson');
            district.done( function (data){
                        distretti.options = {onEachFeature: onEachFeature};
                        distretti.addData(JSON.parse(data));
                        //console.log("stretti£",distretti)//.addData(JSON.parse(data));
                 }                   
            );
        }    

	
        function GetSensoriConDati() {


			var jcall = JsonpCall(package_url, "", 1000, "GetCKAN");
			console.log("GetSensoriConDati():" + jcall);
            var res = [];
            var extras = [];

            var board_spente = [""]; //,  "sme-00-0006 - Policlinico Universitario", "sme-00-0016 - Villa Pace"];

            jcall.done(function (data) {
				console.log(data);
                $.each(data.result, function (k, v) {
					console.log(k,v);
					//k is the index of the loop.
					//v is the actual data
                    extras = v.extras;
                    var lat;
                    var long;
                   // if (typeof v.organization.title === 'undefined') {return true};

		    // Avoid the cases where the organisation is null,
                    if(v.organization != null) {
                      //if (v.num_resources > 0 && v.organization.title == ckan_organization && (board_spente.indexOf(v.notes) < 0)) {
		      if (v.num_resources ==7 && v.organization.title == ckan_organization && (board_spente.indexOf(v.notes) < 0)) {
 
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
									console.log("Sensor url: " + sensor_url)
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
				array_markers_sensors.push(marker);
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


	//NUOVA VERSIONE: funzione per la creazione del contesto (ovvero il contenuto del popup) del marker 
	//******************************************************************************************************************************
	//Nel caso in cui volessi stampare il contenuto di JSON ricorsivi
	
	function censor(censor) {
		var i = 0;

		return function(key, value) {
			if(i !== 0 && typeof(censor) === 'object' && typeof(value) == 'object' && censor == value) 
				return '[Circular]'; 

			if(i >= 29) // seems to be a harded maximum of 30 serialized objects?
				return '[Unknown]';

			++i; // so we know we aren't using the original object anymore

			return value;  
		}
	}
	
	//******************************************************************************************************************************


	//Accetta in ingresso il tag, l'icona del marker, l'array che conterrà tutti i marker ed il layer dei marker
	function retrieve_data_and_create_markers(tag, icon, array_markers, layer){

		var allowed_time_window = "30"; //in minuti


		var array_promise_tag = [];
		array_promise_tag.push(new Promise( function (resolve){
			JsonpCallTagShow(tag_show_url, tag, resolve);
		}));

		var packs = [];

		//Itera sulle board con il tag selezionato
		Promise.all(array_promise_tag).then(values => {
			//console.log("Boards from TAG");
			//console.log(values);

			//Itera sulle board per ottenere le risorse
			for(i=0; i<values[0].result.packages.length; i++){
				var package = values[0].result.packages[i];

				var lat = null; var long = null;
				var label = "";

				for(l=0; l<package.extras.length; l++){
					if(package.extras[l].key == "Latitude") lat = package.extras[l].value;
					else if(package.extras[l].key == "Longitude") long = package.extras[l].value;

					else if(tag == "testbed" && package.extras[l].key == "Label") label = package.extras[l].value;

				}
				if(label == "") label = package.title;

				var resources = [];
				for(j=0; j<package.num_resources; j++){
					resource = package.resources[j];

					//if(resource.name != "sensors") //Aggiunto questo controllo per evitare di avere un'ulteriore datastore da controllare nel caso di box appartenenti al gruppo con tag "testbed"
					resources.push({name: resource.name, id: resource.id});
				}

				packs[i] = {
					date: null,
					id: package.id,
					lat: lat,
					long: long,
					label: label, //package.title,
					name: package.name,
					resources: resources,
					visibility: true
				}
				//console.log(packs[i]);
			
				//DA VERIFICARE !!!!! (al momento si usa l'altra funzione)
				/*
				if(tag == "testbed"){
					//console.log(packs[i]);
					for(j=0; j<package.num_resources; j++){
						//console.log(packs[i].label+" "+package.resources[j].name);

						//Serve solamente a prendere la data del campione piu' recente ed eventualmente se troppo vecchio...non fare apparire la board
						if(package.resources[j].name == "temperature"){
							//console.log(packs[i].label+" "+package.resources[j].name);

							var a = new Promise( function (resolve){
								JsonpCallDatastoreSearchLast(datastore_search_url, package.id, package.resources[j].id, package.resources[j].name, "Date desc", resolve);
							});

							Promise.all([a]).then(values => {
								//console.log(values);
								//console.log(packs[i].label+" "+package.resources[j].name);

								var date = new Date();
								var start_time_window = new Date(date.setMinutes(date.getMinutes() - allowed_time_window));

								if(values[0].result.records.length != 0){
									board_date = new Date(values[0].result.records[0].Date);
									
									//console.log("BOARD: "+board_date+ " BROWSER: "+start_time_window);

									for(k=0; k<packs.length; k++){

										if(packs[k].id == package.id){
											//Se la data dell'ultimo campione della board e' precedente alla finestra di 30 minuti concessa bisogna non far apparire tale board
											
											//if(board_date >= start_time_window){

											//	packs[k].visibility = true;
												//console.log("ACTIVE ---> Board: "+packs[k].label);
											//}
											//else{
											//	packs[k].visibility = false;
												//console.log("INACTIVE ---> Board: "+packs[k].label);
											//}
											//break;

											if(board_date >= start_time_window){
												packs.remove(k);
											}
											break;
										}
									}
								}
							});
							break;
						}
					}
				}
				*/
				/*
				if(tag == "testbed"){
					console.log("testbed...");
				}
				else if (tag == "energy") {
					//bla(package, tag, icon, array_markers, layer);
					console.log("energy...");
				}
				else if (tag == "seismic"){
					console.log("seismic...");
				}
				*/


				var popup = L.popup({maxWidth: 700, minWidth: 200});

				if(tag == "testbed" || tag == "energy"){
					var marker = L.marker([packs[i].lat, packs[i].long], {title: packs[i].label, id: packs[i].id, icon: icon });

					marker.on('click', function(e){
						//var array_promise = [];

						//DEBUG (utile per vedere i campi del marker)!!!!
						//-------------------------------------------------------
						//console.log(JSON.stringify(e, censor(e)));

						//OUTPUT:
						//{"originalEvent":{"isTrusted":true},"containerPoint":{"x":689,"y":121},"layerPoint":{"x":628,"y":354},"latlng":{"lat":38.1680344597114,"lng":15.529174804687502},"type":"click","target":{"options":{"title":"ciam-esaving-100266","id":"19ad46fa-622b-4b1a-a6f2-dd7eb88e59a8","icon":{"options":{"iconUrl":"img/energy_marker.png","iconSize":[19,32]},"_initHooksCalled":true},"zIndexOffset":1000000,"opacity":1},"_latlng":{"lat":38.1680344597114,"lng":15.529174804687502},"_initHooksCalled":"[Unknown]","_events":"[Unknown]","_leaflet_id":"[Unknown]","__parent":"[Unknown]","_spiderLeg":"[Unknown]","_eventParents":"[Unknown]","_mapToAdd":"[Unknown]","_map":"[Unknown]","_zoomAnimated":"[Unknown]","_icon":"[Unknown]","_shadow":"[Unknown]","dragging":"[Unknown]","_zIndex":"[Unknown]","_preSpiderfyLatlng":"[Unknown]","_firingCount":"[Unknown]"}}
						//-------------------------------------------------------


						var pack_id = e.target.options.id;
						for(i=0; i< packs.length; i++){
							//console.log(packs[i].id);
							if(packs[i].id == pack_id){
								//console.log("NAME == TITLE "+packs[i].name+ " "+packs[i].id);
	
								var array_promise = [];
								for(j=0; j< packs[i].resources.length; j++){
									array_promise.push(new Promise( function (resolve){
										JsonpCallDatastoreSearchLast(datastore_search_url, packs[i].id, packs[i].resources[j].id, packs[i].resources[j].name, "Date desc", resolve);
									}));
								}
								Promise.all(array_promise).then(values => {
									//console.log(values);
									var sensors_list = '';

									for(p=0; p<values.length; p++){
										result = values[p].result;
	
										//Scegliamo sempre il timestamp più "recente"
										if(packs[i].date != null)
											packs[i].date = compare_dates(packs[i].date, result.records[0].Date);
	
										if(packs[i].lat == null && packs[i].long == null){
	
											packs[n].lat = result.records[0].Latitude;
											packs[n].long = result.records[0].Longitude;
											//packs[n].date = result.records[0].Date;
										}


										if(tag == "energy"){
											var sensor_url = 'pack_name=' + packs[i].name + '&id=' + result.records.resource_id + '&limit=<?=$limit?>';

											var unit_label='';
											if  (result.resource_name.startsWith('Power'))            unit_label = "Watt";
											else if (result.resource_name.startsWith('Brightness'))   unit_label = "uWatt/cm2";
											else if (result.resource_name.startsWith('Temperature'))  unit_label = "Celsius";

											sensors_list += '<a class="list-group-item call_modal ' +
												' bold" style="color:black" sensor-name="' + result.resource_name +
												'" id="' + result.resource_id + '" pack_name="' + packs[i].name +
												'" url="' + sensor_url + '" sensor_type="energy" sensor_unit="'+ unit_label +'"  href="#sensor_modal">' + //sensor_unit="'+ pack.unit +'"
												result.resource_name + ' <span class="label text-maroon" style="background-color: DarkKhaki"></span></a>\n';
										}

										else if(tag == "testbed"){
											if(result.resource_name == "sensors"){
												board = '&nbsp;<a class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#info_modal" '+
													'href="details.php?pack_name=' + packs[i].name + '&pack_id=' + packs[i].id + '&res_id=' + result.resource_id + '">' +
													'<i style="color: white" class="fa fa-info-circle"></i></a>' + "<br><br>\n";
											}
											else{
												var sensor_url = (result.resource_name == "gas") ? "" : 'pack_name=' + packs[i].name + '&id=' + result.resource_id + '&limit=<?=$limit?>&sensor=' + result.resource_name;
												var padding = (result.resource_name == "gas") ? " Coming Soon" : "";
	
												sensors_list += '<a class="list-group-item call_modal ' + icons[result.resource_name].color +
													' bold" style="color:white" sensor-name="' + result.resource_name +
													'" id="' + result.resource_id + '" pack_name="' + packs[i].name +
													'" url="' + sensor_url + '" href="#sensor_modal">' +
													'<i class="' + icons[result.resource_name].icon + '"></i> '
													+ result.resource_name + ' <span class="label text-maroon" style="background-color: white">'
													+ padding + "</span></a>\n";
											}
										}
									}
	
									if(tag == "energy"){
										marker_popup_content = '<div class="punto"  id="' + packs[i].id + '" ' +
											'pack="' + packs[i].id + '" ><b>' + packs[i].label + '</b>'+
											'<br>\n' +
											'<span class="sample_date text-light-blue">&nbsp;</span>' +
											'<div class="list-group text-left" >' + sensors_list + '</div></div>';
									}

									else if(tag == "testbed"){
										marker_popup_content = '<div class="punto" id="' + packs[i].id + '" pack="' + packs[i].id + '" ><b>' + packs[i].label + '</b>' + 
											board + '<br>\n<span class="sample_date text-light-blue">&nbsp;</span>' +
											'<div class="list-group text-left">' + sensors_list + '</div></div>';
									}

									var x = popup.setLatLng(e.latlng).setContent(marker_popup_content).openOn(map);
								});
								break;
							}
						}
					});

					array_markers.push(marker);
					layer.addLayer(marker);
					//map.addLayer(layer);
				}
				else if (tag == "seismic" || tag == "landslide"){

					var unit_label = "";
					var sensor_name = "";
					var label = "";
					var sensor_type = tag;

					if (tag == "seismic"){
						label = "Accelerometer";
						unit_label = "m/s^2";
						sensor_name = "seismograph";
					}
					else if (tag == "landslide"){
						label = "Landslide";
						unit_label = "cos dir";
						sensor_name = "inclinometer";
					}

					//console.log(packs);
					for(l=0; l< packs.length; l++) {
					
						var array_promise = [];
						for (m = 0; m < packs[l].resources.length; m++) {
							//console.log(datastore_search_url+" "+packs[l].id+" "+packs[l].resources[m].id+" "+packs[l].resources[m].name);
							if(removed_datastores.indexOf(packs[l].resources[m].name) != -1)
								continue;
							else{
								array_promise.push(new Promise(function (resolve) {
									JsonpCallDatastoreSearchLast(datastore_search_url, packs[l].id, packs[l].resources[m].id, packs[l].resources[m].name, "timestamp desc", resolve);
								}));
							}
						}
						Promise.all(array_promise).then(values => {

							for(n=0; n<values.length;n++){

								if(values[n].result.records.length != 0){
									//console.log(values[n]);
									result = values[n].result;
									record = result.records[0];
									
									var marker = L.marker([record.lat, record.lng], {title: result.resource_name, id: result.resource_id, icon: icon });
									marker.on('click', function(e){
										for(o=0; o<packs.length; o++){

											flag = false;
											for(p=0; p<packs[o].resources.length; p++){
												if(packs[o].resources[p].id == e.target.options.id){
													//console.log("HERE: "+e.target.options.id);
													var dataset_name = packs[o].name;
													name = packs[o].resources[p].name;
													id = packs[o].resources[p].id;

													var sensor_url = 'pack_name=' + name + '&id=' + id + '&limit=<?=$limit?>';
													//var unit_label = "m/s^2";

													var sensors_list = '';
													/*
													var axis = ["X", "Y", "Z"];

													for(q=0; q< axis.length; q++){
														sensors_list += '<a class="list-group-item call_modal ' +
															' bold" style="color:black" sensor-name="'+axis[q]+'a' +
															'" id="' + id + '" pack_name="' + name +
															'" url="' + sensor_url + '" sensor_type="seismic" sensor_unit="'+ unit_label +'"  href="#sensor_modal">' + //sensor_unit="'+ pack.unit +'"
															axis[q]+' acceleration' + ' <span class="label text-maroon" style="background-color: DarkKhaki"></span></a>\n';
													}
													*/

													sensors_list += '<a class="list-group-item call_modal ' +
														' bold" style="color:black" sensor-name="'+ sensor_name +
														'" id="' + id + '" pack_name="' + dataset_name +
														'" url="' + sensor_url + '" sensor_type="'+sensor_type+'" sensor_unit="'+ unit_label +'"  href="#sensor_modal">' +
														label + ' <span class="label text-maroon" style="background-color: DarkKhaki"></span></a>\n';


													marker_popup_content = '<div class="punto" id="' + packs[o].id + '" ' +
														'pack="' + packs[o].id + '" ><b>' + name + '</b>'+
														'<br>\n' +
														'<span class="sample_date text-light-blue">&nbsp;</span>' +
														'<div class="list-group text-left" >' + sensors_list + '</div></div>';

													var x = popup.setLatLng(e.latlng).setContent(marker_popup_content).openOn(map);
													flag = true;
													break;
												}
												/*
												else
													console.log("THERE");
												*/
											}
											if(flag == true)
												break;
										}
									});
									array_markers.push(marker);
									layer.addLayer(marker);
								}
							}
						});
					}
				}
			}
			map.addLayer(layer);
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

	   array_markers_cam.push(marker);
           cam.addLayer(marker);
           map.addLayer(cam); 
        }

        function GetInfraredCam(){

           var cam_icon = L.icon({
                iconUrl: "img/cam_marker.png",
                iconSize: [20,32]
           });

           var popup = L.popup({maxWidth: 700, minWidth: 200})
                                .setContent('<div class="infraredcam" style="width: 320px;"><img id="infracamera" width="320" height="240" src="http://212.189.207.206/termo/image.jpg" /></div>');
           var marker = L.marker([37.466781,15.0639], {title: "infrared_cam", icon: cam_icon }).bindPopup(popup);

	   array_markers_infrared_cam.push(marker);
           infraredcam.addLayer(marker);
           map.addLayer(infraredcam); 
        }

        function GetParkingCam(){

           var cam_icon = L.icon({
                iconUrl: "img/park_marker.png",
                iconSize: [20,32]
           });

           var popup = L.popup({maxWidth: 700, minWidth: 200})
                                .setContent('<div class="parking_cam" style="width: 420px; position: relative;"><img id="parking_camera" width="420" src="http://psmdmi.parksmart.it:9012/imgs/cam1.jpg" /><object id="svg_cam_1" data="http://psmdmi.parksmart.it:9012/css/cam1.svg" type="image/svg+xml" class="img-responsive" style="position: absolute; top: 0px;left: 0;">your browser does not support svg</object></div><span>Engineering Department Parking Area<span id="parking_info"></span>');
           var marker = L.marker([38.25860, 15.59639], {title: "parking_cam", icon: cam_icon }).bindPopup(popup);

	   //FROM (con telecamera parcheggio Unime e parcheggio MI separati)
	   //array_markers_parking_cam.push(marker);

	   //TO (parcheggi unificati)
	   array_markers_parking_global.push(marker);

	   //FROM (con telecamera parcheggio Unime e parcheggio MI separati)
	   /*
           parking.addLayer(marker);
           map.addLayer(parking); 
	   */

	   //TO (parcheggi unificati)
	   global_parking.addLayer(marker);
	   map.addLayer(global_parking);
        }


	function GetWorldCam(){

		var cams = [];

		var cam_icon = L.icon({
			iconUrl: "img/cam_marker.png",
			iconSize: [20,32]
		});

		var sql = "";
		sql += 'SELECT DISTINCT "Name", "Latitude", "Longitude" FROM "'+world_datastore+'" ';

		var sql_url = datastore_search_sql_url + '?sql=' +sql;
		var dati = $.getJSON({
			url: sql_url,
			dataType: 'jsonp'
		}).done(function (data){
			//console.log(data);
			var records = data.result.records;

			$.each(records, function (k, v) {
				//console.log(k+" "+JSON.stringify(v));
				//{"Name":"Lunenburg", "Longitude":-63.71, "Latitude":44.79}
				
				cams[k] = {
					label: v.Name,
					latitude: v.Latitude,
					longitude: v.Longitude
				}

				var popup = L.popup({maxWidth: 700, minWidth: 200});
				var marker = L.marker([cams[k].latitude, cams[k].longitude], {title: cams[k].label, icon: cam_icon });

				marker.on('click', function(e){

					//console.log(JSON.stringify(e, censor(e)));
					//OUTPUT:
					//{"originalEvent":{"isTrusted":true},"containerPoint":{"x":551,"y":110},"layerPoint":{"x":556,"y":-26},"latlng":{"lat":40.626148,"lng":14.376205},"type":"click","target":{"options":{"title":"Sorrento","icon":{"options":{"iconUrl":"img/cam_marker.png","iconSize":[20,32]},"_initHooksCalled":true}},"_latlng":{"lat":40.626148,"lng":14.376205},"_initHooksCalled":true,"_events":{"click":["[Unknown]"],"remove":"[Unknown]"},"_leaflet_id":"[Unknown]","_mapToAdd":"[Unknown]","_map":"[Unknown]","_zoomAnimated":"[Unknown]","_icon":"[Unknown]","_shadow":"[Unknown]","dragging":"[Unknown]","_zIndex":"[Unknown]","_firingCount":"[Unknown]"}}

					//console.log(e.target.options.title + " "+JSON.stringify(e.latlng));

					var lat=encodeURIComponent(e.latlng.lat).replace(/\./g, '%2E');
					var lng=encodeURIComponent(e.latlng.lng).replace(/\./g, '%2E');

					var sqlStatement ="";
					sqlStatement += 'SELECT * FROM "'+world_datastore+'" ';
					//sqlStatement += 'WHERE "Name"=\''+e.target.options.title+'\' ';
					sqlStatement += 'WHERE "Latitude"=\''+lat+'\' AND "Longitude"=\''+lng+'\' ';
					sqlStatement += 'ORDER BY "Tstamp" DESC ';
					sqlStatement += 'LIMIT 1';

					var sql_url = datastore_search_sql_url + '?sql=' +sqlStatement;
					var dati = $.getJSON({
						url: sql_url,
						dataType: 'jsonp'
					}).done(function (data){
						//console.log(data);
						record = data.result.records[0];

						for(i=0;i<cams.length;i++){
							if(cams[i].label == record.Name){
								cams[i].timestamp = record.Tstamp;
								cams[i].bicycles = record.Bicycles;
								cams[i].buses = record.Buses;
								cams[i].cars = record.Cars;
								cams[i].motorcycles = record.Motorcycles;
								cams[i].people = record.Persons;
								cams[i].trucks = record.Trucks;


				                                var marker_popup_content = '<div class="punto">' +
                                				                                '<center>'+
                                                                				        '<b>'+cams[i].label+'</b><br>'+
				                                                                        '<span class="sample_date text-light-blue">'+adapt_date(cams[i].timestamp)+'</span><br>'+
                                				                                '</center>'+
                                                                				'<b>Bicycles: </b>'+cams[i].bicycles+'<br>'+
				                                                                '<b>Buses: </b>'+cams[i].buses+'<br>'+
                                				                                '<b>Cars: </b>'+cams[i].cars+'<br>'+
                                                                				'<b>Motorcycles: </b>'+cams[i].motorcycles+'<br>'+
				                                                                '<b>People: </b>'+cams[i].people+'<br>'+
				                                                                '<b>Trucks: </b>'+cams[i].trucks+
                                				                           '</div>';

								var x = popup.setLatLng(e.latlng).setContent(marker_popup_content).openOn(map);
								break;
							}
						}
					});
				});
				array_markers_world_cam.push(marker);
				worldcam.addLayer(marker);
			});
			map.addLayer(worldcam);
			map.setView([50,20], 2);
		});
	}



     
       

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }


	function JsonpCallSql(url, callback){
		$.ajax({
			url: url,
			dataType: 'jsonp',
			success: function(response){ callback(response); },
			error: function(response){ callback(response); }
		});
	}



	//Aggiunta questa funzione per aggirare il problema del "Access-Control-Allow-Origin: *" 
	//da settare lato server. Questo è un workaround per gestirlo lato client senza toccare il server.
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



	//http://smartme-data.unime.it/api/action/tag_show?id=energy
	//function JsonpCallTagShow(url, tag, func) {
	function JsonpCallTagShow(url, tag, callback) {
		/*
		var data_call = $.ajax({
			url: url,
			dataType: 'jsonp',
			async: false,
			cache: true, // necessario per interrogare ckan
			data: {"id": tag},
			jsonpCallback: func
		});
		return data_call;
		*/
		$.ajax({
			url: url,
			dataType: 'jsonp',
			async: false,
			cache: true, // necessario per interrogare ckan
			data: {"id": tag},
			success: function(response){
				callback(response);
			},
			error: function(response){
				callback("ERROR"+response);
			}
		});
	}

	//http://smartme-data.unime.it/api/action/datastore_search?resource_id=6f0485a5-46dc-472f-b941-a13e2eac2bdc&limit=1&sort=Date%20desc
	function JsonpCallDatastoreSearchLast(url, package_id, resource_id, resource_name, sort, callback) {

		/*
		var data_call = $.ajax({
			url: url,
			dataType: 'jsonp',
			async: false,
			cache: true, // necessario per interrogare ckan
			data: {"resource_id": id, "limit": 1, "sort": "Date desc"}//,
			//jsonpCallback: func
		});
		//return data_call;
		callback(data_call);
		*/

		$.ajax({
			url: url,
			dataType: 'jsonp',
			async: false,
			cache: true, // necessario per interrogare ckan
			//data: {"resource_id": resource_id, "limit": 1, "sort": "Date desc"},
			data: {"resource_id": resource_id, "limit": 1, "sort": sort},
			success: function(response){
				response.result.package_id = package_id; //Ho aggiunto questo campo (id del dataset) per facilitare la ricerca in fase di creazione dei marker !!!
				response.result.resource_name = resource_name; //Ho aggiunto questo campo (nome del datastore) per facilitare la ricerca in fase di creazione dei marker !!!
				callback(response);
			},
			error: function(response){
				callback("ERROR"+response);
			}
                });

	}


        function GetSensorList(data) {
            $.each(data.result.records, function (k, v) {
                if (v.name != "_table_metadata") {
                    sensori[k] = v;
                }
            });
        }

        function GetCKAN(data) { return data; }

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
		    array_markers_potholes.push(marker);
                    potholes.addLayer(marker);
                    map.addLayer(potholes);
                } catch (err) {
                    console.log(err);
                }

            }
        }

        // variabili globali

	//PRE FIX: old external mapserver
	// -------------------------------------------------------------------------------------------------------------------------
	/*
	var roads = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> - by <b>MDSLab & Ciam</b>'
	});
	*/
	//FIXED: linked internal mapserver (smartme.io)
	var roads = L.tileLayer('http://212.189.207.177/osm_tiles/{z}/{x}/{y}.png', {
		attribution: 'Map data &copy; 2018 OpenStreetMap contributors, Tiles Courtesy of <a href="http://smartme.io/it/" '+
				'target="_blank">smartme.io</a> <img src="/img/loghi/logosmartme-verde-10.png" width=21px height:20px >'
	});
	// -------------------------------------------------------------------------------------------------------------------------

        var map = L.map('mapdiv', {
            center: [38.20523, 15.55972],
            zoom: 12,
	    scrollWheelZoom: false, //Remove scroll
            layers: roads
            });


	var array_markers_sensors = new Array();
	var array_markers_potholes = new Array();
	var array_markers_taxi = new Array();
	var array_markers_energy = new Array();
	//var array_markers_parkingMI = new Array();
	var array_markers_lightingMI = new Array();

	var array_markers_cam = new Array();
	var array_markers_infrared_cam = new Array();

	//FROM (con telecamera parcheggio Unime e parcheggio MI separati)
	//var array_markers_parkingMI = new Array();
	//var array_markers_parking_cam = new Array();

	//TO (parcheggi unificati)
	var array_markers_parking_global = new Array();
	var array_markers_world_cam = new Array();
	var array_markers_seismic = new Array();
	var array_markers_landslide = new Array();

	

	var sensors = L.markerClusterGroup({});
        var potholes = L.markerClusterGroup({});
        var energy = L.markerClusterGroup({disableClusteringAtZoom: 13});
        var taxi = L.markerClusterGroup({disableClusteringAtZoom: 9});
        var cam = L.layerGroup();
        var infraredcam = L.layerGroup();
        var distretti = L.geoJson();


	//FROM
	//var parking = L.layerGroup();
        //var parking_mi = L.layerGroup();
	//var lighting = L.layerGroup();

	//TO (con telecamera parcheggio Unime e parcheggio MI separati)
	//var parking = L.layerGroup();
	//var MI_parking = L.layerGroup();
	//var MI_lighting = L.layerGroup();

	//TO (parcheggi unificati)
	var global_parking = L.layerGroup();
	var MI_lighting = L.layerGroup();

	var worldcam = L.layerGroup();
	var seismic = L.markerClusterGroup({disableClusteringAtZoom: 13});
	var landslide = L.markerClusterGroup({disableClusteringAtZoom: 13});


        var polyline;
        var point_layer = L.layerGroup();
        var Chart = "";
        var parking_resource_ids = ['89bf03ee-89e0-437b-8ed5-e28d5a731185','d5d37bee-f2b4-47c9-ba69-0c277d0830c2'];
        var lighting_resource_ids = ['9441735c-ba70-4f9c-981b-1bd6bb8090b7'];

	var world_datastore = "b3d82bb8-5990-4b26-9569-c07688dad69a";



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
/*
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
*/
        var overlayMaps = {
            "Messina districts" : distretti,
            "SmartME Potholes": potholes,
            "SmartME Sensors" : sensors,
            //"SmartME Taxi" : taxi,		//RIATTIVARE E SISTEMARE !!!!
            "SmartME Energy" : energy,

	    //FROM
            //"SmartME Parking" : parking,
            //"SmartME Lighting" : lighting,
	    //"LiveCam" : cam

	    //TO (con telecamera parcheggio Unime e parcheggio MI separati)
	    /*
	    "SmartME Parking" : MI_parking,
	    "SmartME Lighting" : MI_lighting,
	    "LiveCam": cam,
	    "InfraredCam": infraredcam
	    "Cam": parking
	    */

	    //TO (parcheggi unificati)
	    "SmartME Parking" : global_parking,
	    "SmartME Lighting" : MI_lighting,
	    "LiveCam": cam,
	    "InfraredCam": infraredcam,
	    "WorldCam": worldcam,
            "Seismic": seismic,
	    "Landslide": landslide
        };


	map.on('overlayadd', onOverlayAdd);
	function onOverlayAdd(e){
		//alert(e.name);


		if(e.name == "Messina districts") GetMap();

		else if(e.name == "SmartME Potholes"){
			//alert(array_markers_potholes.length);
			if(array_markers_potholes.length != 0){
				for(i=0;i<array_markers_potholes.length;i++) potholes.removeLayer(array_markers_potholes[i]);
				array_markers_potholes = [];
			}
			PotHolesLoad();
		}
		else if(e.name == "SmartME Sensors") {
			//alert(array_markers_sensors.length);
			if(flag_first_load){
				flag_first_load = false;
			}
			else{
				if(array_markers_sensors.length != 0){
					for(i=0;i<array_markers_sensors.length;i++) sensors.removeLayer(array_markers_sensors[i]);
					array_markers_sensors = [];
				}
				GetSensoriConDati();
			}
		}
		//VERIFICARE !!!
		else if(e.name == "SmartME Taxi"){
			//alert(array_markers_taxi.length);
			if(array_markers_taxi.length != 0){
				for(i=0;i<array_markers_taxi.length;i++) taxi.removeLayer(array_markers_taxi[i]);
				array_markers_taxi = [];
			}
			GetTaxi();
		}
		else if(e.name == "SmartME Energy"){
			//alert(array_markers_energy.length);
			if(array_markers_energy.length != 0){
				for(i=0;i<array_markers_energy.length;i++) energy.removeLayer(array_markers_energy[i]);
				array_markers_energy = [];
			}
			GetEnergy();
		}
		else if(e.name == "SmartME Parking"){
			//FROM (con telecamera parcheggio Unime e parcheggio MI separati)
			/*
			//alert(array_markers_parkingMI.length);
			if(array_markers_parkingMI.length != 0){
				for(i=0;i<array_markers_parkingMI.length;i++) MI_parking.removeLayer(array_markers_parkingMI[i]);
				array_markers_parkingMI = [];
			}
			GetParkingMI();
			*/

			//TO (parcheggi unificati)
			//alert(array_markers_parking_global.length);
			if(array_markers_parking_global.length != 0){
				for(i=0;i<array_markers_parking_global.length;i++) global_parking.removeLayer(array_markers_parking_global[i]);
				array_markers_parking_global = [];
			}
			GetParkingMI();
			GetParkingCam();

		}
		else if(e.name == "SmartME Lighting"){
			//alert(array_markers_lightingMI.length);
			if(array_markers_lightingMI.length != 0){
				for(i=0;i<array_markers_lightingMI.length;i++) MI_lighting.removeLayer(array_markers_lightingMI[i]);
				array_markers_lightingMI = [];
			}
			GetLightingMI();
		}
		else if(e.name == "LiveCam") {

			//Camera (UniMe)
			//alert(array_markers_cam.length);
			if(array_markers_cam.length != 0){
				for(i=0;i<array_markers_cam.length;i++) cam.removeLayer(array_markers_cam[i]);
				array_markers_cam = [];
			}
			GetCam();
		}
		else if(e.name == "InfraredCam"){

			//Infrared Camera (Airport)
			//alert(array_markers_infrared_cam.length);
			if(array_markers_infrared_cam.length != 0){
				for(i=0;i<array_markers_infrared_cam.length;i++) infraredcam.removeLayer(array_markers_infrared_cam[i]);
				array_markers_infrared_cam = [];
			}
			GetInfraredCam();
		}
		//Con telecamera parcheggio Unime e parcheggio MI separati
		/*
		else if(e.name == "Cam"){

			//Camera (UniMe park)
			//alert(array_markers_parking_cam.length);
			if(array_markers_parking_cam.length != 0){
				for(i=0;i<array_markers_parking_cam.length;i++) parking.removeLayer(array_markers_parking_cam[i]);
				array_markers_parking_cam = [];
			}
			GetParkingCam();
		}
		*/
		else if(e.name == "WorldCam"){

			//World Cameras
			//alert(array_markers_world_cam.length);
			if(array_markers_world_cam.length != 0){
				for(i=0;i<array_markers_world_cam.length;i++) worldcam.removeLayer(array_markers_world_cam[i]);
				array_markers_world_cam = [];
			}
			GetWorldCam();
		}
		else if(e.name == "Seismic"){
			if(array_markers_seismic.length != 0){
				for(i=0;i<array_markers_seismic.length;i++) seismic.removeLayer(array_markers_seismic[i]);
				array_markers_seismic = [];
			}
			GetSeismicData();
		}
		else if(e.name == "Landslide"){
			if(array_markers_landslide.length != 0){
				for(i=0;i<array_markers_landslide.length;i++) landslide.removeLayer(array_markers_landslide[i]);
				array_markers_landslide = [];
			}
			GetLandslideData();
		}
	}


 
        var lcontrol = L.control.layers("",overlayMaps).addTo(map);
        // The list of packages can be found at the following URL:
		// This variable seems to enlist only the parking meters.
        //var package_url = "http://smartme-data.unime.it/api/3/action/current_package_list_with_resources";
		var package_url = "http://localhost:5000/sensors"
	var tag_show_url = "http://smartme-data.unime.it/api/action/tag_show";
	var organization_show_url = "http://smartme-data.unime.it/api/action/organization_show";  //DA CANCELLARE????
	var datastore_search_url = "http://smartme-data.unime.it/api/action/datastore_search";
	var datastore_search_sql_url = "http://smartme-data.unime.it/api/action/datastore_search_sql";


	var removed_datastores = ["seismograph-01"];


        // esecuzione prima chiamata per la generazione dell'elenco dei sensori

	//FROM (erano decommentati...)
	/*	
        GetTaxi();
        GetSensoriConDati();
        PotHolesLoad();
        GetCam();
        GetInfraredCam();
        GetEnergy();    
        GetParkingCam();
        GetParkingMI();
        GetLightingMI();
        GetMap();
	*/

	//TO
	GetSensoriConDati();
	//GetParkingMI();
	//PotHolesLoad();
	//GetEnergy();
	

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
            var infrader_cam = $($(el)[0]).children('div').hasClass('infraredcam');
            if (infrader_cam){
                console.log('caminfrared');
                setInterval(
                    function(){
                        console.log ('olo');
                        var random = Math.floor(Math.random() * Math.pow(2, 31));
                        $('#infracamera').attr('src', 'http://212.189.207.206/termo/image.jpg?r=' + random);
                    }, 5000
                )
                return true;
            }
	    
            var parking_mi = $($(el)[0]).children('div').hasClass('parking_mi');
            if (parking_mi){
                var t = getParkingInfoMI();
                $('#parking_info_mi').html(t);
                return true;
            }
            
            var lighting_mi = $($(el)[0]).children('div').hasClass('lighting_mi');
            if (lighting_mi){
                var t = getLightingInfoMI();
                $('#lighting_info_mi').html(t);
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
            
            var pack_id = el[0].getElementsByClassName('punto')[0].getAttribute("pack") || null;
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
        function prepareSqlStatement ( resId, sensor, limit) {
            sensor_field = capitalizeFirstLetter(sensor);
            // workaround per differenza di co
            var isParking = parking_resource_ids.indexOf(resId) > -1;
            var isLighting = lighting_resource_ids.indexOf(resId) > -1;
	    
            
            var time_field = "Date";
            if (sensor == 'value') sensor_field="value"; //solo per SmartEnergy!
            if(isParking) {
                time_field = "timestamp";
                sensor_field = "free";
            }
            else if(isLighting) {
                time_field = "timestamp";
                sensor_field = "system_usage";
            }
	    else if(sensor == "Xa" || sensor == "Ya" || sensor == "Za"){
		time_field = "timestamp";
		sensor_field = sensor;
	    }
	    else if(sensor == "cdX" || sensor == "cdY" || sensor == "cdZ"){
		time_field = "timestamp";
		sensor_field = sensor;
	    }
            
            var sqlStatement = '';

            sqlStatement += 'SELECT "'+ time_field +'" as x , "'+ sensor_field +'" as y';
            sqlStatement += ' from ' +'"'+resId+'" ';
            //sqlStatement += 'WHERE "Date" BETWEEN '+'\''+hourlyConfig.to_thisDate.toISOString()+'\' '+ 'AND ' +'\''+hourlyConfig.from_thisDate.toISOString()+'\' ';
            //sqlStatement += ' WHERE "'+ time_field +'" BETWEEN '+'\''+moment().add(2, 'hours').subtract(limit,'days').toISOString()+'\' '+ ' AND ' +' \''+moment().add(2, 'hours').toISOString() +'\'' ;
	    sqlStatement += ' WHERE "'+ time_field +'" BETWEEN '+'\''+moment().add(1, 'hours').subtract(limit,'days').toISOString()+'\' '+ ' AND ' +' \''+moment().add(1, 'hours').toISOString() +'\'' ;
            sqlStatement += ' ORDER BY "'+ time_field +'" ASC';

            //console.log(sqlStatement);
            return sqlStatement;

            // It returns something like this!
            // SELECT "Temperature", "Date" from "8e943f1c-75c6-4c94-a3b3-d508a549ebbc" WHERE "Date" BETWEEN '2017-02-06T09:57:00.000Z' AND '2017-02-07T09:57:00.000Z' ORDER BY "Date" DESC
        }


        function DrawGraph(url, resourceId, sensor_name,lim, sensor_unit, sensor_unit_label){
//            console.log("LOG1");
//            console.log(sensor_unit,sensor_name);
            url = url + '?sql=' + prepareSqlStatement(resourceId , sensor_name, lim);
            var chart_width = parseInt($('.modal-lg').width() -50 );
            var records = [];
            var unit_label = (typeof unit[sensor_name] === 'undefined')?unit:unit[sensor_name];
            

            // TODO: filtrare solo se state = 1 & isEnergy in PowerConsumption
//            console.log("LOG2");
//            console.log(unit, unit_label);
            try{
               //Chart.destroy()
            }catch(e){
                console.log(e);
            }

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
		options.plotOptions.series.turboThreshold = records.length;
                Chart = new Highcharts.StockChart(options);
                if (sensor_name == "noise" || sensor_name =="Noise")
                    addNoise(Chart);
            });
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
                            //turboThreshold:5000//set it to a larger threshold, it is by default to 1000
                        }
                    }
                  };            
        }


	function DrawMultilineGraph(orig_url, resourceId, array_axis, lim, sensor_unit) {

		var url = "";
		var array_promise = [];
		var chart_width = parseInt($('.modal-lg').width() -50 );
		var unit_label = sensor_unit;

		var dec_pos = 4;
		if(sensor_unit == "cos dir") dec_pos = 6;
		//var treshold =


		var seriesOptions = [],
			axisOptions = [],
			colors = Highcharts.getOptions().colors,
			containerHeight = $('.modal-lg').height(),
			numAxes = array_axis.length,
			// percentage of height left out for spacing the 3 y-axes
			axisSpacingPercent = 5,
			// percentage of height occupied by each y-axis
			axisHeightPercent = (100 - (numAxes - 1) * axisSpacingPercent) / numAxes;

		for (var i = 0; i < array_axis.length; i++) {
			url = orig_url + '?sql=' + prepareSqlStatement(resourceId, array_axis[i], lim);
			//console.log(url);
			array_promise.push(new Promise(function (resolve) {
				JsonpCallSql(url, resolve);
			}));
		}
		Promise.all(array_promise).then(values => {
			for(var j=0; j<values.length; j++){
				//console.log(values[j]);
				$.each(values[j].result.records, function (k, v) {
					v.x = new Date(v.x);
					v.y = parseFloat(v.y);
				});
				records = values[j].result.records;
				//console.log(records);

				//options.series.push({
				seriesOptions.push({
					"name": array_axis[j],
					"data": records,
					"color": colors[j],
					"type": "line",
					"yAxis": j
				});

				axisOptions.push({
					title: { text: sensor_unit },
					// settings for multiple panes in the chart
					height: '' + axisHeightPercent + '%',
					top: '' + (j * (axisHeightPercent + axisSpacingPercent)) + '%',
					offset: false,
					lineWidth: 1
				});

				if(j==values.length-1){
					//console.log(options.series);
					options.plotOptions.series.turboThreshold = records.length;
					Chart = new Highcharts.StockChart(options);
				}
			}
		});
		var options =  {
			chart: {
				type: 'line',
				renderTo: "hicharts",
				//height: '320',
				height: '640',
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
			/*
			yAxis: {
				title: {
					text: 'measure unit:' + unit_label
				}
			},
			*/
			yAxis: axisOptions,
			tooltip: {
				//valueDecimals: 4,
				valueDecimals: dec_pos,
				valueSuffix: " " + unit_label
			},
			//series: [],
			series: seriesOptions,
			plotOptions:{
				series:{
					showInNavigator: true
					//turboThreshold: threshold //set it to a larger threshold, it is by default to 1000
				}
			}
		};
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

            //console.log(L._layer);

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
            //isEnergy = $(this).attr('sensor_type') || ""; // Solo per SmartEnergy
	    sensor_type = $(this).attr('sensor_type') || "";
             
            unit  = $(this).attr('sensor_unit') || <?=json_encode($unit)?>;
             
            var unit_label = (typeof unit[sensor_name] === 'undefined')?unit:unit[sensor_name];
             
            $("#sensor_name").html(capitalizeFirstLetter(sensor_name));
            $("#measure_unit").html(unit_label);

            $('#download_csv').attr('href', 'http://smartme-data.unime.it/datastore/dump/' + id_sensor);
       	    $('#open_data_link').attr('href', 'http://smartme-data.unime.it/dataset/' + pack_name + '/resource/' + id_sensor);

            // url = 'jsonp_call.php?id=' + id_sensor+ '&limit=<?= $limit ?>&sensor=' + sensor_name;
            url = 'http://smartme-data.unime.it/api/action/datastore_search_sql';

            //if(isEnergy) {// solo per Energy
	    if(sensor_type){
                if(sensor_type == "energy"){
	                sensor_name = "value";
        	        if  ($(this).attr('sensor-name').startsWith('Power')) {
                	    unit = "W";
	                    unit_label = "Watt";
                    
        	        } else if ($(this).attr('sensor-name').startsWith('Brightness')) {
	                    unit = "uW/cm2";
        	            unit_label = "uWatt/cm2";
                    
	                } else if ($(this).attr('sensor-name').startsWith('Temperature')) {
        	            unit = "C";
                	    unit_label = "Celsius";
	                }
			DrawGraph(url,id_sensor,sensor_name, 1, unit);
		}
		else if (sensor_type == "seismic"){
			var array_axis = ["Xa", "Ya", "Za"];
	                unit = "m/s^2";
        	        unit_label = "m/s^2";
			DrawMultilineGraph(url, id_sensor, array_axis, 1, unit);
                }
		else if (sensor_type == "landslide"){
			var array_cosdir = ["cdX", "cdY", "cdZ"];
			unit = "cos dir";
			unit_label = "cos dir";
			DrawMultilineGraph(url, id_sensor, array_cosdir, 1, unit);
		}
            }
	    else
	            DrawGraph(url, id_sensor, sensor_name, 1, unit);
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

	    //console.log("LIMIT: "+limit);

	    if(sensor_name == "seismograph"){
		var array_axis = ["Xa", "Ya", "Za"];
		//DrawMultilineGraph(url, id_sensor, array_axis, 1, unit);
		DrawMultilineGraph(url, id_sensor, array_axis, type_limit[limit], unit);
	    }
	    else if(sensor_name == "inclinometer"){
		var array_cosdir = ["cdX", "cdY", "cdZ"];
		DrawMultilineGraph(url, id_sensor, array_cosdir, type_limit[limit], unit);
	    }
	    else
	        DrawGraph(url, id_sensor, sensor_name, type_limit[limit]);
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



    function compare_dates(a, b){
	//ESEMPIO:
	//var a = "2017-09-15T19:13:55.000000";
	//var b = "2017-09-15T19:14:55.000000";

	var date_a = new Date(a);
	var date_b = new Date(b);

	//console.log(date_a+ " "+date_b);

	if(date_a >= date_b){
		//console.log("A > B");
		return date_a;
	}
	else{
		//console.log("A < B");
		return date_b;
	}
    }


    function adapt_date(date){
	var data = new Date(date);
	months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];


	var d = new Date().getTimezoneOffset();
	var timezone = d / -60;
	//console.log(timezone);

	var m = data.getMonth();
	var d = data.getDate();

	var hour = data.getHours() + timezone; //Al momento viene salvato su CKAN in UTC quindi dobbiamo aggiungere la differenza con la timezone del browser!
	var min = data.getMinutes();

	if(hour<10) hour = "0"+hour;
	if(min<10)  min = "0"+min;
	return months[m]+", "+d+" "+hour+":"+min;
    }

</script>


</body>
</html>
