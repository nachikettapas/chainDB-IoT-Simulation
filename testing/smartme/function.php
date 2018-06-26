<?php

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}

function datacb($ch, $data) {
   echo $data;
    return strlen($data);
}

function get_stream ($url, $port=80){

    $img = "http://212.189.207.225:8282/mjpg/video.mjpg";
    //header ('content-type: image/jpeg');

    
    $imginfo = getimagesize($img);
    //header("Content-type: {$imginfo['mime']}");
    echo($img);
    //var_dump($imginfo); 

    return true;


    $ch = curl_init();

    //header("Content-Type:  image/jpeg; boundary: --myboundary");
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PORT, $port);
    curl_setopt($ch, CURLOPT_USERPWD, 'test:test');

    curl_setopt($ch, CURLOPT_HEADER, 0);
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY | CURLAUTH_ANYSAFE );
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 400); //timeout in seconds
    curl_setopt($ch, CURLOPT_BUFFERSIZE, 4096);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_WRITEFUNCTION, "datacb"); 
    
   // $data = curl_exec($ch);
    echo(curl_exec($ch));
//$data = curl_exec($ch);
    curl_close($ch);
//print_r($data);


    return true;
    
}

function get_link ($path){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$path);
    curl_setopt($ch, CURLOPT_FAILONERROR,1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $retValue = curl_exec($ch);          
    curl_close($ch);
    return $retValue;
}


function call_api ($url, $port=80){

    $data = array(
        'Output'    => array()
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PORT, $port);
// Set so curl_exec returns the result instead of outputting it.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//echo curl_exec($ch);
//curl_close($ch);
try{

    if( $data = json_decode(curl_exec($ch))){
        return $data;
    } else {
        $data = json_decode(utf8ize(curl_exec($ch)));
    }

}catch(Exception $e){

    echo $e . "\n<br>";
    echo curl_getinfo($ch);

}


//$data = curl_exec($ch);
    curl_close($ch);
//print_r($data);

    return $data;

}
?>
