<?php

$couch_dsn = "http://sigma.ug.edu.pl:14789/";
$couch_db = "nowa";

$client = new couchClient($couch_dsn,$couch_db);

$view = $client->getView("app","widoczek");

$dane = array();
   //print_r($view);
   $cities = array();
foreach ($view->rows as $row) {
   if(!is_array($cities[$row->value[2]])) {
    $cities[$row->value[2]] = array();
   }
   $cities[$row->value[2]][] =$row->value[0].' '.$row->value[1];
}


foreach ($cities as $city => $person) {
    $info = htmlspecialchars(implode(', ', $person), ENT_QUOTES);

    $znacznik[] = <<<EOD
{
            address: '$city',
            title: '$city',

            html: {
                content: '$info',
                popup: false
            }

        },
EOD;
}

$znacznik[count($znacznik)-1] = substr($znacznik[count($znacznik)-1], 0 , -1);
$tmp = array_keys($cities);
$tmp3 = array();
foreach ($tmp as $r) {
    $tmp2[] = '\''.$r.'\'';
    $tmp3[] = count($cities[$r]);
    
}
$wykres['kraje'] = implode(', ', $tmp2);
$wykres['count'] = implode(', ', $tmp3);

//$view = $client->reduce(true)->getView("nowa","count");
