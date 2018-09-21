//pluginjsonschema = {"name": "BigchainDB"}
exports.main = function (arguments){ 

    var name = arguments.name;
  
	var LIGHTNINGROD_HOME = process.env.LIGHTNINGROD_HOME;
	var PLG_NAME = "Bigchaindb";
	var timer = arguments.timer;
	var m_authid = arguments.m_authid;
	var ckan_addr = 'smartme-data.unime.it';
	var ckan_host = 'http://'+ckan_addr;
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
	


	var http = require('http');
	var requestify = require('requestify');
	var linino = require('ideino-linino-lib');
	
	board = new linino.Board();
	

	var bigchaindbAddress = "http://212.189.207.119/bdb";

    api = require(LIGHTNINGROD_HOME + '/modules/plugins-manager/plugin-apis');
	logger = api.getLogger();
	position = api.getPosition();
	board_id = api.getBoardId();
	logger.info("Board ID is:" + board);	


	logger.info("BigchainDB plugin initialising...");
	
	getBoardSensors = function(id){

		requestify.get(ckan_host + '/api/rest/dataset/'+id).then( function(response) {
		logger.info("[PLG-"+PLG_NAME+"] - Board Sensor Data recovered:");

			var data = response.getBody();

			for(var resource=0; resource < data.resources.length; resource++) {

				(function(resource) {
	
					if (data.resources[resource].name == "temperature"){
	
						temp_resourceid = data.resources[resource].id;
						logger.info("[PLG-"+PLG_NAME+"] --> TEMP R_id: "+temp_resourceid);
	
					} else if (data.resources[resource].name == "brightness"){
	
						lux_resourceid = data.resources[resource].id;
						logger.info("[PLG-"+PLG_NAME+"] --> LUX R_id: "+lux_resourceid);
	
					} else if (data.resources[resource].name == "humidity"){
	
						hum_resourceid = data.resources[resource].id;
						logger.info("[PLG-"+PLG_NAME+"] --> HUM R_id: "+hum_resourceid);
	
	
					} else if (data.resources[resource].name == "gas"){
	
						gas_resourceid = data.resources[resource].id;
						logger.info("[PLG-"+PLG_NAME+"] --> GAS R_id: "+gas_resourceid);
	
					} else if (data.resources[resource].name == "pressure"){
	
						bar_resourceid = data.resources[resource].id;
						logger.info("[PLG-"+PLG_NAME+"] --> BAR R_id: "+bar_resourceid);
	
	
					} else if (data.resources[resource].name == "noise"){
	
						noise_resourceid = data.resources[resource].id;
						logger.info("[PLG-"+PLG_NAME+"] --> NOISE R_id: "+noise_resourceid);
	
	
					}
	
				})(resource);  // end of the function(i)
	
			}


		});

	};
    generateData = function(sensor_list) {
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
		var record = [];
		
		for(var i = 0; i < sensor_list.length; i++) {
			(function(i) {

				try {

					if (sensor_list[i] == "temp" && temp_conf.enabled == "true") {
						record.push({
							resource_id : temp_resourceid,
							Date: timestamp,
							Temperature: temp,
							Altitude: position.altitude,
							Latitude: position.latitude,
							Longitude: position.longitude,
							entity: 'reading',
							type : 'Temperature'

						});
						logger.info("Temperature is:" + temp);
					}
					else if (sensor_list[i] == "lux" && lux_conf.enabled == "true") {
						record.push({
							resource_id : lux_resourceid,							
							Date: timestamp,
							Brightness: ldr,
							Altitude: position.altitude,
							Latitude: position.latitude,
							Longitude: position.longitude,
							entity: 'reading',
							type : 'Brightness'
						});
							logger.info("Brightness: " + ldr + " (lux)");
					}
					else if (sensor_list[i] == "hum" && hum_conf.enabled == "true") {
						record.push({
							resource_id : hum_resourceid,							
							Date: timestamp,
							Humidity: relativeHumidity,
							Altitude: position.altitude,
							Latitude: position.latitude,
							Longitude: position.longitude,
							entity: 'reading',
							type : 'Humidity'
						});
							logger.info("Humidity " + relativeHumidity + " percent (with " + temp + " °C)");
					}
					else if (sensor_list[i] == "noise" && noise_conf.enabled == "true") {
						record.push({
							resource_id : noise_resourceid,							
							Date: timestamp,
							Noise: amplitude,
							Altitude: position.altitude,
							Latitude: position.latitude,
							Longitude: position.longitude,
							entity: 'reading',
							type : 'Noise'
						});
						logger.info("NOISE amplitude: " + amplitude);
						
					}
					else if (sensor_list[i] == "bar" && bar_conf.enabled == "true") {
						record.push({
							resource_id : bar_resourceid,							
							Date: timestamp,
							Pressure: pressure,
							Altitude: position.altitude,
							Latitude: position.latitude,
							Longitude: position.longitude,
							entity: 'reading',
							type : 'Pressure'
						});
						logger.info("Pressure: " + pressure + " hPa");
					}
					else {
						logger.warn("[PLG-"+PLG_NAME+"] - NO SENSORS!\n\n");
					}
					requestify.post('http://212.189.207.119/bdb/sensors/93c39ba9-74cf-4461-b60a-9a206c7fc416', record)
					.then(function(response) {
					// Get the response body (JSON parsed or jQuery object for XMLs)
					logger.info(response.getBody());
				});


				}catch (e) {

					logger.error("[PLG-"+PLG_NAME+"] - Error sending data ("+sensor_list[i]+") to CKAN: ", e);

				}

			})(i);
		}


	};
	var sensor_list = ['temp', 'lux', 'hum', 'noise', 'bar'];
    getBoardSensors(board_id);
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
				// logger.info('Hello '+name+'!');
				// generateData(sensor_list);
			
			
				requestify.get(bigchaindbAddress).then( function(response) {
			
					var data = response.getBody();
			
					logger.info(data);
			
				});
				generateData(sensor_list); 

			}, 600000);
			

		}

	});
};