<?php

$apiKey = '942aa02ec04144e1a15f33731223dadb';

//$ch = curl_init('http://www.bungie.net/Platform/Destiny/2/Account/4611686018449667572/Character/2305843009326654253/Inventory/1475134443/');
$ch = curl_init('http://www.bungie.net/platform/Destiny/Stats/AggregateActivityStats/1/4611686018449667572/2305843009326654253/?definitions=True');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: '.$apiKey));

//echo time();

$ce = curl_exec($ch);
//echo curl_error($ch);
echo $ce;
//$json = json_decode($ce);
//print_r($json);

?>