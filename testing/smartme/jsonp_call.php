<?php
require 'function.php';
header("Access-Control-Allow-Origin: *");
$id_resource = (isset($_REQUEST["id"])) ? $_REQUEST["id"] : 0;

$id_board = (isset($_REQUEST["pack_name"])) ? $_REQUEST["pack_name"] : 0;
$limit = (isset($_REQUEST["limit"])) ? $_REQUEST["limit"] : 145; //145 sono 24 ore di campionamento.
$sensor_name = (isset($_REQUEST["sensor"])) ? $_REQUEST["sensor"] : null; //145 sono 24 ore di campionamento.
$GeoJSON = (isset($_REQUEST["GeoJSON"])) ? $_REQUEST["GeoJSON"] : null;
$taxi = (isset($_REQUEST["taxi"])) ? $_REQUEST["taxi"] : null;
$cam = (isset($_GET['cam'])) ? $_GET['cam'] : null;
$energy = (isset($_GET['energy_id'])) ? $_GET['energy_id'] : null;

$parking = (isset($_GET['parking'])) ? $_GET['parking'] : null;

$parking_mi = (isset($_GET['parking_mi'])) ? $_GET['parking_mi'] : null;

$lighting_mi = (isset($_GET['lighting_mi'])) ? $_GET['lighting_mi'] : null;
//
if($cam){
    $cam_url = "http://212.189.207.225/mjpg/video.mjpg";
    return get_stream($cam_url,8282);
    return true;
}

if($energy){
    echo GetEnergy($energy,$limit);
    return true;
}

$holes = (isset($_REQUEST["potholes"])) ? 1 : 0;
header('Content-Type: application/json');
if($holes) {
    echo GetHoles();
    return true;
}

if($parking){
    echo GetParking();
    return true;
}

if($parking_mi){
    echo GetParkingMI();
    return true;
}

if($lighting_mi){
    echo GetLightingMI();
    return true;
}

if($taxi){
    echo GetTaxi();
    return true;
}

if ($id_board) { // o sono taxi 
    if ($sensor_name == "undefined"){
        echo GetTrack($id_board,$limit,$GeoJSON);
    } else { // o sono sensori
        echo json_encode(GetLastSample($id_board));
    }
    return true;
}

if($id_resource){ // è un sensore
    echo GetResource($id_resource,$limit,$sensor_name);
    return true;

}

function GetHoles()
{
    //$url = 'code3.unime.it/pothole/indexJSONtimestamp.jsp'; // versione con timestamp
    $url = 'code3.unime.it/pothole/indexJSON.jsp';
    $url = 'pothole.unime.it/pothole/indexJSON.jsp'; 
    //$url = 'http://192.167.100.175/pothole/indexJSONtimestamp.jsp';
    $data = call_api($url, 8080);

    $result = array();
    // funzione per preparare il json
    if($data){
        foreach ($data as $record) {
            if ($record->N > 2){
                array_push($result, [
                    "id" => $record->Id,
                    "lat" => $record->Latitude,
                    "lon"=>$record->Longitude,
                    "num"=>$record->N,
                    "address"=>$record->Address,
                    "minMeanAcc"=>$record->minMeanAcc,
                    "maxMeanAcc"=>$record->maxMeanAcc,
                    "dob"=>$record->dob,
                    "dlu"=>$record->dlu
                ]);
            }

        }
    } else {
        echo "{\"response\" : \"Dati non prelevati.\"}";
        return false;
    }

    try {

        if ($data2 = json_encode($result)) {
            return $data2;
        } else {
            $data2 = json_encode(utf8ize($result));
            return $data2;
        }
    } catch(Exception $e){
        return $e . "\n<br>";
    }
}

// ritorna l'ultima misura (Live) di ogni sensore della board.
function GetLastSample($id_board,$lim=1)
{
    // mi richiamo la board
    $pack_url = 'http://smartme-data.unime.it/api/action/package_show?id=' . $id_board;
    $data = call_api($pack_url);
    $result = array();
    $unit = array(
        "Temperature" => "&#8451",
        "Brightness" => "Lux",
        "Humidity" => "%",
        "Relativehumidity" => "%",
        "Pressure" => "hPa",
        "Gas" => "ppm",
        "Noise" => "Amp",
        "Accelerometer" => "M/s^2",
        "Proximity" => "cm",
        "Light" => "Lux",
        "Linearacceleration" => "M/s^2",
        "Magnetometer" => "uT",
        "Gravity" => "m/s^2",
        "Gyroscope" => "&deg;",
        "Rotationvector" => "&deg;",
        "Magneticfield" => "uT",
        "Speed" => "Km/h"
    );

    foreach ($data->result->resources as $record) {
        $name = $record->name;
        if (!($name == "sensors")) {
            $sensor_id = $record->id;
            $Name = ucfirst($name);
            $sensor_url = 'http://smartme-data.unime.it/api/action/datastore_search?resource_id=' . $sensor_id . '&limit='. $lim .'&sort=Date%20desc';

            $data2 = call_api($sensor_url);

            if (count($data2->result->records)) {
                foreach( $data2->result->records as $r){
                    $sample_date = $r->Date;
                    $lat = $r->Latitude;
                    $long = $r->Longitude;
                    if(isset($r->{$Name})){

                        if($Name=="Speed") {
                            $sample_value = round($r->{$Name} * 3.6, 2);
                        } else {
                            $sample_value = round($r->{$Name}, 2);
                        }

                    }

                    array_push($result, ["name" => $Name, "id" => $sensor_id, "pack_id" => $id_board, "date" => date('M j, H:i', strtotime($sample_date)), "value" => $sample_value . " " . $unit[$Name], "Latitude"=>$lat, "Longitude"=>$long]);
                }


           }
        }
    }
    return $result;
}

// ritorna il JSON di ogni
function GetResource($id_resource,$limit,$sensor_name)
{
    $disabled_sensors = array( "SatL1", "SatC2", "SatC1", "SatR1");
    if ( in_array($sensor_name, $disabled_sensors)){ return "[]";};

    $limit = (is_numeric($limit))?$limit:4500;

    $url = 'http://smartme-data.unime.it/api/action/datastore_search?resource_id=' . $id_resource . '&limit='. $limit . "&sort=Date%20desc";
   //$url = 'http://smartme-data.unime.it/api/action/datastore_search_sql';

    $data2 = call_api($url);

    $result = array();

    $Name = ucfirst($sensor_name);

    $unit = array(
        "Temperature" => "&#8451",
        "Brightness" => "Lux",
        "Humidity" => "%",
        "Relativehumidity" => "%",
        "Pressure" => "hPa",
        "Gas" => "ppm",
        "Noise" => "Amp",
        "Accelerometer" => "M/s^2",
        "Proximity" => "cm",
        "Light" => "Lux",
        "Linearacceleration" => "M/s^2",
        "Magnetometer" => "uT",
        "Gravity" => "m/s^2",
        "Gyroscope" => "&deg;",
        "Rotationvector" => "&deg;",
        "Magneticfield" => "uT",
        "Speed" => "Km/h"
    );

    try{

         foreach ($data2->result->records as $record) {
             $lng= $record->Longitude;
             $lat = $record->Latitude;
             $val = $record->{$Name}. " " . $unit[$Name];

             array_push($result, ["id" => $record->_id, "date" => $record->Date, "value" => $val , "Latitude" =>  $lat, "Longitude"=>$lng]);
         }

    }catch (Exception $e){
        echo $e;
    }
   //  record_sort($result, "id", true);
    return json_encode($result);
}


// ritorna il JSON di ogni
function GetEnergy($id_resource,$limit)
{

    $limit = (is_numeric($limit))?$limit:4500;

    $url = 'http://smartme-data.unime.it/api/action/datastore_search?resource_id=' . $id_resource . '&limit='. $limit . "&sort=Date%20desc";
   //$url = 'http://smartme-data.unime.it/api/action/datastore_search_sql';

    $data2 = call_api($url);

    $result = array();

    try{
            //var_dump($data2->result->records);

         foreach ($data2->result->records as $record) {
             $lng = +$record->Longitude;
             $lat = +$record->Latitude;
             
             $unit = $record->Unit;
             $val = $record->value;
            
             array_push($result, ["id" => $record->_id, "date" => $record->Date, "value" => +$val , "Latitude" =>  $lat, "Longitude"=>$lng, "Unit"=>$unit]);
         }

    }catch (Exception $e){
        echo $e;
    }
   //  record_sort($result, "id", true);
    return json_encode($result);
}


function GetParking(){
    $xml_url ="http://psmdmi.parksmart.it:9012/css/cam1.svg";
    $xml_data = get_link($xml_url);
    $oXML = new SimpleXMLElement($xml_data);

    $free =0;
    $busy =0;
    $lots = [];
    //print_r($oXML);
    $i=0;
    foreach($oXML as $oEntry){
       //echo (key($oEntry));
       foreach($oEntry->attributes() as $key=>$value)
        {
            if ($key == "style")
                if($value == "fill: red;"){
                    $busy ++;
                } else if ($value == "fill: green;") {
                    $free ++;
                }
        }
    }

    $data['free'] = $free;
    $data['busy'] = $busy;
    $data['pliberi'] = $free;
    $data['ptotali'] = $free + $busy;
    $data['lati'] = 38.2586593;
    $data['longi'] = 15.5962788;
    $data['nome'] = "Parcheggio di Ingegneria";
    $data['tipofascia'] = 0;



    return json_encode($data);

}

function GetParkingMI()
{

    $limit = 4500;
    $id_resource ='d5d37bee-f2b4-47c9-ba69-0c277d0830c2';

    $url = 'http://smartme-data.unime.it/api/action/datastore_search?resource_id=' . $id_resource . '&limit='. $limit . "&sort=timestamp%20desc";;
   //$url = 'http://smartme-data.unime.it/api/action/datastore_search_sql';
    

    $data2 = call_api($url);

    $result = array();

    try{
            //var_dump($data2->result->records);

         foreach ($data2->result->records as $record) {
             
             $busy = $record->busy;
             $free = $record->free;
             $timestamp = $record->timestamp;
            
             array_push($result, ["id" => $record->_id, "date" => $timestamp, "busy" => +$busy , "free" =>  $free]);
         }

    }catch (Exception $e){
        echo $e;
    }
   //  record_sort($result, "id", true);
    return json_encode($result);
}


function GetLightingMI()
{

    $limit = 1000;
    $id_resource ='9441735c-ba70-4f9c-981b-1bd6bb8090b7';

    $url = 'http://smartme-data.unime.it/api/action/datastore_search?resource_id=' . $id_resource . '&limit='. $limit . "&sort=timestamp%20desc";
   //$url = 'http://smartme-data.unime.it/api/action/datastore_search_sql';
    

    $data2 = call_api($url);

    $result = array();

    try{
            //var_dump($data2->result->records);

         foreach ($data2->result->records as $record) {
             
             $lamps_on = $record->lamps_on;
             $system_usage = $record->system_usage;
             
             $timestamp = $record->timestamp;
            
             array_push($result, ["id" => $record->_id, "date" => $timestamp, "lamps_on" => +$lamps_on, "system_usage" => +$system_usage]);
         }

    }catch (Exception $e){
        echo $e;
    }
   //  record_sort($result, "id", true);
    return json_encode($result);
}


function GetTaxi()
{

    //$package_url = 'http://188.11.217.25:6969/taxi_widget/taxiService.php';
    $package_url = 'http://smartme-data.unime.it/api/3/action/current_package_list_with_resources';

    $data = call_api($package_url);
    echo $data;

    $geojson = array(); //array( "type" => "FeatureCollection", "features" => array());
    $features = array();

    foreach($data->result as $d){


            if($d->organization->title == "taxi"){


                $taxi_id = $d->id;
                $taxi_name = $d->name;
                $data2 = GetLastSample($taxi_id,2);

                if (isset($data2[0]['Longitude'])){
                    $props = array();
                    $date = "";
                    $lng = $data2[0]['Longitude'];
                    $lat = $data2[0]['Latitude'];

                    $i = 0;
                foreach($data2 as $r){
                    if(!($i % 2)){
                        $date = $r['date'];
                        $val = $r['value'] ;



                        array_push($props, array( "sensor" => $r['name'] , "value" =>$r['value'] ));
                    }
                    $i++;
                }

                $real_time = array(
                    'type' => 'Feature',
                    'properties' => array (
                        'id' => $taxi_id,
                        'title' => $taxi_name,
                        'date' => $date,
                        'popupContent' =>  $props
                    ),
                    "geometry" => array (
                        'type' => 'Point',
                        'coordinates' => array($lng,$lat)
                    )
                );
                    $tail = array(
                        'type' => 'Feature',
                        'properties' => array (
                            'id' => $taxi_id . "tail",
                        ),
                        "geometry" => array (
                            'type' => 'LineString',
                            'coordinates' => array( array($lng,$lat), array($data2[2]['Longitude'], $data2[2]['Latitude']), array($data2[5]['Longitude'], $data2[5]['Latitude']))
                        )
                    );

                //return json_encode($real_time, JSON_NUMERIC_CHECK);
                    array_push($features, $real_time);
                    array_push($features, $tail);
                }

        }

    }

    //array_push($geojson['features'], $features);
    //  record_sort($result, "id", true);

    return json_encode($features, JSON_NUMERIC_CHECK);
}


function GetTrack($id_board,$limit,$GeoJSON)
{
    // mi richiamo la board
    $pack_url = 'http://smartme-data.unime.it/api/action/package_show?id=' . $id_board;
    $data = call_api($pack_url);
    $result = array();

    if($GeoJSON){

        $geojson = array( "type" => "FeatureCollection", "features" => array());

        foreach ($data->result->resources as $record) {
            $name = $record->name;
            if (!($name == "sensors")) {
                $sensor_id = $record->id;
                $sensor_url = 'http://smartme-data.unime.it/api/action/datastore_search?resource_id=' . $sensor_id . '&limit=' . $limit . '&sort=Date%20desc';
                $result = call_api($sensor_url);

                $feature = array();

                foreach($result->result->records as $r){
                    /*
                    $feature = array(
                        'type' => 'Feature',
                        'features' => array(
                            'type' => 'Feature',
                            'properties' => array(
                                'title' => $id_board,
                                'date' => $r->Date,
                                'popupContent' => " - -"
                            ),
                            "geometry" => array(
                                'type' => 'Point',
                                'coordinates' => array($r->Latitude,$r->Longitude)
                            )
                        )
                    );
                    */
                    $speed = (property_exists($r, "Speed")) ? $r->Speed : "0";

                    $real_time = array(
                            'type' => 'Feature',
                            'properties' => array(
                                'id' => $id_board,
                                'title' => $id_board,
                                'date' => $r->Date,
                                'popupContent' =>' Speed:  ' . $speed
                            ),
                            "geometry" => array(
                                'type' => 'Point',
                                'coordinates' => array($r->Longitude,$r->Latitude)
                            )
                    );

                    //return json_encode($real_time, JSON_NUMERIC_CHECK);
                    array_push($geojson['features'], $real_time);
                    //array_push($geojson['features'], $feature);
                }
            }

        }
        return json_encode($geojson);
    } else {
        // se no � quello che si vede nella home....
        foreach ($data->result->resources as $record) {
            $name = $record->name;
            if (!($name == "sensors")) {
                $sensor_id = $record->id;
                $sensor_url = 'http://smartme-data.unime.it/api/action/datastore_search?resource_id=' . $sensor_id . '&limit=' . $limit . '&sort=Date%20desc';
                $result = call_api($sensor_url);

                $latlong = array();

                foreach($result->result->records as $r){

                    array_push($latlong, ["lat" => $r->Latitude, "lng" => $r->Longitude, "date" => $r->Date]);
                }
                return json_encode($latlong);
            }
        }

    }
    foreach ($data->result->resources as $record) {
        $name = $record->name;
        if (!($name == "sensors")) {
            $sensor_id = $record->id;
            $sensor_url = 'http://smartme-data.unime.it/api/action/datastore_search?resource_id=' . $sensor_id . '&limit=' . $limit . '&sort=Date%20desc';
            $result = call_api($sensor_url);

            $latlong = array();

            foreach($result->result->records as $r){

                array_push($latlong, ["lat" => $r->Latitude, "lng" => $r->Longitude, "date" => $r->Date]);
            }
            return json_encode($latlong);
            }
        }
    return false;
}

function record_sort($records, $field, $reverse=false)
{
    $hash = array();

    foreach($records as $record)
    {
        $hash[$record[$field]] = $record;
    }

    ($reverse)? krsort($hash) : ksort($hash);

    $records = array();

    foreach($hash as $record)
    {
        $records []= $record;
    }

    return $records;
}
// c'� qualcosa che non va...
echo '{"error": "404"}';

