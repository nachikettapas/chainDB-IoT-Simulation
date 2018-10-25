var requestify = require('requestify');

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
    console.log('Data generated\n', data);
    return data;
}


// requestify.post(
//     'http://212.189.207.119/bdb/sensors/93c39ba9-74cf-4461-b60a-9a206c7fc416',generateRandomData('93c39ba9-74cf-4461-b60a-9a206c7fc416'))
//     .then(function(response) {
//         console.log(response.getBody());
//     });
generateRandomData('93c39ba9-74cf-4461-b60a-9a206c7fc416');
