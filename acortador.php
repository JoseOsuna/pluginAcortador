<?php 	

/*
Plugin Name: Acortador
Version: 1.0
Author: Jose Osuna
*/

function saca_dominio($url){
    $protocolos[0] = "http://";
    $protocolos[1] = "https://";
    $protocolos[2] = "ftp://";
    $protocolos[3] = "www.";
    // soporte para las url de zippyshare.com las cuales son como por ejemplo  www27.zippyshare.com
    $Contador = 4;
    for ($i=4; $i <= 99 ; $i++) { 
      $protocolos[$Contador] = "www$Contador.";
      $Contador++;
    }
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
}
function extraerURLs($content){
    $regex = '/https?\:\/\/[^\" ]+/i';
    preg_match_all($regex, $content, $partes);
    return ($partes[0]);
}


function acortador($content){

 // toquen de la api del acortador
$token = '79f44fae3d7ae61605d35342b5bb61838ce8c84d'; 
// esteblesco que urls que se acortaran
$dominios = array('depositfiles.com', 'shink.me', 'pasteca.sh', 'adf.ly', 'mega.nz', 'atominik.com', 'kimechanic.com', 'yamechanic.com', 'j.gs', 'openload.co', 'twineer.com','userscloud.com', 'zippyshare.com', 'uploadable.ch','mediafire.com'); 
 
// Llamamos a la función y le pasamos la cadena a buscar
$urls = extraerURLs($content);


foreach($urls as $url){
	// echo "$url <br>";
	$url_dominio = saca_dominio($url);

	if(array_search($url_dominio,$dominios) !== false){

    $urls_originales[] = $url; // almaseno en un array las url que se modificaran que an sifo filtradas por el if

    $url_acortador = 'https://short.pe/full/?api='.$token.'&url='.base64_encode($url).'&type=1';
    // $url_acortador = 'https://tmearn.com/full/?api=a45b4b9b6a3f371dd4331ecf91fafefa334b0e29&url='.base64_encode($url).'&type=2';
    $url_final[] = $url_acortador;
   }
 }
 	if (is_single()) {	
	$content = str_replace($urls_originales, $url_final, $content);
	return $content;
	}
}
add_filter('the_content', 'acortador');
