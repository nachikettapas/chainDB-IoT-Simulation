//pluginjsonschema = {"name": "BigchainDB"}
exports.main = function (arguments){ 

    var name = arguments.name;
  
	var LIGHTNINGROD_HOME = process.env.LIGHTNINGROD_HOME;
	var http = require('http');
	var requestify = require('requestify');
    api = require(LIGHTNINGROD_HOME + '/modules/plugins-manager/plugin-apis');
    logger = api.getLogger();

    logger.info("BigchainDB plugin starting...");
  
    setInterval(function(){ 
	logger.info('Hello '+name+'!'); 
	requestify.get('http://172.17.5.188:8000').then( function(response) {

		var data = response.getBody();

		logger.info(data);

	});
      
    }, 3000); 
};