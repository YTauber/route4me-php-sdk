<?php

namespace Route4Me;

$root = realpath(dirname(__FILE__).'/../../');
require $root.'/vendor/autoload.php';

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_BAIL, 1);

// Set the api key in the Route4Me class
Route4Me::setApiKey('11111111111111111111111111111111');

// Get random route ID
$route = new Route();
$route_id = $route->getRandomRouteId(0, 10);

assert(!is_null($route_id), "Cannot retrieve random route_id");

// Get random address's id from selected route above
$addressRand = (array) $route->GetRandomAddressFromRoute($route_id);
$route_destination_id = $addressRand['route_destination_id'];

assert(!is_null($route_destination_id), "Cannot retrieve random address");

// Add a file note
$noteParameters = [
    'strFilename' => 'notes.csv',
    'route_id' => $route_id,
    'address_id' => $route_destination_id,
    'dev_lat' => 33.132675170898,
    'dev_lng' => -83.244743347168,
    'device_type' => 'web',
    'strUpdateType' => 'ANY_FILE',
];

$address = new Address();

echo "route_id = $route_id <br>";
echo "route_destination_id = $route_destination_id <br><br>";

$address1 = $address->AddNoteFile($noteParameters);

Route4Me::simplePrint($address1);
