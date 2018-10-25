
var requestify = require('requestify');
var parseArgs = require('minimist');
var syncRequest = require('sync-request');

var argv = parseArgs(process.argv.slice(2));
console.log(argv);
function generateRandomData(resource_id){
    data = []
    data.push({
        Date: new Date(),
        Temperature: Math.floor(Math.random() * Math.floor(40)),
        Altitude: 19,
        Latitude: 38.25947,
        Longitude: 15.59541,
        entity: 'reading',
        type: 'Temperature',
        resource_id: resource_id        
    });
    data.push({
        Date: new Date(),
        Brightness: Math.floor(Math.random() * Math.floor(300)),
        Altitude: 19,
        Latitude: 38.25947,
        Longitude: 15.59541,
        entity: 'reading',
        type: 'Brightness',
        resource_id: resource_id        
    });
    data.push({
        Date: new Date(),
        Hummidity: Math.floor(Math.random() * Math.floor(100)),
        Altitude: 19,
        Latitude: 38.25947,
        Longitude: 15.59541,
        entity: 'reading',
        type: 'Humidity',
        resource_id: resource_id
    });
    data.push({
        Date: new Date(),
        Noise: Math.floor(Math.random() * Math.floor(60)),
        Altitude: 19,
        Latitude: 38.25947,
        Longitude: 15.59541,
        entity: 'reading',
        type: 'Noise',
        resource_id: resource_id        
    });
    data.push({
        Date: new Date(),
        Pressure: Math.floor(Math.random() * Math.floor(1020)),
        Altitude: 19,
        Latitude: 38.25947,
        Longitude: 15.59541,
        entity: 'reading',
        type: 'Pressure',
        resource_id: resource_id
    });
    // console.log('Data generated\n', data);
    return data;
}

function sendSyncData(data) {
    try{
    var result = syncRequest('POST', 'http://212.189.207.149/bdb/sensors/93c39ba9-74cf-4461-b60a-9a206c7fc416', {json:data, timeout:3000});
    console.log(result);
    }
    catch(err){
        console.log('err');
    }
}

async function sendAsyncData(data){
    let result = await requestify.post(
        'http://212.189.207.149/bdb/sensors/93c39ba9-74cf-4461-b60a-9a206c7fc416',data);
    console.log(result);
}



setInterval(function(){
        for(i=0;i<argv.devices;i++){
            data = generateRandomData('93c39ba9-74cf-4461-b60a-9a206c7fc415');
            // console.log('===========\n==============\n');
            if(argv.simultaneous=='true'){ 
                console.log('mode:async',i);
                sendAsyncData(data);
            }
            else {
                console.log('mode:sync',i);
                sendSyncData(data);
            }
        }
   
}, argv.interval*1000);
