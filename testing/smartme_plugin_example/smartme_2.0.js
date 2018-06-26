exports.main = function (arguments){

    var LIGHTNINGROD_HOME = process.env.LIGHTNINGROD_HOME;

    var timer = arguments.timer;
    var m_authid = arguments.m_authid;
    var ckan_enabled = arguments.ckan_enabled;

	var requestify = require('requestify');
	var http = require('http');
	var ckan_addr = 'smartme-data.unime.it';
	var ckan_host = 'http://'+ckan_addr;

	PLG_NAME = "SMARTME";

    temp_conf = arguments.temp_sensor;
    lux_conf = arguments.lux_sensor;
    hum_conf = arguments.hum_sensor;
    gas_conf = arguments.gas_sensor;
    noise_conf = arguments.noise_sensor;
    bar_conf = arguments.bar_sensor;
  
    pin_temp = temp_conf.pin;
    pin_lux = lux_conf.pin;
    pin_hum = hum_conf.pin;
    pin_gas = gas_conf.pin;
    pin_noise = noise_conf.pin;

    temp_resourceid = null;
    lux_resourceid = null;
    hum_resourceid = null;
    gas_resourceid = null;
    noise_resourceid = null;
    bar_resourceid = null;
    
    first = true;
    amplitudes_sum = 0;
    amplitudes_count = 0;
    amplitude = 0;
    vect = [];
    samples_number = 500;

    api = require(LIGHTNINGROD_HOME + '/modules/plugins-manager/plugin-apis');
    position = api.getPosition();
    
    logger = api.getLogger();

    linino = require('ideino-linino-lib');
    board = new linino.Board();


	getSendData = function(sensor_list){

		if(lux_conf.enabled == "true"){

			/*FOR LUX SENSOR*/
			var lux_temp = board.analogRead(pin_lux);
			var ldr = (2500/(5-lux_temp*0.004887)-500)/3.3;

		}

		if(temp_conf.enabled == "true"){
			/*FOR TEMP SENSOR*/
			var ADCres = 1023.0;
			var Beta = 3950;
			var Kelvin = 273.15;
			var Rb = 10000;
			var Ginf = 120.6685;
			var temp_volt = board.analogRead(pin_temp);
			var Rthermistor = Rb * (ADCres / temp_volt - 1);
			var _temperatureC = Beta / (Math.log( Rthermistor * Ginf )) ;
			var temp = _temperatureC - Kelvin;
		}

		if(hum_conf.enabled == "true"){
			/*FOR HUM SENSOR*/
			var degreesCelsius = temp;
			var supplyVolt = 4.64;
			var HIH4030_Value = board.analogRead(pin_hum);
			var voltage = HIH4030_Value/1023. * supplyVolt;
			var sensorRH = 161.0 * voltage / supplyVolt - 25.8;
			var relativeHumidity = sensorRH / (1.0546 - 0.0026 * degreesCelsius);
		}

		if(noise_conf.enabled == "true"){

			/*FOR NOISE SENSOR*/
			if(amplitudes_count == 0){

				if (first == true){

					vect = [];

					for (var x = 0; x < samples_number; x++) {
						read = board.analogRead(pin_noise);
						vect.push(read);
					}

					sorted_vect = vect.sort();
					//console.log("VECT " + sorted_vect)
					minimum = sorted_vect[25];
					maximum = sorted_vect[samples_number - 26];
					//console.log("min-max " + minimum + " " + maximum)
					amplitude = maximum - minimum;
					amplitudes_sum = amplitudes_sum + amplitude;
					amplitudes_count = amplitudes_count + 1;

					first = false;

				}

				//amplitude = 0

			}
			else
				amplitude = amplitudes_sum / amplitudes_count;

			console.log("amplitudes_sum " + amplitudes_sum)
			console.log("amplitudes_count " + amplitudes_count)
			amplitudes_sum = 0;
			amplitudes_count = 0;

		}

		if(bar_conf.enabled == "true"){
			/*FOR BAR SENSOR*/
			var in_pressure_raw = board.i2cRead('BAR', 'in_pressure_raw');
			var pressure = in_pressure_raw*0.00025*10;
		}


		var timestamp = api.getLocalTime();


		for(var i = 0; i < sensor_list.length; i++) {
			(function(i) {

				try {

					if (sensor_list[i] == "temp" && temp_conf.enabled == "true") {
						var record = [];
						record.push({
							Date: timestamp,
							Temperature: temp,
							Altitude: position.altitude,
							Latitude: position.latitude,
							Longitude: position.longitude
						});
						if (ckan_enabled == "true") {
							sendToCKAN(m_authid, temp_resourceid, record, function (payloadJSON) {
								console.log("\n\nTemperature " + temp + " °C");
							});
						} else {
							console.log("\n\nTemperature " + temp + " °C");
						}
					}
					else if (sensor_list[i] == "lux" && lux_conf.enabled == "true") {
						var record = [];
						record.push({
							Date: timestamp,
							Brightness: ldr,
							Altitude: position.altitude,
							Latitude: position.latitude,
							Longitude: position.longitude
						});
						if (ckan_enabled == "true")
							sendToCKAN(m_authid, lux_resourceid, record, function (payloadJSON) {
								console.log("Brightness: " + ldr + " (lux)");
							});
						else
							console.log("Brightness: " + ldr + " (lux)");
					}
					else if (sensor_list[i] == "hum" && hum_conf.enabled == "true") {
						var record = [];
						record.push({
							Date: timestamp,
							Humidity: relativeHumidity,
							Altitude: position.altitude,
							Latitude: position.latitude,
							Longitude: position.longitude
						});
						if (ckan_enabled == "true")
							sendToCKAN(m_authid, hum_resourceid, record, function (payloadJSON) {
								console.log("Humidity " + relativeHumidity + " percent (with " + temp + " °C)");
							});
						else
							console.log("Humidity " + relativeHumidity + " percent (with " + temp + " °C)");
					}
					else if (sensor_list[i] == "noise" && noise_conf.enabled == "true") {
						var record = [];
						record.push({
							Date: timestamp,
							Noise: amplitude,
							Altitude: position.altitude,
							Latitude: position.latitude,
							Longitude: position.longitude
						});
						if (ckan_enabled == "true") {
							sendToCKAN(m_authid, noise_resourceid, record, function (payloadJSON) {
								console.log("NOISE amplitude: " + amplitude);
							});
						}
						else {
							console.log("NOISE amplitude: " + amplitude);
						}
					}
					else if (sensor_list[i] == "bar" && bar_conf.enabled == "true") {
						var record = [];
						record.push({
							Date: timestamp,
							Pressure: pressure,
							Altitude: position.altitude,
							Latitude: position.latitude,
							Longitude: position.longitude
						});
						if (ckan_enabled == "true")
							sendToCKAN(m_authid, bar_resourceid, record, function (payloadJSON) {
								console.log("Pressure: " + pressure + " hPa");
							});
						else
							console.log("Pressure: " + pressure + " hPa");
					}
					else {
						logger.warn("[PLG-"+PLG_NAME+"] - NO SENSORS!\n\n");
					}

				}catch (e) {

					logger.error("[PLG-"+PLG_NAME+"] - Error sending data ("+sensor_list[i]+") to CKAN: ", e);

				}

			})(i);
		}

	};


	sendToCKAN = function (m_authid, m_resourceid, record, callback){

		var payload = {
			resource_id : m_resourceid,
			method: 'insert',
			records : record
		};

		var payloadJSON = JSON.stringify(payload);

		var header = {
			'Content-Type': "application/json",
			'Authorization' : m_authid,
			'Content-Length': Buffer.byteLength(payloadJSON)
		};

		var options = {
			host: ckan_addr,
			port: 80,
			path: '/api/3/action/datastore_upsert',
			method: 'POST',
			headers: header
		};


		var req = http.request(options, function(res) {

			res.setEncoding('utf-8');

			var responseString = '';

			res.on('data', function(data) {
				console.log('On data:' + data);
			});

			res.on('end', function() {});

		});

		req.on('error', function(e) {
			console.log('On Error:' + e);
		});

		req.write(payloadJSON);

		req.end();

		callback(payloadJSON);

	};


	getCKANdataset = function(id, callback){

		requestify.get(ckan_host + '/api/rest/dataset/'+id).then( function(response) {

			var dataCKAN = response.getBody();

			callback(dataCKAN);

		});

	};

	logger.info("[PLG-"+PLG_NAME+"] - SmartME plugin starting...");

	getCKANdataset(api.getBoardId(), function(ckan_result){

		console.log("[PLG-"+PLG_NAME+"] - RESOURCES: \n" + JSON.stringify(ckan_result,null,"\t"));

		logger.info("[PLG-"+PLG_NAME+"] - CKAN Data recovered:");

		for(var resource=0; resource < ckan_result.resources.length; resource++) {

			(function(resource) {

				if (ckan_result.resources[resource].name == "temperature"){

					temp_resourceid = ckan_result.resources[resource].id;
					logger.info("[PLG-"+PLG_NAME+"] --> TEMP R_id: "+temp_resourceid);

				} else if (ckan_result.resources[resource].name == "brightness"){

					lux_resourceid = ckan_result.resources[resource].id;
					logger.info("[PLG-"+PLG_NAME+"] --> LUX R_id: "+lux_resourceid);

				} else if (ckan_result.resources[resource].name == "humidity"){

					hum_resourceid = ckan_result.resources[resource].id;
					logger.info("[PLG-"+PLG_NAME+"] --> HUM R_id: "+hum_resourceid);


				} else if (ckan_result.resources[resource].name == "gas"){

					gas_resourceid = ckan_result.resources[resource].id;
					logger.info("[PLG-"+PLG_NAME+"] --> GAS R_id: "+gas_resourceid);

				} else if (ckan_result.resources[resource].name == "pressure"){

					bar_resourceid = ckan_result.resources[resource].id;
					logger.info("[PLG-"+PLG_NAME+"] --> BAR R_id: "+bar_resourceid);


				} else if (ckan_result.resources[resource].name == "noise"){

					noise_resourceid = ckan_result.resources[resource].id;
					logger.info("[PLG-"+PLG_NAME+"] --> NOISE R_id: "+noise_resourceid);


				}

			})(resource);  // end of the function(i)

		}


		logger.info("[PLG-"+PLG_NAME+"] --> SmartME plugin started!");


		if (bar_conf.enabled == "true"){
			/*FOR BAR SENSOR*/
			board.addI2c('BAR', 'mpl3115', '0x60', 0);
		}

		var sensor_list = ['temp', 'lux', 'hum', 'noise', 'bar'];



		board.connect(function() {


			if (noise_conf.enabled == "true") {

				setInterval(function () {

					vect = [];

					for (var x = 0; x < samples_number; x++) {
						read = board.analogRead(pin_noise);
						vect.push(read);
					}

					sorted_vect = vect.sort();
					//console.log("VECT " + sorted_vect)
					minimum = sorted_vect[25];
					maximum = sorted_vect[samples_number - 26];
					//console.log("min-max " + minimum + " " + maximum)
					amplitude = maximum - minimum;
					amplitudes_sum = amplitudes_sum + amplitude;
					amplitudes_count = amplitudes_count + 1;
					//console.log("AMPLITUDE SUM: " + amplitudes_sum)


				}, 5000);

			}

			getSendData(sensor_list);  //For the first samples

			setInterval(function(){

				getSendData(sensor_list);
				

			},timer);

		});

	});
	
	


	
	
	
	
	
	
};
console.log('hi');


