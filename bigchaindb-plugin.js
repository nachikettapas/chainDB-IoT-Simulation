//pluginjsonschema = {"name": "BigchainDB"}
exports.main = function (arguments){ 

    var name = arguments.name;
  
	var LIGHTNINGROD_HOME = process.env.LIGHTNINGROD_HOME;
	var PLG_NAME = "Bigchaindb";
	var timer = arguments.timer;
	var m_authid = arguments.m_authid;
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
	

	var bigchaindbAddress = "http://172.17.5.188:5000";

    api = require(LIGHTNINGROD_HOME + '/modules/plugins-manager/plugin-apis');
	logger = api.getLogger();
	position = api.getPosition();


    logger.info("BigchainDB plugin initialising...");
  
    setInterval(function(){ 
	logger.info('Hello '+name+'!'); 

	var sensor_list = ['temp', 'lux', 'hum', 'noise', 'bar'];

	


	requestify.get(bigchaindbAddress).then( function(response) {

		var data = response.getBody();

		logger.info(data);

	});
      
    }, 3000); 
};